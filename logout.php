<?php
session_start();
session_destroy();
session_unset();

echo "Deslogado.<br />";
echo "<a href='access.php'>Logar novamente?</a>";
?>
