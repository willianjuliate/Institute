<?php

namespace Source\Core;

use Closure;

class Route
{
    private static array $routes;



    public static function get(string $route, string|Closure $handler): void
    {
        self::init($route, $handler, INPUT_GET);
    }
    public static function post(string $route, string|Closure $handler): void
    {
        self::init($route, $handler, INPUT_GET);
    }

    public static function put(string $route, string|Closure $handler): void
    {
        self::init($route, $handler, INPUT_GET);
    }

    public static function delete(string $route, string|Closure $handler):void
    {
        self::init($route, $handler, INPUT_GET);
    }

    public static function dispatcher(string $route): void
    {
        $route = self::$routes[$route] ?? [];

        if ($route) {
            if ($route['controller'] instanceof Closure) {
                call_user_func($route['controller']);
                return;
            }

            $controller = namespaces() . $route['controller'];
            $method = $route['method'];

            if (class_exists($controller)) {
                $newController = new $controller;
                if (method_exists($newController, $method)) {
                    $newController->$method();
                }
            }
        }
    }

    public static function route(): array
    {
        return self::$routes;
    }

    private static function init(string $route, string|Closure $handler, string $type): void
    {
        $start = "/" . filter_input($type, "url", FILTER_SANITIZE_SPECIAL_CHARS);
        self::$routes = [
            $route => [
                "route" => $route,
                "controller" => !is_string($handler) ? $handler : strstr($handler, "@", true),
                "method" => !is_string($handler) ?: str_replace("@", "", strstr($handler, "@", false))
            ],
        ];

        self::dispatcher($start);
    }
}