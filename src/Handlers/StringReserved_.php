<?php

namespace Validators\Handlers;

class StringReserved_ implements \Validators\Contracts\ValidatorHandler
{
    public function handle($content): bool
    {
        return is_string($content);
    }
}
