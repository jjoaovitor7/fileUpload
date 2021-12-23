<?php

require_once __DIR__ . "/../helpers/info.php";

class Singleton {
    private $instance = null;

    public function __construct() {
    }

    public function setInstance($ip, $username, $password, $db_name) {
        if (!(isset($this->instance))):
            $this->instance = new mysqli($ip, $username, $password, $db_name);
        endif;

        if (isset($this->instance)):
            $this->instance->set_charset("utf8");
            $this->instance->autocommit(FALSE);
        endif;

        if ($this->instance->connect_errno):
            info__show("Falha na conexão com o banco de dados.<br />", "bg-danger");
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
