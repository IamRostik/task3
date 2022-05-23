<?php
$host = 'localhost';
$db_name = 'userms';
$user = 'root';
$pass = '';
$dsn = "mysql:$host;dbname=$db_name;charset=utf8";
$options = [
    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,

];
return [$dsn, $user, $pass, $options];