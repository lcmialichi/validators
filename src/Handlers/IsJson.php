<?php


namespace Validators\Handlers;

class IsJson implements \Validators\Contracts\ValidatorHandler
{
    public function handle($data)
    {
        return json_decode($data) !== null;
    }
}
