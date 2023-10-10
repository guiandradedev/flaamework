<?php

namespace Framework\Http;

use Config\DependencyInjector;
use Error;
use Framework\Utils\ArrayUtils;
use InvalidArgumentException;
use ReflectionMethod;

/*
 * Classe base para criação e gerenciamento de rotas
 *  */
class Router
{
    /**
     * @var string[] Rotas armazenadas
     */
    public static array $routes = [];

    /**
     * Router GET.
     *
     * Esta função gera um endpoint do tipo GET,
     *
     * @param string $route Endpoint da rota.
     * @param array ...$callbacks Callback de execução do tipo [Controller::class, 'metodo'].
     * @return void 
     * @throws InvalidArgumentException Argumento inválido (rota ou controller)
     * @throws Error Rota já existe.
     */
    public static function get(string $route, ...$callbacks)
    {
        // Validate if controller exists
        self::validateClass(...$callbacks);

        // Generate route
        self::generateRoute($route, 'GET', ...$callbacks);
    }

    /**
     * Execute Router Method.
     *
     * Esta função executa as rotas listadas e redireciona o usuário para o conteúdo desejado,
     *
     * @param string $route Endpoint do usuário.
     * @param string $method Método HTTP da requisição.
     * @return void 
     * @throws InvalidArgumentException Argumento inválido (rota não encontrada)
     * @throws Error Erro ao instanciar controller.
     */
    public static function execute(string $route, string $method)
    {
        $paths = explode('/', $route);

        $find = self::findRoute($paths, $method);

        if ($find === -1) {
            throw new InvalidArgumentException('Route not found');
        }

        $route = self::$routes[$find];

        // Instantiate the class and execute the method
        $instance = new $route['actions'][0]['class']();
        $method = $route['actions'][0]['method'];
        $method_reflex = new ReflectionMethod($instance, $method);
        $paramethers_method = $method_reflex->getParameters();
        $depedencyInjector = new DependencyInjector();
        
        $error = false;
        $paramethers = [];
        foreach ($paramethers_method as $paramether) {
            $tipoParametro = $paramether->getType(); // A partir do PHP 7
            if ($tipoParametro) {
                $paramether_function = ArrayUtils::array_search_subvetor($depedencyInjector->dependencies, 'abstract', $tipoParametro->getName());
                if($paramether_function == -1) {
                    $error = true;
                } else {
                    $paramethers[] = new $depedencyInjector->dependencies[$paramether_function]['final']();
                }
            } else {
                $error = true;
            }
        }
        

        if($error) {
            throw new Error('An error ocurred while instance a class');
        }

        $instance->$method(...$paramethers);
    }

    /**
     * Generate Route.
     *
     * Esta função gera as rotas que serão utilizadas com base nos endpoints e metodos,
     *
     * @param string $path Rotas da requisição em string, ex: '/rota/de/listagem'.
     * @param string $method Método HTTP da requisição.
     * @param string ...$callbacks Callback de execução do tipo [Controller::class, 'metodo'].
     * @return void 
     * @throws Error Rota ja existe.
     */
    private static function generateRoute(string $path, string $method, ...$callbacks)
    {
        $method = strtoupper($method);
        $paths = explode('/', $path);

        // Validate if route already exists
        $find = self::findRoute($paths, $method);

        if ($find !== -1) {
            throw new Error('Route already exists');
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

    /**
     * Validate Route.
     *
     * Esta função valida a criação dos controllers e métodos,
     *
     * @param string ...$callbacks Callback de execução do tipo [Controller::class, 'metodo'].
     * @return void 
     * @throws Error Rota ja existe.
     */
    private static function validateClass(...$callbacks)
    {
        foreach ($callbacks as $callback) {
            $classe = $callback[0];
            // $reflexao = new ReflectionClass($classe);
            // $construtor = $reflexao->getConstructor();
            $callback[0] = new $classe();
            if (!is_callable($callback)) {
                throw new InvalidArgumentException('Controller or method not found');
            }
            if (!is_subclass_of($callback[0], Controller::class)) {
                $classe = explode('\\', $classe);
                throw new InvalidArgumentException($classe[count($classe) - 1] . " não é uma classe filha de Controller");
            }
        }
    }

    /**
     * Find Route.
     *
     * Esta função verifica se uma rota já existe no software,
     *
     * @param array $paths Caminho da requisição.
     * @param string $method Método HTTP da requisição].
     * @return void 
     * @throws Error Rota ja existe.
     */
    private static function findRoute(array $paths, string $method)
    {
        $method = strtoupper($method);

        static $find = -1;

        $find = -1;

        for ($i = 0; $i < count(self::$routes) && $find == -1; $i++) {
            if (self::$routes[$i]['paths'][0] === $paths[0] && self::$routes[$i]['method'] === $method) {
                $find = $i;
            }
        }

        if ($find !== -1) {
            $equals = ArrayUtils::array_compare(self::$routes[$find]['paths'], $paths);
            if ($equals) {
                return $find;
            }
        }

        return -1;
    }
}
