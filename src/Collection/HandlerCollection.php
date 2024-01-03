<?php

namespace Validators\Collection;

use Validators\Handler;

class HandlerCollection
{
    /** @param array<Handler> */
    public function __construct(private array $handlers)
    {
    }

    public function count(): int
    {
        return count($this->handlers);
    }

    public function getHandlers(): array
    {
        return $this->handlers;
    }

}