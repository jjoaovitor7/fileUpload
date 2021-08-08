<?php
function sendFile($file, $tmp, $folder, $filenameToServer)
{
    move_uploaded_file($tmp, $folder . $filenameToServer)
        ? print "Upload realizado! ($file -> $filenameToServer) <br />"
        : print "Upload falhou.";
}

foreach ($_FILES['file']['name'] as $index => $fileElem) :
    if (isset($_POST['ok'])) :
        $ext = pathinfo($fileElem, PATHINFO_EXTENSION);
        if (!(in_array($ext, array("exe", "bat", "sh")))) :
            $tmp = $_FILES['file']['tmp_name'][$index];
            $filenameToServer = uniqid() . "." . $ext;
            if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'files')) :
                sendFile($fileElem, $tmp, __DIR__ . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR, $filenameToServer);
            else :
                mkdir(__DIR__ . DIRECTORY_SEPARATOR . 'files');
                sendFile($fileElem, $tmp, __DIR__ . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR, $filenameToServer);
            endif;
        else :
            print "Formato não permitido.";
        endif;
    endif;
endforeach;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
</head>

<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
        <input type="file" name="file[]" multiple />
        <input type="submit" value="enviar" name="ok" />
    </form>
</body>

</html>