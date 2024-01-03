<?php

namespace Validators\Handlers;

class IsArray implements \Validators\Contracts\ValidatorHandler
{
  public function handle($value): bool
  {
    return is_array($value);
  }
}