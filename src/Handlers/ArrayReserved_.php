<?php

namespace Validators\Handlers;

class ArrayReserved_ implements \Validators\Contracts\ValidatorHandler
{
  public function handle($value): bool
  {
    return is_array($value);
  }
}