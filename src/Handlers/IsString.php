<?php

namespace Validators\Handlers;

class IsString implements \Validators\Contracts\ValidatorHandler
{
    public function handle($content)
    {
        return is_string($content);
    }
}
