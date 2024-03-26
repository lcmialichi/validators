<?php

namespace Validators\Handlers;

class IntReserved_ implements \Validators\Contracts\ValidatorHandler
{
    public function handle($content): bool
    {
        return is_int($content);
    }
    
}
