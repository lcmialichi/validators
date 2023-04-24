<?php

namespace Validators;

use Validators\Foundation\ConfigBag;

class Validator
{
    private ConfigBag $configs;

    public function __construct( array $config = [])
    {
        $this->configs = new ConfigBag($config);
    }


}
