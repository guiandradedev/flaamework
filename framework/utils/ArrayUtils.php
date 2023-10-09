<?php

namespace Framework\Utils;

class ArrayUtils {
    public static function array_compare($array1, $array2) {
        // Primeiro, verifique se os tamanhos dos vetores são iguais
        if (count($array1) !== count($array2)) {
            return false;
        }
    
        // Em seguida, compare os elementos dos vetores
        foreach ($array1 as $key => $value) {
            if ($value !== $array2[$key]) {
                return false;
            }
        }
    
        // Se todos os elementos forem iguais, os vetores são iguais
        return true;
    }
}
