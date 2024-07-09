<?php

namespace Source\Core;

use Closure;

class Route
{
    private static array $routes;

    public static function get(string $route, string|Closure $handler): void
    {
        $get = "/" . filter_input(INPUT_GET, "url", FILTER_SANITIZE_SPECIAL_CHARS);
        self::$routes = [
            $route => [
                "route" => $route,
                "controller" => !is_string($handler) ? $handler : strstr($handler, "@", true),
                "method" => !is_string($handler) ?: str_replace("@", "", strstr($handler, "@", false))
            ],
        ];

        self::dispatcher($get);
    }

    public static function post(): void
    {

    }

    public static function put(): void
    {

    }

    public static function delete():void
    {

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

}