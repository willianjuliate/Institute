<?php

namespace Source\App\Routes;

use Source\Core\Route;

final class Start
{
    public static function start() : void
    {
        Route::get("/", "IndexController@index");
        Route::get("/login", "IndexController@login");
        Route::get("/register", "IndexController@register");
        Route::get("/eventos", "IndexController@eventos");
    }
}
