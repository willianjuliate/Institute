<?php

namespace Source\Core;

/**
 *
 */
abstract class Route
{
    /**
     * @var array
     */
    protected array $routes;

    /**
     * @return mixed
     */
    abstract function init();

    /**
     *
     */
    public function __construct()
    {
        $this->init();
        $this->run($this->getUrl());
    }

    /**
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * @param array $routes
     * @return void
     */
    public function setRoutes(array $routes): void
    {
        $this->routes = $routes;
    }

    /**
     * @param string $url
     * @return void
     */
    protected function run(string $url): void
    {
        foreach ($this->getRoutes() as $route) {
            if ($url == $route['route']) {
                $controller = new $route['controller'];
                $action = $route['action'];
                $controller->$action();
            }
        }
    }

    /**
     * @return array|false|int|string|null
     */
    protected function getUrl(): array|false|int|null|string {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
}