

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

$validator = new Validator;
$validator->setHandlersNamespace(SeuNamespace\ContendoApenasHandlers::class)

# o nome da funçao é o nome da classe criada como handler
# os parametros sao passados para o construtor
# é possivel carregar mais de um namespace, handlers com mesmo nome serao substituido pelo ultimo carregado
$error = $validator->in(1,2,3,4,5,6,7,8)->validate(6);

$error->fails(); // false;



```