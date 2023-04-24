<?php

namespace Source\Validators\Handlers;

class Date
{

    public function __construct(private string $format){

    }

    public function validate($value): bool
    {
        return \DateTime::createFromFormat($this->format, $value) !== false;
    }
}
