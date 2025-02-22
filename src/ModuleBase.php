<?php
declare(strict_types=1);

namespace Rhymix\Modules\Da_reaction\Src;

use ModuleHandler;
use Rhymix\Modules\Da_reaction\Src\Models\ReactionContainer;
use Rhymix\Modules\Da_reaction\Src\Models\ReactionModel;

/**
 * 모듈의 액션을 처리하는 클래스
 *
 * `conf/module.xml` 파일에서 `<actions>` 정의된 `class="Src\ModuleBase"` 속성이 이 클래스를 가리키고 있습니다.
 * `<classes>` 정의에서도 이 클래스를 가리키고 있으므로 이 클래스는 라이믹스 모듈의 기본 클래스로 사용됩니다.
 * 기본 클래스는 `\ModuleObject` 클래스를 상속해야 합니다.
 */
class ModuleBase extends \ModuleObject
{
    public const NOT_REACTABLE = 0;
    public const REACTABLE_ADD = 1;
    public const REACTABLE_REVOKE = 2;
    public const REACTABLE = 3;

    public static string $tableReaction = 'da_reaction';
    public static string $tableReactionChoose = 'da_reaction_choose';

    public static function loadCustomConfig(): array
    {
        $customData = [];

        try {
            if (file_exists(__DIR__ . '/../config.php')) {
                $customData = include __DIR__ . '/../config.php';
            }
        } catch (\Throwable $e) {
            return [];
        }

        // FIXME
        if (!is_array($customData)) {
            return [];
        }

        return $customData;
    }
}
