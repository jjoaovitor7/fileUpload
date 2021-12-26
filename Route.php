<?php
require_once __DIR__ . "/src/controllers/Controller.php";

$controller = new Controller();
$request__uri = $_SERVER["REQUEST_URI"];

function check__session($controller, $page__name) {
    if (!(isset($_SESSION["logged"]))):
        $controller->access();
    else:
        switch($page__name) {
            case "index":
                $controller->index();
                break;
            case "access":
                $controller->access();
                break;
            case "logout":
                $controller->logout();
                break;
            case "404":
                $controller->error_404();
                break;
            default:
                $controller->error_404();
                break;
        }
    endif;
}

switch($request__uri) {
    case "/":
        check__session($controller, "index");
        break;
    case "":
        check__session($controller, "index");
        break;
    case "/access":
        check__session($controller, "access");
        break;
    case "/logout":
        check__session($controller, "logout");
        break;
    default:
        if(strpos($request__uri, "index?id=") == true):
            check__session($controller, "index");
        elseif(strpos($request__uri, "edit") == true):
            check__session($controller, "edit");
        else:
            http_response_code(404);
            $controller->error_404();
        endif;
        break;
}
?>
