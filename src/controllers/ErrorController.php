<?php
class ErrorController {
    public function __construct() {
    }

    public function load__404() {
        require_once __DIR__ . "/../views/404.php";
    }
}
?>
