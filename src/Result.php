<?php

namespace Validators;

class Result
{
    public function __construct(
        private string $rule,
        private bool $status,
        private ?string $message,
        private mixed $value,
        private mixed $arguments,
        private ?string $field = null
    ){}

    public function getRule(): string
    {
        return $this->rule;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getArguments(): mixed
    {
        return $this->arguments;
    }

    public function getField(): ?string
    {
        return $this->field;
    }
}