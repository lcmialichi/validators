<?php

use Validators\Validator;

require_once __DIR__ . "/vendor/autoload.php";

$validator = new Validator;

// $validator->setMessagesPath( "teste");
var_dump($validator->between(1,10)->validate("aaaaaaaaaaaaaaaaaaaaaaaaaaaa"));