<?php

namespace Validators;

use Validators\Contracts\ValidatorHandler;

class Handler
{
    public function __construct(
        private string $name,
        private ?array $arguments,
        private ValidatorHandler $handler,
        private ?string $message,
        private ?string $field
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function field(): ?string
    {
        return $this->field;
    }

    public function arguments(): ?array
    {
        return $this->getArgumentsName($this->arguments);
    }

    public function handler(): ValidatorHandler
    {
        return $this->handler;
    }

    public function argumentCount(): int
    {
        return count($this->arguments);
    }

    public function message(): ?string
    {
        return $this->message;
    }

    private function getArgumentsName(?array $args): array
    {
        $arguments = [];
        foreach ($this->buildArgumentReflection() as $argument) {
            if ($argument->isVariadic()) {
                $arguments[$argument->getName()] = implode(", ", $this->removeUnscalarTypes($args));
                break;
            }
            $arguments[$argument->getName()] = array_shift($args);
        }
        return $arguments;
    }

    private function removeUnscalarTypes(array $args): array
    {
        return array_map(function ($arg) {
            return !is_scalar($arg) ? gettype($arg) : $arg;
        }, $args);
    }

    /** @return array<\ReflectionParameter> */
    private function buildArgumentReflection(): array
    {
        $handlerReflected = new \ReflectionClass($this->handler());
        return $handlerReflected->getConstructor()?->getParameters() ?? [];
    }
}