<?php
require_once __DIR__ . "/IndexController.php";
require_once __DIR__ . "/AccessController.php";
require_once __DIR__ . "/LogoutController.php";
require_once __DIR__ . "/../models/Singleton.php";

session_start();

class Controller {
    private $mysqli;
    private $access;
    private $index;
    private $logout;

    public function __construct() {
        $this->mysqli = new Singleton();
        $this->mysqli->setInstance("", "", "", "");
        $this->access = new AccessController($this->mysqli);
        $this->index = new IndexController($this->mysqli);
        $this->logout = new LogoutController();
    }

    public function render__access() {
        $this->access->load();
    }

    public function render__index() {
        $_SESSION["extensions__blocked"] = $this->index->getBlockedExtensions();

        if (isset($_GET["id"])) :
            if (isset($_GET["edit"]) || isset($_GET["delete"])):
                // EXCLUSÃO DE ARQUIVO
                if (isset($_GET["delete"])):
                    $sql = "DELETE FROM files WHERE id = " . $_GET['id'];
                    $query = $this->mysqli->getInstance()->query($sql);

                    if (!$query) {
                        echo "Erro.";
                    }
                    $this->mysqli->getInstance()->commit();
                endif;

            // DOWNLOAD DO ARQUIVO
            else:
                $sql = "SELECT * FROM files WHERE id = " . $_GET['id'];
                $query = $this->mysqli->getInstance()->query($sql);

                if ($query) :
                    $r = $query->fetch_row();
                    if ($_SESSION["id"] == $r[4]) :
                        $filename = $r[2];
                        $file = $r[1];
                        // $size = strlen($file);
                        $type = $r[3];
                        // header("Content-Length: $size");
                        header("Content-Type: $type; charset=utf-8");
                        header("Content-Disposition: attachment; filename=$filename");

                        echo $file;
                        die();
                    endif;
                endif;
            endif;
        endif;

        $this->mysqli->unsetInstance();
        $this->index->load();
    }

    public function render__logout() {
        $this->logout->load();
    }
}
?>
