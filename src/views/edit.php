<?php
require_once __DIR__ . "/parts/header.php";
?>

<div class="mt-5 d-flex flex-column justify-content-center align-items-center">
    <h2 class="display-5">Editar arquivo</h2>
    <form id="edit__file" action="/" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="file__id" value="<?php echo $_GET["id"]; ?>" />
        <input class="form-control" type="text" name="file__name" placeholder="Nome do Arquivo" />
        <input class="form-control" type="file" name="file" />
        <div class="d-flex justify-content-center mt-2">
            <input class="btn btn-primary" type="submit" name="action__edit" value="Editar" />
        </div>
    </form>
</div>

<script>

</script>
<?php
require_once __DIR__ . "/parts/footer.php";
?>
