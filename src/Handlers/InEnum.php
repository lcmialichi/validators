<?php

namespace Validators\Handlers;

class InEnum implements \Validators\Contracts\ValidatorHandler
{
    private $enum;

    public function __construct(string $enum)
    {
        $this->enum = $enum;
    }

    public function handle($value): bool
    {
        return $this->enum::tryFrom($value) != null;
    }
}
