<?php

namespace Framework\Utils;

class ArrayUtils {
    public static function array_compare($array1, $array2) {
        // print_r($array1);
        // print_r($array2);
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

    public static function array_search_subvetor($vetor, $chave, $valor) {
        foreach ($vetor as $indice => $subvetor) {
            if (isset($subvetor[$chave]) && $subvetor[$chave] === $valor) {
                return $indice; // Retorna o índice do subvetor que corresponde ao valor
            }
        }
        return -1; // Retorna false se não encontrar correspondência
    }

    public static function elements_in_array($vetor, $elements) {
        $errors = [];
        foreach ($elements as $element) {
            $found = array_key_exists($element, $vetor);
            if(!$found) array_push($errors, $element);
        }
        return $errors;
    }
}
