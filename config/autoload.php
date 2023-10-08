<?php

$autoload = function ($className) {
    // $baseDir = dirname(__DIR__); 

    // $namespaceMap = [
    //     'Framework' => '/framework',
    //     'App'       => '/app',
    //     'Resources' => '/resources',
    //     'Routes' => '/routes',
    //     'Config' => '/config'
    // ];

    // // Percorre o mapeamento de namespaces
    // foreach ($namespaceMap as $namespace => $dir) {
    //     if (strpos($className, $namespace) === 0) {
    //         // Remove o namespace do nome da classe
    //         $classNameWithoutNamespace = substr($className, strlen($namespace));
    //         $classNameWithoutNamespace = ltrim($classNameWithoutNamespace, '\\');

    //         // Constrói o caminho de arquivo
    //         $filePath = $baseDir . $dir . '/' . str_replace('\\', '/', $classNameWithoutNamespace) . '.php';

    //         if (file_exists($filePath)) {
    //             require_once $filePath;
    //             return;
    //         }
    //     }
    // }
    $baseDir = dirname(__DIR__); // Volta um diretório antes do diretório atual

    // Diretório onde as classes podem estar distribuídas (incluindo subdiretórios)
    $baseSearchDir = $baseDir . '/'; // Inicia a busca no diretório base

    // Substitui o namespace separator '\' por um separador de diretório '/'
    $classFilePath = str_replace('\\', DIRECTORY_SEPARATOR, $className);

    // Caminho completo para a classe
    $fullPath = $baseSearchDir . $classFilePath . '.php';

    // Verifica se o arquivo da classe existe
    if (file_exists($fullPath)) {
        require_once $fullPath;
    }
};

spl_autoload_register($autoload);