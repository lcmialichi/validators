<?php

namespace Validators;

class messageParser
{
    private array $globalWords = [
        ":field",
        ":all",
        ":enum",
    ];

    public function __construct(private ?string $message)
    {
    }

    public function replace(?string $field, array $args): self
    {
        $matches = $this->getMatches();
        foreach ($matches as $match) {
            $value = $args[trim($match, "\:\ ")] ?? null;
            if ($value !== null) {
                $this->message = str_replace($match, $value, $this->message);
            }

            if ($this->isGlobalWord($match)) {
                $this->message = $this->resolveGlobalWord($match, $field ?? "", $args);
            }

        }

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    private function getMatches(): array
    {
        $matches = [];
        preg_match_all("/:[^\s\W]*\b/", $this->getMessage() ?? "", $matches);
        return $matches[0];
    }

    private function resolveGlobalWord(string $word, string $field, array $args): string
    {
        switch ($word) {
            case ":field":
                return str_replace($word, $field, $this->message);
            case ":all":
                return str_replace($word, implode(",", $args), $this->message);
            case ":enum":
                return str_replace($word, implode(",", $args), $this->message);
            default:
                return $this->message;
        }
    }

    public static function make(?string $message): self
    {
        return new self($message);
    }

    public function isGlobalWord(string $word): bool
    {
        return in_array($word, $this->globalWords);
    }
}