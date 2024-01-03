<?php

namespace Validators\Handlers;

class IsBool implements \Validators\Contracts\ValidatorHandler
{
    private ?bool $bool;

    public function __construct(?string $bool = null)
    {
        $this->bool = match ($bool) {
            "true" => true,
            "false" => false,
            default => null
        };
    }

    public function handle($data)
    {
        if ($this->bool !== null) {
            return $data === $this->bool;
        }

        if (is_bool($data)) {
            return true;
        }
        return false;
    }
}
