<?php

namespace Rhymix\Modules\Da_reaction\Src\Exceptions;

class ReactionLimitExceededException extends \Rhymix\Framework\Exception
{
    protected int $limit;

    public function __construct(int $limit, string $message = '', \Throwable $previous = null)
    {
        $this->limit = $limit;
        $message = $message ?: "리액션은 최대 {$limit}개까지 가능합니다.";

        parent::__construct($message, -1, $previous);
    }

    public function getLimit(): int
    {
        return $this->limit;
    }
}
