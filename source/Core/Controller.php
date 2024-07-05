<?php

namespace Source\Core;

use stdClass;

/**
 *
 */
abstract class Controller
{
    /**  * @var stdClass */
    protected stdClass $view;

    /**
     *
     */
    public function __construct()
    {
        $this->view = new stdClass();
    }

    /**
     * @param string $view
     * @param string $base
     * @return void
     */
    protected function render(string $view, string $base = "base"): void
    {
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
                str_replace('Source\\App\\Controllers\\', '', $this::class)
            )
        );
        require_once CONF_PATH_VIEW. $controller . '\\' . $this->view->page . '.phtml';
    }
}