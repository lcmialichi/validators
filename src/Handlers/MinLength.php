<?php

namespace Validators\Handlers;

class MinLength implements \Validators\Contracts\ValidatorHandler
{
    public function __construct(private $min)
    {
    }

    public function handle($value): bool
    {
        if(!is_string($value) && !is_int($this->min)){
            return false;
        }
        
        return mb_strlen($value ?? "") >= $this->min;
    }
}
