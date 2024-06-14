<?php

namespace Validators\Handlers;

class Md5 implements \Validators\Contracts\ValidatorHandler
{
    public function handle($value): bool
    {   
        if(!is_string($value)){
            return false;
        }
        
        return preg_match(
            "/^[a-f0-9]{32}$/i",
            $value
        ) && strlen($value) == 32;
    }
}
