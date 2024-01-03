<?php

namespace Validators\Collection;

class RuleCollection
{
    public function __construct(private array $rules = [])
    {
    }

    public function rules(): array
    {
        return $this->rules;
    }
}