<?php
declare(strict_types=1);

namespace Rhymix\Modules\Da_reaction\Src\Controllers;

use Rhymix\Framework\Exceptions\MustLogin;
use Rhymix\Framework\Helpers\SessionHelper;
use Rhymix\Modules\Da_reaction\Src\Models\ReactionModel;
use Rhymix\Modules\Da_reaction\Src\ModuleBase;
use Rhymix\Modules\Da_reaction\Src\ReactionHelper;

class ReactionController extends ModuleBase
{
    /**
     * 리액션 추가 및 취소
     *
     * @throws MustLogin
     */
    public static function react(SessionHelper $member, string $reactionMode, string $reaction, string $targetId, string $parentId): bool
    {
        if (!$member->isMember()) {
            throw new MustLogin();
        }

        ReactionHelper::validateReactionId($reaction);
        ReactionHelper::validateTargetId($targetId);
        if ($parentId) {
            ReactionHelper::validateTargetId($parentId);
        }

        // 리액션 제한 확인
        $reactable = ReactionModel::reactable($targetId, $reaction, $member);

        if ($reactionMode === 'toggle' && $reactable ^ ModuleBase::REACTABLE_ADD) {
            return ReactionModel::revokeReaction($member->member_srl, $reaction, $targetId);
        } else if ($reactable & ModuleBase::REACTABLE_ADD) {
            return ReactionModel::addReaction($member->member_srl, $reaction, $targetId, $parentId);
        }

        return false;
    }
}
