<?php
require_once __DIR__ . "/../helpers/sanitize.php";
require_once __DIR__ . "/../helpers/info.php";
require_once __DIR__ . "/../models/File.php";

class IndexController {
    private $extensions__blocked = array("exe", "bat", "sh", "vbs", "js", "msi", "cmd", "vb", "lnk", "inf", "reg");
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function getBlockedExtensions() {
        return $this->extensions__blocked;
    }

    public function load() {
        // SE BOTÃO DE ENVIAR CLICADO
        if ($_SERVER['REQUEST_METHOD'] == "POST") :
            if (isset($_POST['action__send'])) :
                foreach ($_FILES['file']['name'] as $index => $fileElem) :
                    // PEGA A EXTENSÃO DO ARQUIVO
                    $ext = pathinfo($fileElem, PATHINFO_EXTENSION);

                    // VERIFICANDO SE EXTENSÃO É PERMITIDA
                    if (!(in_array($ext, $this->extensions__blocked))) :
                        $tmp = $_FILES['file']['tmp_name'][$index];
                        if (strlen(file_get_contents($tmp)) != 0) :
                            $file = new File(
                                null,
                                sanitize($this->mysqli->getInstance(), $fileElem),
                                $this->mysqli->getInstance()->real_escape_string(file_get_contents($tmp)),
                                sanitize($this->mysqli->getInstance(), mime_content_type($tmp)),
                                sanitize($this->mysqli->getInstance(), $_SESSION["id"])
                            );

                            $sql = "INSERT INTO files(`file`, `file_name`, `mime_type`, `owner_id`) VALUES ('"
                                . $file->getFile() . "','"
                                . $file->getFileName() . "','"
                                . $file->getMimeType() . "',"
                                . $file->getOwnerID() . ")";

                            // REALIZANDO O INSERT
                            $query = $this->mysqli->getInstance()->query($sql);
                            if ($query) :
                                $this->mysqli->getInstance()->commit();
                            else :
                                info__show("Erro.", "bg-danger");
                            endif;

                        // CASO O ARQUIVO ESTEJA COM 0 BYTES
                        else :
                            info__show("Arquivo vazio.", "bg-danger");
                        endif;
                    // CASO O FORMATO NÃO SEJA PERMITIDO
                    else :
                        info__show("Formato não permitido.", "bg-danger");
                    endif;
                endforeach;
            endif;
        endif;

        require __DIR__ . "/../views/index.php";

        $this->mysqli->unsetInstance();
    }
}
