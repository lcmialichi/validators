<?php


namespace Validators;

use Validators\Contracts\ValidatorHandler;

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
        return pascalCase($name);
    }

    public function exists(string $method): bool
    {
        return class_exists($this->getNamespace() . "\\" . $this->createMethod($method));
    }

    public function getHandler(string $method, array $args)
    {
        if ($this->exists($method)) {
            $instance = $this->instantiate($method, $args);
            if ($instance instanceof ValidatorHandler) {
                return $instance;
            }

            throw new \Exception(sprintf("Handler %s must implemnt %s", $method, ValidatorHandler::class));
        }

        throw new \Exception(sprintf("rule '%s' not found", $method));
    }

    private function instantiate(string $method, array $args = []): object
    {
        $class = $this->getNamespace() . "\\" . $this->createMethod($method);
        return new $class(...$args);
    }

}