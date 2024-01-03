<?php

namespace Validators\Handlers;

class Md5 implements \Validators\Contracts\ValidatorHandler
{
    public function handle($value): bool
    {   
        return preg_match(
            "/^[a-f0-9]{32}$/i",
            $value
        ) && strlen($value) == 32;
    }
}
