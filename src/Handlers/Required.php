<?php

namespace Validators\Handlers;

class Required implements \Validators\Contracts\ValidatorHandler
{
    public function handle($item): bool
    {
        return isset($item);
    }
}