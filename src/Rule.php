<?php

namespace Validators;

class Rule
{
    public function __construct(
        private string $name,
        private array $arguments,
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function arguments(): array
    {
        return $this->arguments;
    }
}
