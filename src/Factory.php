<?php


namespace Validators;

use Validators\Contracts\ValidatorHandler;
use Validators\Exceptions\HandlerException;

class Factory
{
    public function __construct(private string $namespace)
    {
    }

    private function getNamespace(): string
    {
        return $this->namespace;
    }

    public function createMethod(string $name): string
    {
        $word = pascalCase($name);
        if (reserved($name)) {
            $word .= "Reserved_";
        }
        return $word;
    }

    public function exists(string $method): bool
    {
        return class_exists($this->getNamespace() . "\\" . $this->createMethod($method));
    }

    public function getHandler(string $method, array $args): ValidatorHandler|bool
    {
        if ($this->exists($method)) {
            $instance = $this->instantiate($method, $args);
            if ($instance instanceof ValidatorHandler) {
                return $instance;
            }

            throw new HandlerException(sprintf("Handler %s must implemnt %s", $method, ValidatorHandler::class));
        }

        return false;
    }

    private function instantiate(string $method, array $args = []): object
    {
        $class = $this->getNamespace() . "\\" . $this->createMethod($method);
        return new $class(...$args);
    }

}