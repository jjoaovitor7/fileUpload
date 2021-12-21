<?php
require_once __DIR__ . "/src/db_connect.php";
require_once __DIR__ . "/src/format_bytes.php";

// INICIAR SESSÃO
session_start();

// SE O USUÁRIO NÃO ESTIVER LOGADO
if (!(isset($_SESSION["logged"]))):
    if (!(isset($_SESSION["id"]))):
        header("Location: access.php");
    endif;
endif;

// DOWNLOAD DO ARQUIVO
if (isset($_GET["id"])):
    $sql = "SELECT * FROM files WHERE id = " . $_GET['id'];
    $query = $mysqli->query($sql);

    if ($query):
        $r = $query->fetch_row();
        if ($_SESSION["id"] == $r[4]):
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
?>

<?php require_once __DIR__ . "/src/parts/header.php" ?>
<?php include_once "src/home.php"; ?>
<div class="container">
    <div class="d-flex justify-content-end align-items-center mt-5">
        <a href="logout.php">Logout</a>
    </div>
    <h1 id="header__title" class="text-center mt-3">jjFileUpload</h1>

    <!-- NÃO USAR echo $_SERVER["PHP_SELF"]; por questões de segurança (XSS) -->
    <!-- enctype="multipart/form-data" para envio de arquivos -->
    <div>
        <form action="/index.php" method="POST" enctype="multipart/form-data">
            <div class="mt-5">
                <label for="inputFile" class="form-label text-danger">Extensões não permitidas:
                    <?php
                    for ($i=0; $i < count($notExts); $i++):
                        if ($notExts == count($notExts)-1) {
                            echo "." . $notExts[$i];
                        }
                        else {
                            echo "." . $notExts[$i] . ", ";
                        }
                    endfor;
                    ?>
                </label>
                <input id="inputFile" type="file" class="form-control" name="file[]" multiple />
                <input type="submit" class="form-control" value="enviar" name="action__send" />
            </div>
        </form>
    </div>

    <fieldset class="mt-5">
        <legend>Arquivos</legend>
        <?php
            $sql = "SELECT * FROM files WHERE owner_id =" . $_SESSION['id'];
            $query = $mysqli->query($sql);

        ?>
        <div id="container__files">
        <?php
            while ($r = $query->fetch_row()):
        ?>
        <a href="index.php?id=<?php echo $r[0]; ?>"><div class="card text-dark bg-light mb-3 mx-3" style="max-width: 18rem;">
            <div class="card-header"><?php echo $r[2]; ?></div>
                <div class="card-body">
                    <p class="card-text"><?php echo $r[3] ?></p>
                    <p class="card-text"><?php echo formatBytes(strlen($r[1])) ?></p>
                </div>
            </div>
        <?php
            endwhile;
        ?>
        </div>
    </fieldset>
</div>

<?php
require_once __DIR__ . "/src/parts/footer.php";
require_once __DIR__ . "/src/db_connect_close.php";
?>
