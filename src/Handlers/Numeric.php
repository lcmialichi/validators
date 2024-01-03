<?php

namespace Validators\Handlers;

class Numeric implements \Validators\Contracts\ValidatorHandler
{
    public function handle($value): bool
    {
        return is_numeric($value);
    }
}
