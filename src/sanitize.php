<?php
function sanitize($mysqli, $elem) {
    $filter = $mysqli->real_escape_string($elem);
    $filter = htmlspecialchars($filter);
    return $filter;
}
?>
