<?php

namespace Validators\Contracts;

interface ValidatorHandler
{
    public function handle(mixed $content): bool;
}