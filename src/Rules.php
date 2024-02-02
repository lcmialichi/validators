<?php

namespace Validators;

use Validators\RuleParser;
use Validators\Exceptions\RuleException;
use Validators\Collection\RuleCollection;
use Validators\Contracts\ValidatorHandler;
use Validators\Collection\HandlerCollection;
use Validators\Contracts\MessagesRegistration;

abstract class Rules
{
    private array $rules;

    /** @var array<Handler> */
    private array $handlers = [];

    /** 
     * @abstract 
     * @return array<string>
     */
    protected abstract function namespaces(): array;

    /** 
     * @abstract 
     * @return array<MessagesRegistration>
     * */
    protected abstract function messages(): array;

    public function setRules(array $rules = []): void
    {
        $this->handlers = [];
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
            $this->addHandler(
                $rule->name(),
                $this->findHandlerByRule($rule),
                $rule->arguments(),
                $field
            );
        }
    }

    protected function findHandlerByRule(Rule $rule): ValidatorHandler
    {
        foreach ($this->factories() as $factory) {
            if ($factory->exists($rule->name())) {
                $handler = $factory->getHandler($rule->name(), $rule->arguments());
            }
        }

        if (!isset($handler) || !$handler) {
            throw new RuleException(sprintf("Handler %s not found", $rule->name()));
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