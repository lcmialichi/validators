<?php


namespace Validators\Handlers;

class JsonReserved_ implements \Validators\Contracts\ValidatorHandler
{
    public function handle($data)
    {
        return json_decode($data) !== null;
    }
}
