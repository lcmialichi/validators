<?php

namespace Source\Validators\Handlers;

class Md5
{
    public function validate($value)
    {   
        return preg_match(
            "/^[a-f0-9]{32}$/i",
            $value
        ) && strlen($value) == 32;
    }
}
