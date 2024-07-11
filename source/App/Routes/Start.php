<?php

namespace Source\App\Routes;

use Source\Core\Route;

final class Start
{
    public static function start() : void
    {
        // GET
        Route::get("/", "IndexController@index");
        Route::get("/login", "IndexController@login");
        Route::get("/register", "IndexController@register");
        Route::get("/eventos", "IndexController@eventos");

        //POST
        Route::post("/register/store", "IndexController@store");

        //PUT


        //DELETE


    }
}
