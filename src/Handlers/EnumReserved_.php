<?php

namespace Validators\Handlers;

class EnumReserved_ implements \Validators\Contracts\ValidatorHandler
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
