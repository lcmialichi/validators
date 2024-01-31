<?php

namespace Validators\Handlers;

class MinLength implements \Validators\Contracts\ValidatorHandler
{
    public function __construct(private $min)
    {
    }

    public function handle($value): bool
    {
        return mb_strlen($value ?? "") >= $this->min;
    }
}
