<?php

namespace Source\App\Controllers;

use Exception;
use Source\Core\Controller;
use Source\Utils\Message;

class IndexController extends Controller
{
    public function index(): void
    {
        $this->view->title = "Home";
        $this->render('index');

        echo (new Message())->success("Teste!");
        echo (new Message())->info("Teste!");
        echo (new Message())->warning("Teste!");
        echo (new Message())->error("Teste!");
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