<?php

use Validators\Validator;

require_once __DIR__ . "/vendor/autoload.php";

$validator = new Validator;

$error = $validator->between(1, 10)->validate("aaaaaaaaaaaaaaaaaaaaaaaaaaaa");

if($error->fails()){
    $error->throwOnFirst();
}