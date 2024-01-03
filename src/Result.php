<?php

namespace Validators;

class Result
{
    public function __construct(
        private string $rule,
        private bool $status,
        private ?string $message,
        private mixed $value
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
}