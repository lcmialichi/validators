<?php

namespace Validators\Handlers;

class MinLenght
{

    public function __construct(private $min)
    {
    }

    public function validate($value): bool
    {
        return mb_strlen($value) >= $this->min;
    }
}
