<?php
require_once __DIR__ . "/parts/header.php";
?>

<div class="container">
    <!-- LOGOUT -->
    <div class="d-flex justify-content-end align-items-center mt-5">
        <a href="/logout">Logout</a>
    </div>

    <!-- TITLE -->
    <h1 id="header__title" class="text-center mt-3">jjFileUpload</h1>

    <!-- NÃO USAR echo $_SERVER["PHP_SELF"]; por questões de segurança (XSS) -->
    <!-- enctype="multipart/form-data" para envio de arquivos -->
    <div>
        <form action="/" method="POST" enctype="multipart/form-data">
            <div class="mt-5">
                <label for="inputFile" class="form-label text-danger">Extensões não permitidas:
                    <?php
                    $extensions__blocked = $_SESSION["extensions__blocked"];
                    $extensions__count = count($extensions__blocked);
                    for ($i = 0; $i < $extensions__count; $i++) :
                        if ($i == $extensions__count-1) {
                            echo "." .$extensions__blocked[$i];
                        } else {
                            echo "." .$extensions__blocked[$i] . ", ";
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
            <div id="container__files">
                <?php
                    require_once __DIR__ . "/../helpers/Helpers.php";
                    Helpers::listFiles();
                ?>
            </div>
    </fieldset>
</div>

<script>
    function menu__item(e, id) {
        e.preventDefault();

        let contextMenu = `
        <div id="context__menu">
            <a href="edit?id=${id}" class="option">Editar</a>
            <a href="/index?id=${id}&delete=1" class="option">Excluir</a>
        </div>`;

        let contextMenuElem = document.getElementById("context__menu");

        function addContextMenu() {
            document.body.innerHTML += contextMenu;
            let contextMenuElem = document.getElementById("context__menu");
            contextMenuElem.style.left = `${e.clientX}px`;
            contextMenuElem.style.top = `${e.clientY}px`;
        }

        if (contextMenuElem != null) {
            contextMenuElem.remove();
            addContextMenu();
        } else {
            addContextMenu();
        }
    }
</script>

<?php
require_once __DIR__ . "/parts/footer.php";
?>
