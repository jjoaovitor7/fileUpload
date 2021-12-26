<?php
require_once __DIR__ . "/../models/Singleton.php";
require_once __DIR__ . "/../env.php";

class Helpers {
    public function __construct() {
    }

    public static function formatBytes($bytes, $precision=2) { 
        $units = array('B', 'KB', 'MB', 'GB', 'TB'); 
       
        $bytes = max($bytes, 0); 
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
        $pow = min($pow, count($units) - 1); 
       
        $bytes /= pow(1024, $pow); 
       
        return round($bytes, $precision) . ' ' . $units[$pow]; 
    }

    public static function showInfo($message, $bg) {
        echo "<div class='position-absolute' style='right:0; top:0;'>
            <div class='toast show align-items-center text-white $bg border-0' role='alert' aria-live='assertive' aria-atomic='true'>
                <div class='d-flex'>
                    <div class='toast-body'>
                        $message
                    </div>
                    <button type='button' class='btn-close btn-close-white me-2 m-auto' data-bs-dismiss='toast' aria-label='Close'></button>
                </div>
            </div></div>";
    }

    public static function sanitize($mysqli, $elem) {
        $filter = $mysqli->real_escape_string($elem);
        $filter = htmlspecialchars($filter);
        return $filter;
    }

    public static function listFiles() {
        $mysqli = new Singleton(SERVER_IP, DB_USER, DB_PASSWORD, DB_NAME);
        $sql = "SELECT * FROM files WHERE owner_id =" . $_SESSION['id'];
        $query = $mysqli->getInstance()->query($sql);
        
        while ($r = $query->fetch_row()) :
            $file = new File($r[0], $r[2], $r[1], $r[3], $r[4]);
        ?>
            <a oncontextmenu="menu__item(event, <?php echo $file->getID(); ?>)" id="file-<?php echo $file->getID(); ?>" href="index?id=<?php echo $file->getID(); ?>">
                <div class="card text-dark bg-light mb-3 mx-3" style="max-width: 18rem;">
                        <div class="card-header"></span><?php echo $file->getFileName(); ?></span></div>
                        <div class="card-body">
                            <p class="card-text"><?php echo $file->getMimeType(); ?></p>
                            <p class="card-text"><?php echo self::formatBytes(strlen($file->getFile())); ?></p>
                        </div>
                </div>
            </a>
        <?php
        endwhile;
        $mysqli->unsetInstance();
    }
}
?>
