<?php

namespace Validators\Handlers;

class Length implements \Validators\Contracts\ValidatorHandler
{
    public function __construct(private int $numeric)
    {
    }

    public function handle($value): bool
    {
        if (is_array($value) || is_object($value)) {
            return count($value) == $this->numeric;
        }

        if(!is_string($value)){
            return false;
        }

        return strlen($value) == $this->numeric;
    }
}
