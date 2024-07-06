<?php

namespace Source\App\Routes;

use Source\App\Controllers\IndexController;
use Source\Core\Route;

class IndexRoutes extends Route
{
    public function init(): void
    {
        $this->route('index','/', IndexController::class, 'index');
        $this->route('login', '/login', IndexController::class, 'login');
        $this->route('register', '/register', IndexController::class, 'register');
        $this->route('eventos', '/eventos', IndexController::class, 'eventos');
    }

}