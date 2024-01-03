<?php

namespace Validators\Handlers;

class NotBool implements \Validators\Contracts\ValidatorHandler
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

    public function handle($data): bool
    {
        if ($this->bool !== null) {
            return $data !== $this->bool;
        }

        if (is_bool($data)) {
            return false;
        }
        return true;
    }
}
