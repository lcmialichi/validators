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
        return $this->mapFailures(fn($result) => $result->getMessage());
    }

    public function mapSuccess(callable $callback): array
    {
        return array_map($callback, $this->getSuccess());
    }

    public function mapFailures(callable $callback): array
    {
        return array_map($callback, $this->getErrors());
    }

    public function getFromFails(callable $callback): array
    {
        return array_filter($this->getErrors(), $callback);
    }

    public function getFromSuccess(callable $callback): array
    {
        return array_filter($this->getSuccess(), $callback);
    }

    public function failedOnRule(string $rule): bool
    {
        return !empty($this->getFromFails(fn($error) => $error->getRule() == $rule));
    }

    public function getFirstError(): ?Result
    {
        return $this->getErrors()[0] ?? null;
    }

    public function throwOnFirstError()
    {
        if ($this->failed()) {
            throw new ValidationException($this->getFirstError()->getMessage());
        }
        return false;
    }

    public function failedOnField(string $field): bool
    {
        return !empty($this->getFromFails(fn($error) => $error->getField() == $field));
    }

    public function add(ResultCollection $collection): void
    {
        $this->errors = array_merge($this->errors, $collection->getErrors());
        $this->success = array_merge($this->success, $collection->getSuccess());
    }

}