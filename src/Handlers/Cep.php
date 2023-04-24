<?php

namespace Validators\Handlers;


class Cep{

    public function validate($item){
        return preg_match("/[0-9]{5}[\d]{3}/",str_replace("-","", $item));
    }
}