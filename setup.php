<!DOCTYPE html>
<html>
<head>
    <title>Настройка базы данных</title>
</head>
<body>

<h3>Настройка...</h3>

<?php
require_once 'db_config.php';

$connection = new mysqli($db_host, $db_user, $db_pass);
if ($connection->connect_error) {
    die ('Ошибка ' . $connection->connect_errno . ' при подключении базы данных.<br>Описание: '. $connection->connect_error);
}

createDATABASE($db_name);

$connection->close();
?>

<br>...Этап создания БД завершен!<br><br>

<?php
$connection = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($connection->connect_error) {
    die ('Ошибка ' . $connection->connect_errno . ' при подключении базы данных.<br>Описание: '. $connection->connect_error);
}

createTable('members', 'id INT UNSIGNED AUTO_INCREMENT KEY,
                        login VARCHAR(16),
                        password VARCHAR(32) NOT NULL');


createTable('member_info', 'member_login VARCHAR(16),
                            name VARCHAR(32),
                            age INT(3) UNSIGNED,
                            description TEXT(100),
                            photo VARCHAR(32)');

$connection->close();
?>

<br>...Этап создания таблицы завершен!

</body>
</html>
