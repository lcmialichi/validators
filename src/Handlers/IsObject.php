<?php

namespace Validators\Handlers;

class IsObject implements \Validators\Contracts\ValidatorHandler
{
  public function handle($value): bool
  {
    return is_object($value);
  }
}