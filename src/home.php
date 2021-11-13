<?php

session_start();

if (isset($_SESSION['logged'])):
    require_once "format_bytes.php";
    $uploadsFolder = "files";
    function showToast($message) {
        return "<br />
        <div class='toast show' role='alert' data-bs-autohide='true'>
            <div class='toast-body'>
                $message
            </div>
        </div>";
    }

    function sendFile($file, $tmp, $folder, $filenameToServer)
    {
        if (move_uploaded_file($tmp, $folder . $filenameToServer)) :
            echo showToast("Upload realizado!<br />($file -> $filenameToServer)");
        else :
            echo showToast("Upload falhou!<br />($file -> $filenameToServer)");
        endif;
    }

    $notExts = array("exe", "bat", "sh", "vbs");
    // SE BOTÃO DE ENVIAR CLICADO
    if (isset($_POST['action__send'])) :
        foreach ($_FILES['file']['name'] as $index => $fileElem) :
                // PEGA A EXTENSÃO DO ARQUIVO
                $ext = pathinfo($fileElem, PATHINFO_EXTENSION);

                // VERIFICANDO EXTENSÕES
                if (!(in_array($ext, $notExts))) :
                    $tmp = $_FILES['file']['tmp_name'][$index];

                    if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . $uploadsFolder)) :
                        sendFile($fileElem, $tmp, __DIR__ . DIRECTORY_SEPARATOR . $uploadsFolder . DIRECTORY_SEPARATOR, $fileElem);
                    else :
                        mkdir(__DIR__ . DIRECTORY_SEPARATOR . $uploadsFolder);
                        sendFile($fileElem, $tmp, __DIR__ . DIRECTORY_SEPARATOR . $uploadsFolder . DIRECTORY_SEPARATOR, $fileElem);
                    endif;
                else :
                    echo showToast("Formato não permitido.");
                endif;
        endforeach;
    endif;
else:
    header("Location: ../access.php");
endif;
?>
