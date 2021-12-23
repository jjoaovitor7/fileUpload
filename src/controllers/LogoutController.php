<?php
class LogoutController {
    public function __construct() {
    }

    public function load() {
        if (isset($_SESSION)):
            session_destroy();
            session_unset();

            require_once __DIR__ . "/../views/logout.php" ;
        endif;
    }
}
?>
