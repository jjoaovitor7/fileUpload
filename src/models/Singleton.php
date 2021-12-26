<?php

require_once __DIR__ . "/../helpers/Helpers.php";

class Singleton {
    private $instance;

    public function __construct($ip, $username, $password, $db_name) {
        if (!(isset($this->instance))):
            $this->instance = new mysqli($ip, $username, $password, $db_name);
        endif;

        if (isset($this->instance)):
            $this->instance->set_charset("utf8");
            $this->instance->autocommit(FALSE);
        endif;

        if ($this->instance->connect_errno):
            Helpers::showInfo("Falha na conexão com o banco de dados.<br />", "bg-danger");
        endif;
    }

    public function getInstance() {
        return $this->instance;
    }

    public function unsetInstance() {
        if (isset($this->instance)):
            $this->instance->close();
        endif;
    }
}
