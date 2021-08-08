<?php
function sendFile($tmp, $folder, $filenameToServer)
{
    move_uploaded_file($tmp, $folder . $filenameToServer)
        ? print "Upload realizado! ($filenameToServer) <br />"
        : print "Upload falhou.";
}

foreach ($_FILES['file']['name'] as $index => $fileElem) :
    if (isset($_POST['ok'])) :
        $ext = pathinfo($fileElem, PATHINFO_EXTENSION);
        if (!(in_array($ext, array("exe", "bat", "sh")))) :
            $tmp = $_FILES['file']['tmp_name'][$index];
            $filenameToServer = uniqid() . "." . $ext;
            if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'files')) :
                sendFile($tmp, __DIR__ . DIRECTORY_SEPARATOR . 'files/', $filenameToServer);
            else :
                mkdir(__DIR__ . DIRECTORY_SEPARATOR . 'files');
                sendFile($tmp, __DIR__ . DIRECTORY_SEPARATOR . 'files/', $filenameToServer);
            endif;
        else :
            print "Formato não permitido.";
        endif;
    endif;
endforeach;
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
    <input type="file" name="file[]" multiple />
    <input type="submit" value="enviar" name="ok" />
</form>