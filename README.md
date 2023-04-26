

## Exemplo de uso:
---
```php
use Validators\Validator;

require_once __DIR__ . "/vendor/autoload.php";

$validator = new Validator;

$error = $validator->between(1, 10)->isString()->validate("esse texto tem mais de 10 caracteres");

if($error->fails()){
    $error->throwOnFirst();
}

```

## Configurações
---
### personalização de mensagens :
 - o validator ja vem com mensagens padroes, mas atraves deste metodo é possivel alterar, ou até mesmo criar uma nova para o handler customizado

```php
$validator->setMessages([
    "between" => "o valor inserido é invalido!"
]);

```

ou

```php
$validator->setMessagesPath("caminho/arquivo.php"); #deve retornar um array de mensagens 

```



### Criando seus proprios handlers

```php
<?php

namespace SeuNamespace\ContendoApenasHandlers;

class In
{
    private $params;

    /**
     * o construtor aceita infinitor parametros e podem  ser usados na validaçao
     **/
    public function __construct( ...$params)
    {
        $this->params = $params;
    }
    
    /**
     *  A funcao deve conter este nome, e deve retornar um booleano, true caso validaçao passe ou false caso falhe 
     **/
    public function validate($value): bool
    {
         return in_array($value, $this->params);
    }
}

```

#### Configurando os handlers


```php

use Validators\Validator;

require_once __DIR__ . "/vendor/autoload.php";

$validator = new Validator([
    "app-root" => __DIR__ // informa a raiz do seu projeto (onde contem o composer.json)
]);
$validator->setHandlersNamespace(SeuNamespace\ContendoApenasHandlers::class)

# o nome da funçao é o nome da classe criada como handler
# os parametros sao passados para o construtor
# é possivel carregar mais de um namespace, handlers com mesmo nome serao substituido pelo ultimo carregado
$error = $validator->in(1,2,3,4,5,6,7,8)->validate(6);

$error->fails(); // false;



```


### Validacao com RULES

```php
use Validators\Validator;
use Validators\ValidatorWithRules;

require_once __DIR__ . "/vendor/autoload.php";

$validator = new Validator;
$validator->setMessages([
    "between" => "teste campo :field possui valor invalido e deve estar entre :p1 e p:2"
]);

# a classe Validator so é necessaria quando existir uma 
# pre configuraçao desejavel pelo usuario caso o contrario sera utilizado 
# o Validator em estado default
$validator = new ValidatorWithRules($validator);  

# os campos sao passados em dot notation para se referir as chaves de um 
# array que sera validado
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
    // mensage: "teste campo campo_a.item1 possui valor invalido e deve estar entre 1 e 2"
}

```