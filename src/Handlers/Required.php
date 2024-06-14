<?php

namespace Validators\Handlers;

class Required implements \Validators\Contracts\ValidatorHandler
{
    private bool $break;

    public function handle($item): bool
    {
        $this->setBreak(!$isset = isset($item));
        return $isset;
    }

    public function break(): bool
    {
        return $this->break;
    }

    private function setBreak(bool $break): void
    {
        $this->break = $break;
    }
}