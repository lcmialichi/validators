<?php

namespace Validators;

use Validators\Foundation\ConfigBag;
use Validators\Foundation\HandlersBag;

class Validator
{
    private ConfigBag $configs;
    private HandlersBag $handlers;

    public function __construct(array $config = [])
    {
        $this->configs = new ConfigBag($config);
        $this->handlers = new HandlersBag(
            $this->configs->getFromDefault('handlers.namespace') ?? null,
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
        $this->handlers->load($namespace);
        return $this;
    }

    public function get()
    {
        return $this->configs->get();
    }
}
