<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>File Upload</title>
</head>

<body>
    <div class="container">
        <div class="position-absolute" style="top:0;right:0;">
            <?php include_once "src/home.php"; ?>
        </div>

        <h1 class="text-center mt-5">jjFileUpload</h1>
        
        <!-- NÃO USAR <?php echo $_SERVER["PHP_SELF"]; ?> por questões de segurança (XSS) -->
        <!-- enctype="multipart/form-data" para envio de arquivos -->
        <div>
            <form action="/index.php" method="POST" enctype="multipart/form-data">
                <div>
                    <label for="inputFile" class="form-label">Extensões não permitidas: <?php foreach ($notExts as $notExt) {
                                                                                            echo "." . $notExt . " ";
                                                                                        } ?></label>
                    <input id="inputFile" type="file" class="form-control" name="file[]" multiple />
                    <input type="submit" class="form-control" value="enviar" name="action__send" />
                </div>
            </form>
        </div>

        <fieldset class="mt-5">
            <legend>Arquivos</legend>
            <table class="table">
            <?php
                $path = "src" . DIRECTORY_SEPARATOR . "files";
                $dir = dir($path);

                while ($file = $dir->read()) {
                    if ($file != ".." && $file != ".") {
                        echo "<tr>";
                        $fullpath = $path.DIRECTORY_SEPARATOR.$file;
                        $size = formatBytes(filesize($fullpath));
                        echo "<td><a href=\"$fullpath\">$file</a></td><td>$size</td>";
                        echo "</tr>";
                    }
                }
                $dir->close();
            ?>
            </table>
        </fieldset>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>