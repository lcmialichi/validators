<?php

namespace Source\Validators\Handlers;

class IsString
{

    public function validate($content)
    {
        return is_string($content);
    }
}
