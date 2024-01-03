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
    protected abstract function namespace (): string;

    /** @abstract */
    protected abstract function message(): MessagesRegistration;

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
            $handler = $this->factory()->getHandler($rule->name(), $rule->arguments());
            $this->addHandler(
                $rule->name(),
                $handler,
                $rule->arguments(),
                $field
            );
        }
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
        return $this->message()->register()[$rule] ?? null;
    }

    protected function factory(): Factory
    {
        return new Factory($this->namespace());
    }

}