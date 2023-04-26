<?php

namespace Validators;

use Validators\Foundation\ConfigBag;
use Validators\Foundation\HandlersBag;

class Validator
{
    private ConfigBag $configs;
    private HandlersBag $handlers;
    private array $activeRules = [];

    public function __construct(array $config = [])
    {
        $this->configs = new ConfigBag($config);
        $this->handlers = new HandlersBag(
            $this->configs->getFromDefault('handlers.namespace') ?? null,
            $this->configs->getFromDefault('app-root') ?? null,
        );

        if ($messages = $this->configs->getFromDefault('messages.path')) {
            $this->setMessagesPath($messages);
        }
    }

    public function setMessagesPath(string $path): self
    {
        if (file_exists($path)) {
            $messages = require $path;
            if (!is_array($messages)) {
                throw new \RuntimeException("invalid messages file!");
            }

            $this->handlers->setMessages($messages);
            return $this;
        }

        throw new \RuntimeException("invalid path to messages file!");
    }

    public function setMessages(array $messages): self
    {
        $this->handlers->setMessages($messages);
        return $this;
    }

    public function setHandlersNamespace(string $namespace): self
    {
        $this->handlers->load(
            $namespace,
            $this->configs->get("app-root")
        );
        return $this;
    }


    public function __call($name, $values)
    {
        $name = pascalCase($name);
        if ($this->has($name)) {
            $validator = $this->get($name);
            $validator["parameters"] = $values;
            $this->setActiveRules($validator);
            return $this;
        }

        throw new \Exception("Regra de validação não encontrada!");
    }

    public function validate(mixed ...$values): Errors
    {
        $errors = new Errors;
        foreach ($values as $value) {
            foreach ($this->activeRules as $key => $rules) {
                $handler = $rules["execution"]($rules["parameters"])->validate($value);
                if (!$handler) {
                    $errors->add([
                        "message" => $rules["message"],
                        "name" => $rules["name"],
                        "field" => $key
                    ]);
                }
            };
        }
        $this->refresh();
        return $errors;
    }

    private function get(string $rule)
    {
        return $this->handlers->get($rule);
    }

    public function has(string $rule)
    {
        return $this->handlers->has($rule);
    }

    private function setActiveRules(array $rules)
    {
        $this->activeRules[] = $rules;
    }

    private function refresh()
    {
        $this->activeRules = [];
    }
}
