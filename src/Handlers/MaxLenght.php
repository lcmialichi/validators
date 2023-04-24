<?php

namespace Validators\Handlers;

class MaxLenght
{

    public function __construct(private $min)
    {
    }

    public function validate($value): bool
    {
        return mb_strlen($value) <= $this->min;
    }
}
