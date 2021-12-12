<?php
$ip = "";
$username = "";
$password = "";
$db_name = "";

$connection = mysqli_connect($ip, $username, $password, $db_name);
mysqli_set_charset($connection, "utf8");

if (mysqli_connect_error()) :
    echo "Falha na conexão.<br />" . mysqli_connect_error();
endif;
