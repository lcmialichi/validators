<?php

use Validators\Validator;
use Validators\ValidatorWithRules;

require_once __DIR__ . "/vendor/autoload.php";

$validator = new Validator;

$values = [
    'teste' => [
        "a" => "string",
        "b" => "should_be_int",
        "c" => []
    ],
    "olar" => 1
];

$rules = [
    "teste.a" => "string|required|lenghtBetween:1,2",
    "teste.b" => "int",
    "teste.c" => "array",
];

$result = Validator::rules($rules, $values);
var_dump($result);
var_dump($result->failedOnField("teste.c"));


