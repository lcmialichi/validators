<?php

namespace Validators;

use Validators\Exception\ValidationException;

class Errors
{
    private array $errors = [];


    public function add(array $error)
    {
        $this->errors[] = $error;
    }

    /**
     * Retorna todos os erros de validaçao
     *
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * informa se a validação falhou
     *
     * @return bool
     */
    public function fails($field = null): bool
    {
        return isset($field) ? array_search(
            $field,
            array_column($this->errors, "field")
        ) !== false :
            count($this->errors) > 0;
    }

    public function errorsOnField($field)
    {
        $key = array_search(
            $field,
            array_column($this->errors, "field")
        );

        return $this->errors[$key] ?? null;
    }

    public function failedOnRule(string|int $field, ...$rule): bool
    {
        return count(array_filter(
            $this->errors,
            fn ($error) =>
            $error["field"] == $field && in_array($error["name"], $rule)
        )) == count($rule);
    }

    /**
     * retorna quantidade de erros
     *
     * @return int
     */
    public function count()
    {
        return count($this->errors);
    }

    /**
     * retorna primeiro erro
     *
     * @return mixed
     */
    public function first()
    {
        if ($this->fails()) {
            return $this->errors[0]["message"];
        }
    }
    /**
     * Para a execuçao do codigo retornando o primeiro erro
     * @throws ValidationException
     */
    public function throwOnFirst()
    {
        if ($this->fails()) {
            throw new ValidationException($this);
        }
        return false;
    }

    /**
     *  @throws ValidationException
     */
    public function throwOnFieldFirstError(string $field)
    {

        if ($this->fails($field)) {
            throw new ValidationException($this, $field);
        }
        return false;
    }

    /**
     * Retorna todos os erros de validaçao por segmento
     */
    public function segment(string $session) : ?Self
    {

        if ($this->errors()) {
            $newError = new Self;
            foreach ($this->errors() as $errors) {
                if (beginsWith($session, $errors["field"])) {
                    $newError->add($errors);
                }
            }
        }

        return $newError ?? null;
    }
}
