<?php

namespace Source\App\Controllers;

use Exception;
use Source\Core\Controller;

class IndexController extends Controller
{
    public function index(): void
    {
        $this->render('index', ["title" => "Home"]);
    }

    public function login(): void
    {
        $this->render('login', ['title' => "Login"]);
    }

    public function register(): void
    {
        $this->render('register', ["title" => "Register"]);
    }

    public function store():void
    {
        redirect('login');
    }

    /**
     * @throws Exception
     */
    public function eventos(): void
    {
        $this->render('eventos', ["title" => "Eventos", "date" => date_fmt()]);
    }
}