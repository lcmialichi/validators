<?php

namespace Validators\Handlers;

class LengthBetween implements \Validators\Contracts\ValidatorHandler
{

    public function __construct(private $first, private $last)
    {
    }

    public function handle($value): bool
    {
        if(!is_string($value)){
            return false;
        }
        
        $value = mb_strlen($value);
        return $value >= $this->first && $value <= $this->last;
    }
}
