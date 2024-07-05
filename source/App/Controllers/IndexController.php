<?php

namespace Source\App\Controllers;

use Exception;
use Source\Core\Controller;
use Source\Utils\Message;

class IndexController extends Controller
{
    public function index(): void
    {
       //$this->assets->css = CONF_PATH_CSS . "style.css";
        $this->view->title = "Home";
        $this->render('index');

    }

    /**
     * @throws Exception
     */
    public function eventos():void
    {
        //$this->assets->js = CONF_PATH_JS . 'script.js';

        $this->view = (object)[
            'title' => "Eventos",
            'date' => date_fmt("now", "d/m/Y"),
        ];
        $this->render('eventos');
    }
}