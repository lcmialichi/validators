<?php

namespace Source\Validators\Handlers;

class IsObject{

    public function validate($value) : bool{
      return is_object($value);
    }
}