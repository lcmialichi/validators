<?php

namespace Validators\Handlers;


class Cep implements \Validators\Contracts\ValidatorHandler
{
    public function handle($item): bool
    {
        return preg_match("/[0-9]{5}[\d]{3}/", str_replace("-", "", $item));
    }
}