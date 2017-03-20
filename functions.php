<?php
require_once 'db_config.php';

$connection = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($connection->connect_error) {
    die ('Ошибка ' . $connection->connect_errno . ' при подключении базы данных.<br>Описание: '. $connection->connect_error);
}



function destroySession()
{
    $_SESSION = array();
    if (session_id() != "" || isset($_COOKIE[session_name()]))
        setcookie(session_name(), '', time()-2592000, '/');

    session_destroy();
}

function sanitizeString($var)
{
    global $connection;
    $var = strip_tags($var);
    $var = htmlentities($var);
    $var = stripslashes($var);
    return $connection->real_escape_string($var);
}

