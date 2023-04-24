<?php

if (!function_exists('dot')) {
    /**
     * navega por um array atravez de dotNotation
     *
     * @param mixed $var
     * @return void
     */
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
    /**
     * compara se uma string comeca com outra
     *
     * @return bool
     */
    function beginsWith(string $search, string $string): mixed
    {
        return 0 === strncmp($search, $string, \strlen($search));
    }
}

if (!function_exists("endsWith")) {
    /**
     * compara se uma string termina com outra
     *
     * @return bool
     */
    function endsWith(string $search, string $string): mixed
    {
        return substr($string, -strlen($search)) === $search;
    }
}
