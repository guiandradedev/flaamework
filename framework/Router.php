<?php

namespace Framework;

use Error;
use Framework\Utils\ArrayUtils;
use InvalidArgumentException;

class Router
{

    /**
     * @var string[]
     */
    private static array $routes = []; // Atributo como um vetor de strings

    private static function findRoute(array $paths, string $method) {
        $method = strtoupper($method);
        $find = -1;
        for ($i = 0; $i < count(self::$routes) && $find == -1; $i++) {
            if (self::$routes[$i]['paths'][0] === $paths[0] && self::$routes[$i]['method'] === $method)
                $find = $i;
        }
        return $find;
    }

    private static function generateRoute(string $path, string $method, ...$callbacks)
    {
        $method = strtoupper($method);
        $paths = explode('/', $path);

        // Validate if route already exists
        $find = self::findRoute($paths, $method);

        if ($find !== -1) {
            $equals = ArrayUtils::array_compare(self::$routes[$find]['paths'], $paths);
            if ($equals) {
                throw new Error('Route already exists');
            }
        }

        // Save route
        $route_data = [
            'paths' => $paths,
            'actions' => array_map(function ($method) {
                return [
                    'class' => $method[0],
                    'method' => $method[1]
                ];
            }, $callbacks),
            'method' => $method
        ];
        array_push(self::$routes, $route_data);
    }
    private static function validateClass(...$callbacks)
    {
        foreach ($callbacks as $callback) {
            $classe = $callback[0];
            $callback[0] = new $classe();
            if (!is_callable($callback)) {
                throw new InvalidArgumentException('Controller or method not found');
            }
        }
    }
    public static function get(string $route, ...$callbacks)
    {
        // Validate if controller exists
        self::validateClass(...$callbacks);

        // Generate route
        self::generateRoute($route, 'GET', ...$callbacks);
    }

    public static function execute(string $route, string $method)
    {
        $paths = explode('/', $route);

        $find = self::findRoute($paths, $method);

        if ($find === -1) {
            throw new Error('Route not found');
        }
        
        $route = self::$routes[$find];

        // Instantiate the class and execute the method
        $instance = new $route['actions'][0]['class']();
        $method = $route['actions'][0]['method'];
        $instance->$method();
    }
}
