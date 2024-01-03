<?php

use Validators\Validator;
use Validators\ValidatorWithRules;

require_once __DIR__ . "/vendor/autoload.php";


$validator = new Validator;

$values = [ 'teste' => 3, "olar" => 1];

var_dump(Validator::rules([
    'teste' => 'required|between:1,2',
    'olar' => 'required|in:1,2'
],$values));

// $validator = new Validator([
//     "app-root" => __DIR__
// ]);
// $validator->setMessages([
//     "between" => "teste campo :field  possui valor invalido"
// ]);


// // $validator->setHandlersNamespace("Validators\Handlers");

// $validator = new ValidatorWithRules($validator);

// $rules = [
//     "campo_a" => "isArray|required",
//     "campo_a.item1" => "isString|between:1,2",
//     "campo_a.item2" => "numeric"
// ];

// $fields = [
//     "campo_a" => [
//         "item1" => "aaaa",
//         "item2" => 3
//     ]
// ];

// $error = $validator->validate($fields, $rules);

// if($error->fails()){
//     $error->throwOnFirst();
// }