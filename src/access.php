<?php

require_once "db_connect.php";
require_once "sanitize.php";
require_once "info.php";

if (isset($_POST['action__register'])) :
    // PEGANDO DADOS DO ENVIADOS PELO FORMULÁRIO COM O MÉTODO POST.
    $username = sanitize($mysqli, $_POST["input__user"]);
    $password__hash = password_hash($_POST["input__password"], PASSWORD_BCRYPT);
    $password = sanitize($mysqli, $password__hash);

    if (empty($username) || empty($password)) {
        info__show("O campo de usuário e/ou de senha não podem estar vazio(s).", "bg-danger");
    } else {
        // INSERINDO USUÁRIO NO BD.
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        $query = $mysqli->query($sql);

        if ($query) :
            info__show("Usuário cadastrado.", "bg-primary");
            $mysqli->commit();
        else:
            info__show("Erro ao cadastrar.", "bg-danger");
        endif;
    }

elseif (isset($_POST['action__login'])) :
    $username = sanitize($mysqli, $_POST['input__user']);
    $password = sanitize($mysqli, $_POST['input__password']);

    if (empty($username) || empty($password)) {
        info__show("O campo de usuário e/ou de senha não podem estar vazio(s).", "bg-danger");
    } else {
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $query = $mysqli->query($sql);

        if ($query->num_rows == 1) {
            $data = $query->fetch_array(MYSQLI_ASSOC);
            if (password_verify($password, $data['password'])) {
                $_SESSION['logged'] = true;
                $_SESSION['id'] = $data['id'];
                header("Location: ../index.php");
            } else {
                info__show("Erro.", "bg-danger");
            }
        } else {
            info__show("Usuário não encontrado.", "bg-danger");
        }
    }
endif;

require_once "db_connect_close.php";
