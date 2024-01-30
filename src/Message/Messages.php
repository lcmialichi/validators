<?php

declare(strict_types=1);

namespace Validators\Message;

use Validators\Contracts\MessagesRegistration;

class Messages implements MessagesRegistration
{
    public function register(): array
    {
        return [
            "cpf" => "campo :field deve ser um cpf válido",
            "between" => "campo :field deve estar entre :first e :last",
            "required" => "campo :field é obrigatório",
            "length" => "campo :field deve ter :p1 caracteres",
            "in" => "campo :field deve ser um dos seguintes valores: :all",
            "array" => "campo :field deve ser um array",
            "object" => "campo :field deve ser um objeto",
            "numeric" => "campo :field deve ser um numero",
            "bool" => "campo :field deve ser um booleano :p1",
            "string" => "campo :field deve ser texto",
            "date" => "campo :field deve ser uma data válida no formato :p1",
            "inEnum" => "campo :field deve ser um dos seguintes valores: :enum",
            "cep" => "campo :field deve ser um cep valido",
            "json" => "campo :field deve ser um JSON valido",
            "notIn" => "campo :field nao pode estar entre os valores :all",
            "minLenght" => "campo :field deve ter no minimo :p1 caracteres",
            "maxLenght" => "campo :field deve ter no maximo :p1 caracteres",
            "lenghtBetween" => "campo :field deve ter entre :first e :last caracteres",
            "int" => "campo :field deve ser um numero inteiro",
        ];
    }
}
