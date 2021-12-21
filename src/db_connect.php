<?php
$ip = "";
$username = "";
$password = "";
$db_name = "";

if (!isset($mysqli)):
    $mysqli = new mysqli($ip, $username, $password, $db_name);

    $mysqli->set_charset("utf8");
    // echo $mysqli->character_set_name();

    if ($mysqli->connect_errno) :
        echo "Falha na conexão com o banco de dados.<br />";
    endif;

    $mysqli->autocommit(FALSE);
endif;
?>
