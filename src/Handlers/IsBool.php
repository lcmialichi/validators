<?php

namespace Validators\Handlers;

class IsBool
{

    private ?bool $bool;

    public function __construct(?string $bool = null)
    {   
        $this->bool = match($bool){
            "true" => true,
            "false" => false,
            default => null
        };
    }

    public function validate($data)
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