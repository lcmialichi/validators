<?php

namespace Validators\Collection;

use Validators\Result;
use Validators\Exceptions\ValidationException;

class ResultCollection
{

    /** @param array<Result> $errors */
    /** @param array<Result> $success */
    public function __construct(
        private array $errors = [],
        private array $success = []
    ) {
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getSuccess(): array
    {
        return $this->success;
    }

    public function failed(): bool
    {
        return $this->countFails() > 0;
    }

    public function succeded(): bool
    {
        return $this->countSuccess() > 0 && !$this->failed();
    }

    public function countFails(): int
    {
        return count($this->getErrors());
    }

    public function countSuccess(): int
    {
        return count($this->getSuccess());
    }

    public function getErrorsMessages(): array
    {
        return $this->mapFailures(fn($result) => $result->message());
    }

    public function mapSuccess(callable $callback): array
    {
        return array_map($callback, $this->getSuccess());
    }

    public function mapFailures(callable $callback): array
    {
        return array_map($callback, $this->getErrors());
    }

    public function failedOnRule(string $rule): bool
    {
        return $this->mapFailures(fn($error) => $error->getRule() == $rule) > 0;
    }

    public function getFirstError(): ?Result
    {
        return $this->getErrors()[0] ?? null;
    }

    public function throwOnFirstError()
    {
        if ($this->failed()) {
            throw new \Exception($this->getFirstError()->getMessage());
        }
        return false;
    }

}