<?php

namespace Validators;

use Validators\Rule;
use Validators\Collection\RuleCollection;

class RuleParser
{
    private const RULE_DELIMITER = "|";
    private const PARAMETERS_DELIMITER = ":";
    private const ARGUMENTS_DELIMITER = ",";

    public function __construct(private string $statement)
    {
    }

    public static function parse(string $statement): RuleCollection
    {
        return (new self($statement))->getRuleParsed();
    }

    private function getRuleParsed(): RuleCollection
    {
        $parsed = [];
        foreach ($this->delimit() as $rule) {
            $rule = explode(self::PARAMETERS_DELIMITER, $rule);
            $parsed[] = new Rule(
                $rule[0],
                $this->getArgs($rule[1] ?? null)
            );

        }
        return new RuleCollection($parsed);
    }

    private function getArgs(?string $args): array
    {
        if (empty($args)) {
            return [];
        }
        return explode(self::ARGUMENTS_DELIMITER, $args);
    }

    private function delimit(): array
    {
        return explode(self::RULE_DELIMITER, $this->statement);
    }
}