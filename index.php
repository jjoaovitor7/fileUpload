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
    <h1 class="text-center mt-5">File Upload</h1>
    <form action="/" method="POST" enctype="multipart/form-data">
        <div class="mx-5">
            <label for="inputFile" class="form-label">Arquivos não permitidos: .exe, .bat, .sh</label>
            <input id="inputFile" type="file" class="form-control" name="file[]" multiple />
            <input type="submit" class="form-control" value="enviar" name="ok" />
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>

<?php include_once "main.php"; ?>
