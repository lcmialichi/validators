<?php


namespace Validators\Handlers;

class JsonReserved_ implements \Validators\Contracts\ValidatorHandler
{
    public function handle($data): bool
    {
        if(!is_string($data)){
            return false;
        }
        
        return json_decode($data) !== null;
    }
}
