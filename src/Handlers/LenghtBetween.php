<?php

namespace Validators\Handlers;

class LenghtBetween implements \Validators\Contracts\ValidatorHandler
{

    public function __construct(private $first, private $last)
    {
    }

    public function handle($value): bool
    {
        $value = mb_strlen($value);
        return $value >= $this->first && $value <= $this->last;
    }
}
