<?php

namespace Source\Validators\Handlers;

class Required{

    public function validate($item){
        return isset($item);
    }
}