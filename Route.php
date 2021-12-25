<?php
require_once __DIR__ . "/src/controllers/Controller.php";

$controller = new Controller();

$request__uri = $_SERVER["REQUEST_URI"];

function render($controller, $render__page) {
    switch ($render__page) {
        case "index":
            $controller->render__index();
            break;
        case "logout":
            $controller->render__logout();
            break;
        case "edit":
            $controller->render__edit();
            break;
        default:
            $controller->render__access();
            break;
    }
}

// SE O USUÁRIO NÃO ESTIVER LOGADO
function check__session ($controller, $render__page) {
    if (isset($_SESSION["logged"])):
        if (isset($_SESSION["id"])):
            render($controller, $render__page);
        endif;
    else:
        render($controller, "access");
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
            $controller->render__error("404");
        endif;
        break;  
}
?>
