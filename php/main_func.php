<?php
$pdo = require_once 'php/connect_db.php';
require_once 'php/functions.php';

function showUsers(){
    global $pdo;
    $res = $pdo->query("SELECT * FROM `user` ORDER BY id");
    $users = $res->fetchAll();

    if (isset($_GET['type'])) {
        ob_start();
        require_once 'php/tpl_users.php';
        return ob_get_clean();
    }

    return $users;
}

function addUser(){
    if (isset($_GET['type']) && $_GET['type'] == 'add' && isset($_POST)){
        global $pdo;
        $status = isset($_POST['status']) ? '1' : '0';
        $res = $pdo->prepare("INSERT INTO `user`(first_name, last_name, status, role) VALUES (?, ?, ?, ?)");
        $res->execute([trim($_POST['first_name']), trim($_POST['last_name']), $status, $_POST['role']]);
        echo showUsers();
        die();
    }
}

function editUser(){
    if (isset($_GET['type']) && $_GET['type'] == 'edit' && !empty($_POST)){
        global $pdo;
        $status = isset($_POST['status']) ? '1' : '0';
        $res = $pdo->prepare("UPDATE `user` SET first_name = ?, last_name = ?, status = ?, role = ? WHERE id = ?");
        $res->execute([trim($_POST['first_name']), trim($_POST['last_name']), $status, $_POST['role'], $_GET['id']]);
        echo showUsers();
        die();
    }

    if (isset($_GET['type']) && $_GET['type'] == 'edit' && empty($_POST)){
        global $pdo;
        $ids = explode(',',$_GET['id']);
        $res = $pdo->prepare("UPDATE `user` SET status = ? WHERE id = ?");
        foreach ($ids as $id) $res->execute([$_GET['res'], $id]);
        echo showUsers();
        die();
    }
}

function deleteUser(){
    if (isset($_GET['type']) && $_GET['type'] == 'del'){
        global $pdo;
        $ids = explode(',',$_GET['id']);
        $res = $pdo->prepare("DELETE FROM `user` WHERE id = ?");
        foreach ($ids as $id) $res->execute([$id]);
        echo showUsers();
        die();
    }
}
editUser();
addUser();
deleteUser();
$users = showUsers();



