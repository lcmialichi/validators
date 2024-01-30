<?php

namespace Validators;

use Validators\Rules;
use Validators\Message\Messages;
use Validators\Collection\ResultCollection;
use Validators\Contracts\MessagesRegistration;

class Validator extends Rules
{
    private array $messages = [];

    private array $namespaces = [];

    public function __construct(array $rules = [])
    {
        $this->setRules($rules);
        $this->addNamespaceHandler("\\Validators\\Handlers");
        $this->registerMessages(new Messages);
    }

    public static function rules(array $rules, array $values): ResultCollection
    {
        return (new self($rules))->validate($values);
    }

    public function addNamespaceHandler(string $namespace)
    {
        $this->namespaces[] = $namespace;
    }

    public function registerMessages(MessagesRegistration $messages): void
    {
        $this->messages = array_merge($this->messages, $messages->register());
    }

    /** @inheritDoc */
    protected function messages(): array
    {
        return $this->messages;
    }
    
    /** @inheritDoc */
    protected function namespaces (): array
    {
        return $this->namespaces;
    }

    public function validate(mixed ...$values) : ResultCollection
    {
        if ($this->hasRules()) {
            $this->prepareRules();
        }

        $dispatch = Dispatch::createDispatch(
            $this->handlers()
        );

        return $dispatch->run($values);
    }

    public function __call(string $name, array $arguments)
    {
        $handler = $this->findHandlerByRule(new Rule($name, $arguments));
        $this->addHandler($name, $handler, $arguments);
        return $this;
    }

}