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

    public function login(): void
    {
        $this->view->title = "# LOGIN #";
        $this->render('login');
    }

    public function register(): void
    {
        $this->view->title = "# REGISTER #";
        $this->render('register');
    }

    /**
     * @throws Exception
     */
    public function eventos(): void
    {
        $this->view->title = "Eventos";
        $this->view->date = date_fmt();

        $this->render('eventos');
    }
}