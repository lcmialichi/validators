<?php

require __DIR__ . '/vendor/autoload.php';

$validator = new \Validators\Validator([
    'email' => 'required|string|LengthBetween:1,10',
    'name' => 'required',
    'password' => 'required|numeric',
]);

$result = $validator->validate([
]);


var_dump($result);
$validator = new \Validators\Validator();

$result = $validator->required()->in(15)->between(1,5)->validate(null);