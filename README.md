# Validator

## Introduction

The Validator package is a versatile PHP validation library that allows you to perform robust data validation with ease. Whether you need to validate simple strings or complex nested structures, this package provides a flexible and intuitive solution.

## Index

1. [Installation](#installation)
2. [Quick Start](#quick-start)
    - [Standard Validation](#standard-validation)
    - [Validation with Rules](#validation-with-rules)
3. [Customization](#customization)
    - [Custom Handlers](#custom-handlers)
    - [Custom Messages](#custom-messages)
4. [Contributing](#contributing)
5. [Conclusion](#conclusion)

## Installation

Install the Validator package using Composer:

```bash 
composer require lmcmi/validators
```

## Quick Start

### Standard Validation
For straightforward validation, use the `Validator` class directly:

```php
<?php

require_once __DIR__ . "/vendor/autoload.php";

$validator = new \Validators\Validator;
$result = $validator->string()->maxLength(10)->required()->validate('this is a test');

if($result->failed()){
    $result->throwOnFirst(); // Throws an exception for the first error message
}
```
### Validation with Rules
For more complex scenarios, leverage rules with nested structures:
```php
$values = [
    'field_1' => [
        "a" => "string",
        "b" => "should_be_int",
        "c" => []
    ],
    "field_2" => '{"json": "valid"}'
];

$rules = [
    "field_1" => "array|required",
    "field_1.a" => "string|required|lengthBetween:1,2",
    "field_1.b" => "int|between:1,2",
    "field_1.c" => "array",
    "field_2" => "json",
];

$result = Validator::rules($rules)->validade($values);

$result->failedOnField("teste.c"); // Returns false
$result->failed(); // Returns true
$result->throwOnFirstError(); // Throws an exception with the first error message
$result->failedOnRule('string'); // Returns true
$result->getErrorsMessages(); // Returns all error messages if they exist
```
## Customization

Tailor the Validator package to your needs by customizing handlers and messages.

### Custom Handlers
Create custom validation handlers to tailor the validation process to your needs:
```php
namespace My\Namespace;

class Required implements \Validators\Contracts\ValidatorHandler
{
    public function handle($item): bool
    {
        return isset($item);
    }
}
```
Set the namespace for all your custom handlers:
```php
$validator->setNamespaceHandler(My\Namespace::class);
```

### Custom Messages
Tailor validation error messages for a personalized touch:
```php
namespace My\Message\Namespace;

class Message implements \Validators\Contracts\MessagesRegistration
{
    public function register(): array
    {
        return [
            'required' => ':field is required!'
        ];
    }
}
```
Integrate your custom message class:
```php 
$validator->registerMessages(new \My\Message\Namespace\Message()); 
```

## Contributing
---

Contribute to the improvement of the Validator package by submitting issues or pull requests on the https://github.com/lcmialichi/validators.

## Conclusion
---

With the Validator package, you have a powerful tool at your disposal for ensuring data integrity and reliability in your PHP projects. Dive into the documentation, experiment with the provided examples, and enhance your validation capabilities with ease.
