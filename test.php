<?php

use Validators\Validator;
use Validators\ValidatorWithRules;

require_once __DIR__ . "/vendor/autoload.php";


$validator = new Validator;
$validator->setMessages([
    "between" => "teste campo :field  possui valor invalido"
]);

$validator = new ValidatorWithRules($validator);

$rules = [
    "campo_a" => "isArray|required",
    "campo_a.item1" => "isString|between:1,2",
    "campo_a.item2" => "numeric"
];

$fields = [
    "campo_a" => [
        "item1" => "aaaa",
        "item2" => 3
    ]
];

$error = $validator->validate($fields, $rules);

if($error->fails()){
    $error->throwOnFirst();
}