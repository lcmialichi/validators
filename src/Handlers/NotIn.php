<?php

namespace Source\Validators\Handlers;

class NotIn{

    private $equals;

    public function __construct(...$equals){
        $this->equals = $equals;
    }

    public function validate($value) : bool{
        
      return !in_array($value, $this->equals);
    }
}