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


if (!function_exists('pascalCase')) {
    /**
     * Formata string para PascalCase
     *
     * @param string $string
     * @return string
     */
    function pascalCase(string $string): string
    {
        if (preg_match("/[A-Z]*|[_-]/", $string)) {
            if (strtoupper($string) === $string) {
                $string = strtolower($string);
            }
            // $string = strtolower($string);
        }

        $string = str_replace(["_", "-"], " ", trim(strtolower(macroCase($string))));
        $string = ucwords($string);
        $string = str_replace(" ", "", $string);
        return $string;
    }
}


if (!function_exists('macroCase')) {
    /**
     * Formata string para MACRO_CASE
     *
     * @param string $string
     * @return string
     */
    function macroCase(string $string): string
    {
        $string = str_replace(["-", " "], "_", $string);
        if (strtoupper($string) === $string) {
            $string = strtolower($string);
        }
        return strtoupper(strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string)));
    }
}

if (!function_exists('replace')) {

    /**
     * Subistitui :keys que existem em um valor de uma array por seu conteudo
     * 
     * @param string|array $subject que possui a string a ser substituida
     * @param array $replace valores que irao substituirs pela :chave
     */
    function replace(string|array $subject, array $replace)
    {
        if (is_array($subject)) {
            foreach ($subject as $key => $value) {
                $subject[$key] = replace($value, $replace);
            }
            return $subject;
        }

        foreach ($replace as $key => $value) {
            $subject = str_replace(":{$key}", $value, $subject);
        }

        return $subject ?? "";
    }
}
