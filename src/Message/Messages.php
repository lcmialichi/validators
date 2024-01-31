<?php

declare(strict_types=1);

namespace Validators\Message;

use Validators\Contracts\MessagesRegistration;

class Messages implements MessagesRegistration
{
    public function register(): array
    {
        return [
            "cpf" => "field :field must be a valid CPF",
            "between" => "field :field must be between :first and :last",
            "required" => "field :field is mandatory",
            "length" => "field :field must have :value characters",
            "in" => "field :field must be one of the following values: :all",
            "array" => "field :field must be an array",
            "object" => "field :field must be an object",
            "numeric" => "field :field must be a number",
            "bool" => "field :field must be a boolean",
            "string" => "field :field must be a string",
            "date" => "field :field must be a valid date in the format :format",
            "enum" => "field :field must be one of the following values: :enum",
            "cep" => "field :field must be a valid ZIP code",
            "json" => "field :field must be a valid JSON",
            "notIn" => "field :field cannot be among the values :all",
            "minLength" => "field :field must have at least :min characters",
            "maxLength" => "field :field must have at most :max characters",
            "lengthBetween" => "field :field must have between :first and :last characters",
            "int" => "field :field must be an integer",
        ];
    }
}
