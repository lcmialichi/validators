<?php

namespace Validators\Handlers;

class MaxLength implements \Validators\Contracts\ValidatorHandler
{
    public function __construct(private $max)
    {
    }

    public function handle($value): bool
    {
        if(!is_string($value)){
            return false;
        }
        
        return mb_strlen($value ?? "") <= $this->max;
    }
}
