<?php

if (!function_exists('dot')) {
    function dot(string $search, array|object $array): mixed
    {
        if (array_key_exists($search, $array)) {
            return $array[$search];
        }
        if (!str_contains($search, '.')) {
            return $array[$search] ?? null;
        }

        foreach (explode('.', $search) as $segment) {
            if (is_object($array) and isset($array->{$segment})) {
                $array = $array->{$segment};
                continue;
            }
            if (array_key_exists($segment, $array)) {
                $array = $array[$segment];
            } else {
                return null;
            }
        }

        return $array;
    }
}

if (!function_exists('beginsWith')) {
    function beginsWith(string $search, string $string): mixed
    {
        return 0 === strncmp($search, $string, \strlen($search));
    }
}

if (!function_exists("endsWith")) {
    function endsWith(string $search, string $string): mixed
    {
        return substr($string, -strlen($search)) === $search;
    }
}


if (!function_exists('pascalCase')) {
    function pascalCase(string $string): string
    {
        if (preg_match("/[A-Z]*|[_-]/", $string)) {
            if (strtoupper($string) === $string) {
                $string = strtolower($string);
            }
        }

        $string = str_replace(["_", "-"], " ", trim(strtolower(macroCase($string))));
        $string = ucwords($string);
        $string = str_replace(" ", "", $string);
        return $string;
    }
}


if (!function_exists('macroCase')) {
    function macroCase(string $string): string
    {
        $string = str_replace(["-", " "], "_", $string);
        if (strtoupper($string) === $string) {
            $string = strtolower($string);
        }
        return strtoupper(strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string)));
    }
}

if (!function_exists('reserved')) {
    function reserved(string $word): bool
    {
        $reservedWords = require __DIR__ ."/reservedWords.php";
        if (in_array(strtolower($word), $reservedWords)) {
            return true;
        }

        return false;
    }

}