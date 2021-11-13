<?php
$ip = "";
$username = "";
$password = "";
$db_name = "";

$connect = mysqli_connect($ip, $username, $password, $db_name);
mysqli_set_charset($connect, "utf8");

if (mysqli_connect_error()) :
    echo "Falha na conexão.<br />" . mysqli_connect_error();
endif;

