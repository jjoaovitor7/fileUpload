<?php
require_once "info.php";
require_once "sanitize.php";

$notExts = array("exe", "bat", "sh", "vbs", "js", "msi", "cmd", "vb", "lnk", "inf", "reg");
// SE BOTÃO DE ENVIAR CLICADO
if (isset($_POST['action__send'])) :
    foreach ($_FILES['file']['name'] as $index => $fileElem) :
            // PEGA A EXTENSÃO DO ARQUIVO
            $ext = pathinfo($fileElem, PATHINFO_EXTENSION);

            // VERIFICANDO EXTENSÕES E UPLOAD DE ARQUIVO
            if (!(in_array($ext, $notExts))) :
                $tmp = $_FILES['file']['tmp_name'][$index];
                if (strlen(file_get_contents($tmp)) != 0) :
                    $sql = "INSERT INTO files(`file`, `file_name`, `mime_type`, `owner_id`) VALUES ('"
                    . sanitize($mysqli, file_get_contents($tmp)) . "','"
                    . sanitize($mysqli, $fileElem) . "','"
                    . sanitize($mysqli, mime_content_type(($tmp))) . "',"
                    . sanitize($mysqli, $_SESSION['id']) . ")";

                    // REALIZANDO O INSERT
                    $query = $mysqli->query($sql);
                    if ($query) :
                        $mysqli->commit();
                    else:
                        info__show("Erro.", "bg-danger");
                    endif;

                // CASO O ARQUIVO ESTEJA COM 0 BYTES
                else:
                    info__show("Arquivo vazio.", "bg-danger");
                endif;
            // CASO O FORMATO NÃO SEJA PERMITIDO
            else :
                info__show("Formato não permitido.", "bg-danger");
            endif;
    endforeach;
endif;
?>
