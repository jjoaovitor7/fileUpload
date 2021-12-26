<?php
class ViewsController {
    public function __construct() {
    }

    public function render($view) {
        switch ($view) {
            case "index":
                require __DIR__ . "/../views/index.php";
                break;
            case "access":
                require_once __DIR__ . "/../views/access.php";
                break;
            case "edit":
                require_once __DIR__ . "/../views/edit.php";
                break;
            case "logout":
                require_once __DIR__ . "/../views/logout.php" ;
                break;
            case "404":
                require_once __DIR__ . "/../views/404.php";
                break;
            default:
                require_once __DIR__ . "/../views/404.php";
                break;
        }
    }
}
?>
