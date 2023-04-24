<?php

namespace Validators\Handlers;

class Length
{

    public function __construct(private int $numeric)
    {
    }

    public function validate($value): bool
    {
        if (is_array($value) || is_object($value)) {
            return count($value) == $this->numeric;
        }

        return strlen($value) == $this->numeric;
    }
}
