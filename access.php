<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./public/styles/style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<body>
    <div id="access">
        <div id="access__container">
            <h1 class="text-center mt-5">jjFileUpload</h1>
            <div class="d-flex justify-content-center align-items-center mt-3">
                <form action="access.php" method="POST">
                    <div class="d-flex flex-column">
                        <input class="form-control" type="text" name="input__user" id="input__user" placeholder="Username" />
                        <input class="form-control mt-2" type="password" name="input__password" id="input__password" placeholder="Password" />
                    </div>

                    <div class="mt-2">
                        <input class="btn btn-primary" name="action__login" type="submit" value="Logar" />
                        <input class="btn btn-primary" name="action__register" type="submit" value="Registrar" />
                    </div>
                </form>
            </div>
        </div> 
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>

<?php require_once "./src/access.php" ?>
