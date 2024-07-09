<?php

namespace Source\Utils;

use PDO;
use PDOException;

class Connection
{
    private const array OPTIONS = [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ];

    private static PDO $instance;

    public static function instance(): PDO
    {
        if (empty(self::$instance)) {
            try {
                self::$instance = new PDO(
                  "mysql:host=" . CONF_DB_HOST . ";dbname=" . CONF_DB_NAME,
                  CONF_DB_USER,
                  CONF_DB_PASS,
                  self::OPTIONS
                );
            } catch (PDOException $exception) {
                # Criar Rotina para salvar o erro e enviar por email
                die("<h1 class='trigger warning'>Whoops! Erro ao conectar ... </h1>");
            }
        }

        return self::$instance;
    }

    final public function __construct() {}
    private function __clone() {}

}