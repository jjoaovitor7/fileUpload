<?php
require_once __DIR__ . "/../helpers/sanitize.php";
require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../helpers/info.php";

class AccessController {
    private $mysqli;

    public function __construct($mysqli){
        $this->mysqli = $mysqli;
    }

    public function load() {
        require_once __DIR__ . "/../views/access.php";

        if ($_SERVER['REQUEST_METHOD'] == "POST") :
            if (isset($_POST['action__register'])) :
                // PEGANDO DADOS DO ENVIADOS PELO FORMULÁRIO COM O MÉTODO POST.
                $username = sanitize($this->mysqli->getInstance(), $_POST["input__user"]);
                $password__hash = password_hash($_POST["input__password"], PASSWORD_BCRYPT);
                $hash = sanitize($this->mysqli->getInstance(), $password__hash);

                // CRIANDO OBJETO DO USUÁRIO.
                $user = new User(null, $username, $hash);

                // SE CAMPO DE NOME DE USUÁRIO OU CAMPO DE SENHA ESTIVEREM VAZIOS.
                if (empty($username) || empty($hash)) {
                    info__show("O campo de usuário e/ou de senha não podem estar vazio(s).", "bg-danger");
                } else {
                    // INSERINDO USUÁRIO NO BD.
                    $sql = "INSERT INTO users (username, password) VALUES ('" . $user->getUsername() . "','" . $user->getHash() . "')";
                    $query = $this->mysqli->getInstance()->query($sql);

                    if ($query) :
                        info__show("Usuário cadastrado.", "bg-primary");
                        $this->mysqli->getInstance()->commit();
                    else :
                        info__show("Erro ao cadastrar.", "bg-danger");
                    endif;
                }

            elseif (isset($_POST['action__login'])) :
                $username = sanitize($this->mysqli->getInstance(), $_POST['input__user']);
                $password = sanitize($this->mysqli->getInstance(), $_POST['input__password']);

                if (empty($username) || empty($password)) :
                    info__show("O campo de usuário e/ou de senha não podem estar vazio(s).", "bg-danger");
                else :
                    $sql = "SELECT * FROM users WHERE username ='" . $username . "'";
                    $query = $this->mysqli->getInstance()->query($sql);

                    if ($query->num_rows == 1) :
                        $data = $query->fetch_array(MYSQLI_ASSOC);
                        if (password_verify($password, $data['password'])) :
                            $_SESSION['logged'] = true;
                            $_SESSION['id'] = $data['id'];
                            header("Location: /");
                        else :
                            info__show("Erro.", "bg-danger");
                        endif;
                    else :
                        info__show("Usuário não encontrado.", "bg-danger");
                    endif;
                endif;
            endif;
        endif;

        $this->mysqli->unsetInstance();
    }
}
