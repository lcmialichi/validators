<?php

namespace Validators\Handlers;

class In implements \Validators\Contracts\ValidatorHandler
{
  private $equals;

  public function __construct(...$equals)
  {
    $this->equals = $equals;
  }

  public function handle($value): bool
  {
    return in_array($value, $this->equals);
  }
}