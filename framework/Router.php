<?php

namespace Framework;

use Error;

class Router
{

    /**
     * @var string[]
     */
    public static array $routes = []; // Atributo como um vetor de strings

    private static function generateRoute(string $path, string $controller, string $method)
    {
        $paths = explode('/', $path);

        // Validate if route already exists
        $exists = array_key_exists($paths[0], self::$routes);
        if ($exists) {
            throw new Error('Route already exists');
        }
        $endpoint = $paths[0];
        array_splice($paths, 0, 1);
        self::$routes[$endpoint] = [
            'paths' => $paths,
            'action' => [
                'class' => $controller,
                'method' => $method
            ]
        ];
    }
    private static function validateClass(string $controller, string $method)
    {
        if (class_exists($controller)) {
            if (!method_exists($controller, $method)) {
                throw new Error('Method not found');
            }
            // Validate if class and method exists
        } else {
            throw new Error('Controller not found');
        }
    }
    public static function get(string $route, string $controller, string $method)
    {
        // Validate if controller exists
        self::validateClass($controller, $method);

        // Generate route
        self::generateRoute($route, $controller, $method);
    }

    public static function execute(string $route) {
        $paths = explode('/', $route);
        $route_exists = array_key_exists($paths[0], self::$routes);
        if(!$route_exists) {
            throw new Error('Route not found');
        }
        $route = self::$routes[$paths[0]];
        
        // Instantiate the class and execute the method
        $instance = new $route['action']['class'];
        $method = $route['action']['method'];
        $instance->$method();
    }
}
