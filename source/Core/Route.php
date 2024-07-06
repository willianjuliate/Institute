<?php

namespace Source\Core;

use Source\Utils\Message;
use stdClass;

/**
 * Classe Route controla o fluxo das url
 */
abstract class Route
{
    /**
     * @var stdClass
     */
    private stdClass $routes;

    /**
     * @return void
     */
    abstract function init(): void;

    /**
     *
     */
    public function __construct()
    {
        $this->init();
    }

    public function __set(string $name, $value): void
    {
        if (empty($this->routes)) {
            $this->routes = new stdClass();
        }

        $this->routes->name = $value;
    }

    /**
     * @return stdClass
     */
    private function getRoutes(): stdClass
    {
        return $this->routes;
    }

    /**
     * @param string $name
     * @param string $route
     * @param string $controller
     * @param string $action
     * @return void
     */
    protected function route(
        string $name,
        string $route,
        string $controller,
        string $action
    ):
    void {
        $object = new stdClass();
        $object->name = $name;
        $object->route = $route;
        $object->controller = $controller;
        $object->action = $action;

        $this->routes = $object;

        $this->run($this->getUrl());
    }

    /**
     * @param string $url
     * @return void
     */
    private function run(string $url): void
    {
        if ($this->routes->route == $url && isset($this->routes->name)) {
            $controller = new $this->routes->controller;
            $action = $this->routes->action;
            $controller->$action();
        }
    }

    /**
     * @return mixed
     */
    private function getUrl(): mixed
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
}