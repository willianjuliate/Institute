<?php

namespace Source\App\Controllers;

use Exception;
use Source\Core\Controller;

class IndexController extends Controller
{
    public function index(): void
    {
        $this->view->title = "Home";
        $this->render('index');
    }

    /**
     * @throws Exception
     */
    public function eventos():void
    {
        $this->view = (object)['title' => "Eventos", 'date' => date_fmt("now", "d/m/Y")];
        var_dump($this->view);
        $this->render('eventos');
    }
}