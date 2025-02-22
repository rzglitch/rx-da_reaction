<?php
declare(strict_types=1);

namespace Rhymix\Modules\Da_reaction\Src;

use Context;
use ModuleHandler;
use Rhymix\Modules\Da_reaction\Src\Models\ReactionModel;

class EventHandler extends ModuleBase
{
    /**
     * 트리거를 이용해 관리자 대시보드에 출력하는 예제
     *
     * @see \ModuleHandler::triggerCall()
     */
    public static function adminDashboard(object $object): void
    {
        $html = <<<HTML
        <section style="background-color: #eff6ff;">
            <h2>Example1 모듈</h2>
            <p style="padding: 10px;">Example1 모듈의 `EventHandler::adminDashboard()`에서 출력</p>
            <p style="padding: 10px;">Example1 모듈이 활성화되면 출력됨</p>
        </section>
        HTML;

        array_unshift($object->right, $html);
    }

    /**
     * @param object $object
     */
    public static function ListenerModuleHandlerProcAfter($object): void
    {
        if (Context::getResponseMethod() !== 'HTML') {
            return;
        }

        // FIXME
        if ($object->module !== 'board' || $object->act !== 'dispBoardContent') {
            return;
        }

        $requestDocumentSrl = intval(Context::get('document_srl'));

        if (!$requestDocumentSrl) {
            return;
        }

        $moduleSrl = intval($object->module_srl);
        $memberSrl = intval(Context::get('logged_info')->member_srl);
        $isAdmin = Context::get('logged_info')->is_admin === 'Y';
        $memberInfo = json_encode([
            'memberId' => $memberSrl,
            'isAdmin' => $isAdmin,
        ]);


        $reactions = ReactionModel::getReactionsByParentId(
            ReactionHelper::generateIdByDocument($moduleSrl, intval($requestDocumentSrl)),
            intval(Context::get('logged_info')->member_srl)
        );

        $modulePath = ModuleHandler::getModulePath('da_reaction');
        Context::loadFile(["{$modulePath}public/assets/alpinejs.3.14.8.min.js", 'body']);
        Context::loadFile(["{$modulePath}public/assets/da_reaction.js", 'head']);
        Context::loadFile(["{$modulePath}public/assets/da_reaction.css"]);

        $data = [
            'categories' => [
                ['category' => 'emoji', 'title' => '이모지', 'renderType' => 'emoji'],
                ['category' => 'image', 'title' => '이미지', 'renderType' => 'image'],
                ['category' => 'import-image', 'title' => '이미지', 'renderType' => 'image'],
            ],
            'emoticons' => [],
            'alias' => [],
        ];
        $custom = ModuleBase::loadCustomConfig();
        $data = array_merge_recursive($data, $custom);
        if (!$data['emoticons']) {
            $data['emoticons'] = [
                ['reaction' => 'emoji:1f44d'], // 👍
                ['reaction' => 'emoji:1f44e'], // 👎
                ['reaction' => 'emoji:1f606'], // 😆
                ['reaction' => 'emoji:1f62e'], // 😮
                ['reaction' => 'emoji:1f622'], // 😢
                ['reaction' => 'emoji:1f621'], // 😡
            ];
        }
        $data['emoticons'] = array_merge($data['emoticons'], ReactionHelper::getImportImages());

        $oModel = new ReactionModel();

        $reactionData = $oModel->getReactionsByParentId("document:{$moduleSrl}:{$requestDocumentSrl}", $memberSrl);

        $categories = json_encode($data['categories']);
        $emoticons = json_encode($data['emoticons']);
        $alias = json_encode($data['alias']);
        $endpoints = json_encode([
            'react' => str_replace('&amp;', '&', getUrl('', 'module', 'da_reaction', 'act', 'procDa_reactionReact')),
        ]);
        $reactionData = json_encode($reactionData);

        $headContent = <<<HTML
        <script>
        document.addEventListener('daReaction:init', function (e) {
            const daReaction = e.detail;
            daReaction.setMemberInfo({$memberInfo});
            daReaction.setEndpoints({$endpoints});
            daReaction.addCategories({$categories});
            daReaction.addEmoticons({$emoticons});
            daReaction.addAlias({$alias});
            daReaction.setReactions({$reactionData});
        });
        </script>
        HTML;

        $headContent .= <<<'HTML'
        <div x-data="daReactionPopover" class="da-reaction-popover" x-show="open" tabindex="-1" x-ref="daReactionPopover" x-cloak x-transition @click.outside="hide()" aria-hidden="true">
            <div class="da-reaction">
                <template x-for="item in emoticons" :key="item.reaction">
                    <span role="button" tabindex="0" class="da-reaction__badge" @click="react(item.reaction, 'add')" @keyup.enter="react(item.reaction, 'add')">
                        <template x-if="item.renderType === 'emoji'">
                            <span class="da-reaction__emoji" x-text="item.emoji"></span>
                        </template>
                        <template x-if="item.renderType === 'image'">
                            <img x-bind:src="item.url" loading="lazy" :alt="`이모티콘: ${item . reaction}`" />
                        </template>
                    </span>
                </template>
            </div>
        </div>
        HTML;

        Context::addHtmlHeader($headContent);

        /** @var \ModuleController */
        $moduleControler = getController('module');
        $moduleControler->addTriggerFunction('display', 'after', self::class . '::ListenerDisplay');
    }

    public static function ListenerDisplay(string &$content): void
    {
        if (Context::getResponseMethod() !== 'HTML') {
            return;
        }

        $moduleInfo = Context::get('module_info');
        if ($moduleInfo->module !== 'board') {
            return;
        }

        $moduleSrl = intval($moduleInfo->module_srl);
        $documentSrl = null;

        $requestDocumentSrl = intval(Context::get('document_srl'));

        if ($requestDocumentSrl) {
            preg_match_all('/<!--AfterDocument\((?<srl>[0-9]+),([0-9]+)\)-->/', $content, $matches);
            $documentSrl = $matches['srl'][0] ?? null;
        }

        if (!$documentSrl) {
            return;
        }



        // 문서 리액션
        if (stripos($content, "daReaction('" . ReactionHelper::generateIdByDocument($moduleSrl, intval($documentSrl)) . "'") === false) {
            $targetId = ReactionHelper::generateIdByDocument($moduleSrl, intval($documentSrl));
            $tag = '<div class="da-reaction" x-da-reaction-print x-data="daReaction(\'' . $targetId . '\')"></div>';
            $content = preg_replace('/<!--AfterDocument\([0-9]+,[0-9]+\)-->/', "$tag\$0", $content) ?? $content;
        }

        // 댓글 리액션
        preg_match_all('/<!--AfterComment\((?<srl>[0-9]+),([0-9]+)\)-->/', $content, $matches);
        $commentSrlArray = $matches['srl'];
        foreach ($commentSrlArray as $commentSrl) {
            if (stripos($content, "daReaction('" . ReactionHelper::generateIdByComment($moduleSrl, intval($commentSrl), intval($documentSrl)) . "'") === false) {
                $targetId = ReactionHelper::generateIdByComment($moduleSrl, intval($commentSrl), intval($documentSrl));
                $tag = '<div class="da-reaction" x-da-reaction-print x-data="daReaction(\'' . $targetId . '\')"></div>';
                $content = preg_replace('/<!--AfterComment\(' . $commentSrl . ',[0-9]+\)-->/', "$tag\$0", $content) ?? $content;
            }
        }
    }
}
