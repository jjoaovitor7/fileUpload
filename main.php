<?php

function showToast($message)
{
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
foreach ($_FILES['file']['name'] as $index => $fileElem) :
    // verificando se o botão foi clicado.
    if (isset($_POST['ok'])) :
        // pegando a extensão do arquivo.
        $ext = pathinfo($fileElem, PATHINFO_EXTENSION);

        // verificando se o arquivo não é das extensões .exe, .bat ou .sh.
        if (!(in_array($ext, $notFormats))) :
            $tmp = $_FILES['file']['tmp_name'][$index];

            // gerando um nome para o arquivo que será armazenado no servidor.
            $filenameToServer = uniqid() . "." . $ext;

            if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'files')) :
                sendFile($fileElem, $tmp, __DIR__ . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR, $filenameToServer);
            else :
                mkdir(__DIR__ . DIRECTORY_SEPARATOR . 'files');
                sendFile($fileElem, $tmp, __DIR__ . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR, $filenameToServer);
            endif;
        else :
            echo showToast("Formato não permitido.");
        endif;
    endif;
endforeach;
?>
