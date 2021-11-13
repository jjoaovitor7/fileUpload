<?php
session_start();

require_once "db_connect.php";

function clear($elem) {
    global $connect;
    $filter = mysqli_escape_string($connect, $elem);
    $filter = htmlspecialchars($filter);
    return $filter;
}

if (isset($_POST["action__register"])):
    $username = clear($_POST["input__user"]);
    $password = clear(password_hash($_POST["input__password"], PASSWORD_BCRYPT));

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

    if (mysqli_query($connect, $sql)):
        echo '
        <div class="position-absolute" style="right:0; top:0;">
        <div class="toast show align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Usuário cadastrado.
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div></div>';
        mysqli_commit($connect);
    else:
        echo '
        <div class="position-absolute" style="right:0; top:0;">
        <div class="toast show align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Erro ao cadastrar.
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div></div>';
    endif;

elseif (isset($_POST['action__login'])):
    $username = clear($_POST["input__user"]);
    $password = clear($_POST["input__password"]);

    if (empty($username) || empty($password)) {
        echo '
        <div class="position-absolute" style="right:0; top:0;">
        <div class="toast show align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    O campo de usuário e/ou de senha não podem estar vazio(s).
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div></div>';
    }
    else {
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $query = mysqli_query($connect, $sql);

        if (mysqli_num_rows($query) > 0) {
            $data = mysqli_fetch_array($query);

            if (mysqli_num_rows($query) == 1 && password_verify($password, $data['password'])) {
                $_SESSION['logged'] = true;
                $_SESSION['id'] = $data['id'];
                header("Location: ../index.php");
            } else {
                echo '
                <div class="position-absolute" style="right:0; top:0;">
                <div class="toast show align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            Erro.
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div></div>';

            }
        } else {
            echo '
            <div class="position-absolute" style="right:0; top:0;">
            <div class="toast show align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        Usuário não encontrado.
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div></div>';
        }
    }

endif;

mysqli_close($connect);
?>
