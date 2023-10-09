<?php

$autoload = function ($className) {
    $baseDir = dirname(__DIR__); 

    $namespaceMap = [
        'Framework' => '/framework',
        'App'       => '/app',
        'Resources' => '/resources',
        'Routes' => '/routes',
        'Config' => '/config'
    ];

    // Percorre o mapeamento de namespaces
    foreach ($namespaceMap as $namespace => $dir) {
        if (strpos($className, $namespace) === 0) {
            // Remove o namespace do nome da classe
            $classNameWithoutNamespace = substr($className, strlen($namespace));
            $classNameWithoutNamespace = ltrim($classNameWithoutNamespace, '\\');

            // Constrói o caminho de arquivo
            $filePath = $baseDir . $dir . '/' . str_replace('\\', '/', $classNameWithoutNamespace) . '.php';

            if (file_exists($filePath)) {
                require_once $filePath;
                return;
            }
        }
    }
};

spl_autoload_register($autoload);