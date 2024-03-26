<?php

namespace Validators\Handlers;

class BoolReserved_ implements \Validators\Contracts\ValidatorHandler
{
    public function handle($data): bool
    {
        return is_bool($data);
    }
}
