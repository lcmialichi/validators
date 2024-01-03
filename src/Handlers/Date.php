<?php

namespace Validators\Handlers;

class Date implements \Validators\Contracts\ValidatorHandler
{
    public function __construct(private string $format)
    {
    }

    public function handle($value): bool
    {
        return \DateTime::createFromFormat($this->format, $value) !== false;
    }
}
