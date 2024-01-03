<?php

namespace Validators;

use Validators\Rules;
use Validators\Message\Messages;
use Validators\Collection\ResultCollection;
use Validators\Contracts\MessagesRegistration;

class Validator extends Rules
{
    private MessagesRegistration $messages;

    private string $namespace;

    public function __construct(array $rules = [])
    {
        $this->setRules($rules);
        $this->setNamespaceHandler("\\Validators\\Handlers");
        $this->registerMessages(new Messages);
    }

    public static function rules(array $rules, array $values): ResultCollection
    {
        return (new self($rules))->validate($values);
    }

    public function setNamespaceHandler(string $namespace)
    {
        $this->namespace = $namespace;
    }

    public function registerMessages(MessagesRegistration $messages)
    {
        $this->messages = $messages;
    }

    /** @inheritDoc */
    protected function message(): MessagesRegistration
    {
        return $this->messages;
    }
    
    /** @inheritDoc */
    protected function namespace (): string
    {
        return $this->namespace;
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
        $handler = $this->factory()->getHandler($name, $arguments);
        $this->addHandler($name, $handler, $arguments);
        return $this;
    }

}