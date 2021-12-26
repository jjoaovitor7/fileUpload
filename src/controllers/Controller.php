<?php
require_once __DIR__ . "/ViewsController.php";
require_once __DIR__ . "/../models/File.php";
require_once __DIR__ . "/../models/Singleton.php";
require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../helpers/Helpers.php";
require_once __DIR__ . "/../env.php";

session_start();

class Controller {
    private $mysqli;
    private $views;

    public function __construct() {
        $this->mysqli = new Singleton(SERVER_IP, DB_USER, DB_PASSWORD, DB_NAME);
        $this->views = new ViewsController();
    }

    public function access() {
        if ($_SERVER['REQUEST_METHOD'] == "POST") :
            if (isset($_POST['action__register'])) :
                // PEGANDO DADOS DO ENVIADOS PELO FORMULÁRIO COM O MÉTODO POST.
                $username = Helpers::sanitize($this->mysqli->getInstance(), $_POST["input__user"]);
                $password__hash = password_hash($_POST["input__password"], PASSWORD_BCRYPT);
                $hash = Helpers::sanitize($this->mysqli->getInstance(), $password__hash);

                // CRIANDO OBJETO DO USUÁRIO.
                $user = new User(null, $username, $hash);

                // SE CAMPO DE NOME DE USUÁRIO OU CAMPO DE SENHA ESTIVEREM VAZIOS.
                if (empty($username) || empty($hash)) {
                    Helpers::showInfo("O campo de usuário e/ou de senha não podem estar vazio(s).", "bg-danger");
                } else {
                    // INSERINDO USUÁRIO NO BD.
                    $sql = "INSERT INTO users (username, password) VALUES ('" . $user->getUsername() . "','" . $user->getHash() . "')";
                    $query = $this->mysqli->getInstance()->query($sql);

                    if ($query) :
                        Helpers::showInfo("Usuário cadastrado.", "bg-primary");
                        $this->mysqli->getInstance()->commit();
                    else :
                        Helpers::showInfo("Erro ao cadastrar.", "bg-danger");
                    endif;
                }

            elseif (isset($_POST['action__login'])) :
                $username = Helpers::sanitize($this->mysqli->getInstance(), $_POST['input__user']);
                $password = Helpers::sanitize($this->mysqli->getInstance(), $_POST['input__password']);

                if (empty($username) || empty($password)) :
                    Helpers::showInfo("O campo de usuário e/ou de senha não podem estar vazio(s).", "bg-danger");
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
                            Helpers::showInfo("Erro.", "bg-danger");
                        endif;
                    else :
                        Helpers::showInfo("Usuário não encontrado.", "bg-danger");
                    endif;
                endif;
            endif;
        endif;

        $this->views->render("access");
        $this->mysqli->unsetInstance();
    }

    public function index() {
        $extensions__blocked = array("exe", "bat", "sh", "vbs", "js", "msi", "cmd", "vb", "lnk", "inf", "reg");
        $_SESSION["extensions__blocked"] = $extensions__blocked;

        if (isset($_GET["id"])) :
            // EXCLUSÃO DO ARQUIVO
            if (isset($_GET["delete"])):
                    $sql = "DELETE FROM `files` WHERE `id`=" . $_GET['id'] . " AND owner_id=" . $_SESSION["id"];
                    $query = $this->mysqli->getInstance()->query($sql);

                    if (!$query):
                        Helpers::showInfo("Erro.", "bg-danger");
                    else:
                        $this->mysqli->getInstance()->commit();
                    endif;

            // DOWNLOAD DO ARQUIVO
            else:
                $sql = "SELECT * FROM files WHERE id = " . $_GET['id'];
                $query = $this->mysqli->getInstance()->query($sql);

                if ($query) :
                    $r = $query->fetch_row();
                    if ($_SESSION["id"] == $r[4]) :
                        $filename = $r[2];
                        $file = $r[1];
                        // $size = strlen($file);
                        $type = $r[3];
                        // header("Content-Length: $size");
                        header("Content-Type: $type; charset=utf-8");
                        header("Content-Disposition: attachment; filename=$filename");

                        echo $file;
                        die();
                    endif;
                endif;
            endif;
        endif;

        if (!(isset($_GET["edit"]))):
            // SE BOTÃO DE ENVIAR CLICADO
            if ($_SERVER['REQUEST_METHOD'] == "POST") :
                if (isset($_POST['action__send'])) :
                    foreach ($_FILES['file']['name'] as $index => $fileElem) :
                        // PEGA A EXTENSÃO DO ARQUIVO
                        $ext = pathinfo($fileElem, PATHINFO_EXTENSION);

                        // VERIFICANDO SE EXTENSÃO É PERMITIDA
                        if (!(in_array($ext, $extensions__blocked))) :
                            $tmp = $_FILES['file']['tmp_name'][$index];
                            if (strlen(file_get_contents($tmp)) != 0) :
                                $file = new File(
                                    null,
                                    Helpers::sanitize($this->mysqli->getInstance(), $fileElem),
                                    $this->mysqli->getInstance()->real_escape_string(file_get_contents($tmp)),
                                    Helpers::sanitize($this->mysqli->getInstance(), mime_content_type($tmp)),
                                    Helpers::sanitize($this->mysqli->getInstance(), $_SESSION["id"])
                                );

                                $sql = "INSERT INTO files(`file`, `file_name`, `mime_type`, `owner_id`) VALUES ('"
                                    . $file->getFile() . "','"
                                    . $file->getFileName() . "','"
                                    . $file->getMimeType() . "',"
                                    . $file->getOwnerID() . ")";

                                // REALIZANDO O INSERT
                                $query = $this->mysqli->getInstance()->query($sql);
                                if ($query) :
                                    $this->mysqli->getInstance()->commit();
                                    Helpers::showInfo("Arquivo enviado.", "bg-primary");
                                else :
                                    Helpers::showInfo("Erro.", "bg-danger");
                                endif;

                            // CASO O ARQUIVO ESTEJA COM 0 BYTES
                            else :
                                Helpers::showInfo("Arquivo vazio.", "bg-danger");
                            endif;
                        // CASO O FORMATO NÃO SEJA PERMITIDO
                        else :
                            Helpers::showInfo("Formato não permitido.", "bg-danger");
                        endif;
                    endforeach;
                elseif (isset($_POST["action__edit"])):
                    $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                    $file__post =file_get_contents($_FILES["file"]["tmp_name"]);
                    $sql = "UPDATE `files`"
                    ." SET `file_name`='".Helpers::sanitize($this->mysqli->getInstance(), $_POST["file__name"].".".strtolower($ext))
                    ."',`file`='". $this->mysqli->getInstance()->real_escape_string($file__post)
                    ."', `mime_type`='".Helpers::sanitize($this->mysqli->getInstance(), mime_content_type($_FILES["file"]["tmp_name"]))
                    ."' WHERE `id`=".Helpers::sanitize($this->mysqli->getInstance(), intval($_POST["file__id"]))
                    ." AND `owner_id`=".Helpers::sanitize($this->mysqli->getInstance(), intval($_SESSION['id']));

                    $query = $this->mysqli->getInstance()->query($sql);
                    if ($query) :
                        $this->mysqli->getInstance()->commit();
                    else :
                        echo $this->mysqli->getInstance()->error;
                        Helpers::showInfo("Erro.", "bg-danger");
                    endif;
                endif;
            endif;
        endif;

        $this->views->render("index");
        $this->mysqli->unsetInstance();
    }

    public function logout() {
        if (isset($_SESSION)):
            session_destroy();
            session_unset();
        endif;

        $this->views->render("logout");
        $this->mysqli->unsetInstance();
    }

    public function edit() {
        $this->views->render("edit");
        $this->mysqli->unsetInstance();
    }

    public function error_404() {
        $this->views->render("404");
        $this->mysqli->unsetInstance();
    }
}
?>
