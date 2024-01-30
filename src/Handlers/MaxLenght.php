<?php

namespace Validators\Handlers;

class MaxLenght implements \Validators\Contracts\ValidatorHandler
{
    public function __construct(private $min)
    {
    }

    public function handle($value): bool
    {
        return mb_strlen($value ?? "") <= $this->min;
    }
}
