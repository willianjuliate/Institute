<?php

namespace Source\App\Routes;

use Source\App\Controllers\IndexController;
use Source\Core\Route;

class IndexRoutes extends Route
{
    public function init(): void
    {
        $route['index'] = array(
          'route' => '/',
          'controller' => IndexController::class,
          'action' => 'index'
        );

        $route['evento'] = array(
            'route' => '/eventos',
            'controller' => IndexController::class,
            'action' => 'eventos'
        );

        $this->setRoutes($route);
    }

}