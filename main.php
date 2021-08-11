<?php
function sendFile($file, $tmp, $folder, $filenameToServer)
{
    if (move_uploaded_file($tmp, $folder . $filenameToServer)) :
        echo "
        <br />
        <div class='d-flex flex-column align-items-end'>
            <div class='toast show' role='alert' data-bs-autohide='true'>
                <div class='toast-body'>
                    Upload realizado! <br />($file -> $filenameToServer)
                </div>
            </div> 
        </div>";
    else :
        echo "
        <br />
        <div class='d-flex flex-column align-items-end'>
            <div class='toast show' role='alert' data-bs-autohide='true'>
                <div class='toast-body'>
                    Upload falhou! ($file -> $filenameToServer)
                </div>
            </div> 
        </div>";
    endif;
}

foreach ($_FILES['file']['name'] as $index => $fileElem) :
    // verificando se o botão foi clicado.
    if (isset($_POST['ok'])) :
        // pegando a extensão do arquivo.
        $ext = pathinfo($fileElem, PATHINFO_EXTENSION);

        // verificando se o arquivo não é das extensões .exe, .bat ou .sh.
        if (!(in_array($ext, array("exe", "bat", "sh")))) :
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
            echo "
            <br />
            <div class='d-flex flex-column align-items-end'>
                <div class='toast show' role='alert' data-bs-autohide='true'>
                    <div class='toast-body'>
                        Formato não permitido.
                    </div>
                </div> 
            </div>";
        endif;
    endif;
endforeach;
