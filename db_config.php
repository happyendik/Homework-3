<?php

$db_host = 'localhost';
$db_name = 'Homework_3';
$db_user = 'root';
$db_pass = '';

function queryMysql($query)
{
    global $connection;
    $result = $connection->query($query);
    if (!$result) {
        die ('Ошибка при выполнении запроса -> '. $connection->error);
    }
    return $result;
}

function createDATABASE($name)
{
    queryMysql("CREATE DATABASE IF NOT EXISTS $name CHARACTER SET utf8 COLLATE utf8_unicode_ci");
    echo "База данных '$name' создана или уже существовала<br>";
}

function createTable($name, $query)
{
    queryMysql("CREATE TABLE IF NOT EXISTS $name($query) ENGINE MyISAM");
    echo "Таблица '$name' создана или уже существовала<br>";
}
