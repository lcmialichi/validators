<?php

namespace Validators\Handlers;

class ArrayReserved_ implements \Validators\Contracts\ValidatorHandler
{
  public function handle($value): bool
  {
    if (!isset($value)) {
      return false;
    }
    
    return is_array($value);
  }
}
