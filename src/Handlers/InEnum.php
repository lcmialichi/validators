<?php

namespace Source\Validators\Handlers;

class InEnum
{

    private $enum;

    public function __construct(string $enum)
    {
        $this->enum = $enum;
    }

    public function validate($value): bool
    {
        return $this->enum::tryFrom($value) != null;
    }
}
