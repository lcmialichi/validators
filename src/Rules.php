<?php

namespace Validators;

use Validators\RuleParser;
use Validators\Collection\RuleCollection;
use Validators\Contracts\ValidatorHandler;
use Validators\Collection\HandlerCollection;
use Validators\Contracts\MessagesRegistration;

abstract class Rules
{
    private array $rules;

    /** @var array<Handler> */
    private array $handlers = [];

    /** @abstract */
    protected abstract function namespaces(): array;

    /** @abstract */
    protected abstract function messages(): array;

    protected function setRules(array $rules = []): void
    {
        $this->rules = $rules;
    }

    protected function getRules(): array
    {
        return $this->rules;
    }

    protected function hasRules(): bool
    {
        return !empty($this->rules);
    }

    protected function handlers(): HandlerCollection
    {
        return new HandlerCollection($this->handlers);
    }

    protected function prepareRules(): void
    {
        foreach ($this->getRules() as $field => $statement) {
            $this->buildHandlersFromRules($field, RuleParser::parse($statement));
        }
    }

    private function buildHandlersFromRules(string $field, RuleCollection $collection): void
    {
        foreach ($collection->rules() as $rule) {
            $handler = $this->findHandlerByRule($rule);
            if ($handler === null) {
                throw new \Exception(sprintf("Handler %s not found", $rule->name()));
            }

            $this->addHandler(
                $rule->name(),
                $handler,
                $rule->arguments(),
                $field
            );
        }
    }

    protected function findHandlerByRule(Rule $rule): ValidatorHandler
    {
        foreach ($this->factories() as $factory) {
            if ($factory->exists($rule->name())) {
                $handler = $factory->getHandler($rule->name(), $rule->arguments());;
            }
        }

        if (!isset($handler) || !$handler) {
            throw new \Exception(sprintf("Handler %s not found", $rule->name()));
        }

        return $handler;
    }

    protected function addHandler(
        string $name,
        ValidatorHandler $handler,
        array $arguments,
        ?string $field = null
    ): void {
        $this->handlers[] = new Handler(
            $name,
            $arguments,
            $handler,
            $this->findMessage($name),
            $field
        );
    }

    protected function findMessage(string $rule): ?string
    {
        var_dump($rule, $this->messages()[$rule] ?? null);
        return $this->messages()[$rule] ?? null;
    }

    /** @return array<Factory> */
    protected function factories(): array
    {
        $factory = [];
        foreach ($this->namespaces() as $namespace) {
            $factory[] = new Factory($namespace);
        }

        return $factory;
    }

}