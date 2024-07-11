<?php

namespace Source\Core;

use stdClass;

abstract class Controller
{
    /** * @var stdClass */
    protected stdClass $data;

    public function __construct()
    {
        $this->data = new stdClass();
    }


    /**
     * @param string $view
     * @param array $data
     * @param string $base
     * @return void
     */
    protected function render(string $view, array $data = [], string $base = "base"): void
    {
        $this->data->page = $view;

        if ($data) {
            foreach ($data as $key => $value) {
                $this->data->$key = $value;
            }
        }

        if (file_exists(CONF_PATH_VIEW . $base . ".phtml")) {
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
        require_once CONF_PATH_VIEW . $controller . '\\' . $this->data->page . '.phtml';
    }

}