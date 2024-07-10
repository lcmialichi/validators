<?php

namespace Validators\Handlers;

class Nullable implements \Validators\Contracts\ValidatorHandler
{
    private bool $break = false;

    public function handle($value): bool
    {
        if (is_null($value)) {
            $this->break = true;
        }

        return true;
    }

    public function break(): bool
    {
        return $this->break;
    }
}
