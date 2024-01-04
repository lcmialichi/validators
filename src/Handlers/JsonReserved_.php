<?php


namespace Validators\Handlers;

class JsonReserved_ implements \Validators\Contracts\ValidatorHandler
{
    public function handle($data): bool
    {
        return json_decode($data) !== null;
    }
}
