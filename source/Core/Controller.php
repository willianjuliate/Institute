<?php

namespace Source\Core;

use stdClass;

abstract class Controller
{
    /** * @var stdClass */
    protected stdClass $view;

    /** * @var stdClass*/
    protected stdClass $assets;

    public function __construct()
    {
        $this->view = new stdClass();
        $this->assets = new stdClass();
    }

    /**
     * @param string $view
     * @param string $base
     * @return void
     */
    protected function render(string $view, array $data=[], string $base = "base"): void
    {
        if ($data) {
            foreach ($data as $key => $value) {
                $this->view->$key = $value;
            }
        }

        $this->view->page = $view;

        if (file_exists(CONF_PATH_VIEW . $base . ".phtml")){
            require_once CONF_PATH_VIEW . $base . ".phtml";
        } else {
            $this->content();
        }
    }

    /**
     * @return void
     */
    protected function content(): void
    {
        $controller = strtolower(
            str_replace(
                'Controller',
                '',
                str_replace(namespaces(), '', $this::class)
            )
        );
        require_once CONF_PATH_VIEW. $controller . '\\' . $this->view->page . '.phtml';
    }
}