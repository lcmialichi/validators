<?php

namespace Validators\Foundation;

use Validators\NamespaceLoader;

class HandlersBag
{
    /**
     * @var array
     */
    private array $handlers = [];
    /**
     * @var array
     */
    private array $messages = [];

    public function __construct(?string $namespace = null)
    {
        if ($namespace) {
            $this->load($namespace);
        }
    }

    public function load(string $namespace)
    {
        $loader = new NamespaceLoader($namespace, true);
        $classes = $loader->load();

        array_map(
            function ($class) {
                $breakNamespace = explode("\\", $class);
                $name = lcfirst(pascalCase(end($breakNamespace)));
                $ruleName = explode("\\", $class);
                $this->handlers[end($ruleName)] = [
                    "execution" => fn (array $parameters) => new $class(...$parameters),
                    "name" => $name,
                    "message" => dot($name, $this->messages)
                ];
            },
            $classes
        );
    }

    public function setMessages(array $messages)
    {
        foreach($messages as $rule => $message){

            if($this->has(pascalCase($rule))){
                $this->handlers[pascalCase($rule)]["message"] = $message;
            }
        }
        $this->messages = array_merge($this->messages, $messages);
    }

    public function get(string $rule){
        return $this->handlers[$rule];
    }

    public function has(string $rule)
    {
        return array_key_exists($rule, $this->handlers);
    }
}
