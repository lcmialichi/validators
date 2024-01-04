<?php

namespace Validators\Handlers;

class ObjectReserved_ implements \Validators\Contracts\ValidatorHandler
{
  public function handle($value): bool
  {
    return is_object($value);
  }
}