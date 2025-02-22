<?php

namespace Rhymix\Modules\Da_reaction\Src\Exceptions;

class TargetIdTooLongException extends \Rhymix\Framework\Exception
{
    public function __construct(string $message = "", int $code = 0, \Throwable $previous = null)
    {
        $message = $message ?: lang('da_reaction_exception_target_id_too_long');

        parent::__construct($message, $code, $previous);
    }
}
