<?php

namespace Validators\Handlers;

class Between implements \Validators\Contracts\ValidatorHandler
{

    public function __construct(private $first, private $last)
    {
    }

    public function handle($value): bool
    {
        if (!is_int($value) && !is_float($value)) {
            return false;
        }

        return $value >= $this->first && $value <= $this->last;
    }
}
