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

try {
    $pdo = new \PDO($dsn, $user, $pass, $options);
    $pdo->query("USE userms");
    return $pdo;
} catch (\PDOException $e){
    echo 'Подключение не удалось: ' . $e->getMessage();
}