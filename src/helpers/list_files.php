<!-- LISTANDO ARQUIVOS -->
<?php
require_once __DIR__ . "/../models/Singleton.php";
require_once __DIR__ . "/format_bytes.php";

$mysqli = new Singleton("", "", "", "");

$sql = "SELECT * FROM files WHERE owner_id =" . $_SESSION['id'];
$query = $mysqli->getInstance()->query($sql);
?>

<div id="container__files">
    <?php
    while ($r = $query->fetch_row()) :
        $file = new File($r[0], $r[2], $r[1], $r[3], $r[4]);
    ?>
        <a oncontextmenu="menu__item(event, <?php echo $file->getID(); ?>)" id="file-<?php echo $file->getID(); ?>" href="index?id=<?php echo $file->getID(); ?>">
            <div>
                <div class="card text-dark bg-light mb-3 mx-3" style="max-width: 18rem;">
                    <div class="card-header"></span><?php echo $file->getFileName(); ?></span></div>
                    <div class="card-body">
                        <p class="card-text"><?php echo $file->getMimeType(); ?></p>
                        <p class="card-text"><?php echo formatBytes(strlen($file->getFile())); ?></p>
                    </div>
                </div>
            </div>
        </a>
    <?php
    endwhile;
    ?>
</div>

<?php
$mysqli->unsetInstance();
?>
