<?php

namespace Validators\Handlers;

class Between
{

    public function __construct(private $first, private $last)
    {
    }

    public function validate($value): bool
    {
        $value = mb_strlen($value);
        return $value >= $this->first && $value <= $this->last;
    }
}
