<?php

namespace Validators;


class ValidatorWithRules
{
    public function __construct(
        private Validator $validator = new Validator,
    ) {
    }

    /**
     *
     * @param array $items
     * @return Errors
     */
    public function validate(array $items, array $rulesToApply): Errors
    {
        
        $errors = new Errors;
        foreach ($rulesToApply as $field => $ruleString) {
            $rulesParsed = $this->parseRules($ruleString);
            $itemToVerify = dot($field, $items);

            foreach ($rulesParsed as $rulesToApply) {
                $params = $rulesToApply[key($rulesToApply)];
                $this->validator->{key($rulesToApply)}(...$params);
                $error = $this->validator->validate($itemToVerify);
                if ($error->fails()) {
                    $replacementes = [
                        "field" => $field,
                        "all" => implode(", ", $params)
                    ];

                    foreach ($params as $key => $value) {
                        if (enum_exists($value)) {
                            $replacementes["enum"] = implode(", ", array_column($value::cases(), "value"));
                            continue;
                        }
                        $replacementes["p" . $key + 1] = $value;
                    };

                    $error = $error->errors()[0];
                    $error["field"] = $field;
                    $error["message"] = $this->messageUpdate($error["message"], $replacementes);
                    $errors->add($error);
                }
            }
        }
        return $errors;
    }

    private function parseRules(string $ruleString)
    {
        $rules = explode("|", $ruleString);
        $parsed = [];
        foreach ($rules as $rule) {
            $parsed[] = $this->parse($rule);
        }

        return $parsed;
    }

    private function parse(string $rule): array
    {
        $rule = explode(":", $rule);
        $name = pascalCase($rule[0]);
        if (!$this->validator->has($name)) {
            throw new \RuntimeException("Regra de validação: " . lcfirst($name) . " não encontrada!");
        }
        if (count($rule) > 1) {
            $params = explode(",", $rule[1]);
        }

        return [$name => $params ?? []];
    }

    private function messageUpdate(?string $message, array $updates)
    {
        return replace($message ?? "", $updates);
    }
}
