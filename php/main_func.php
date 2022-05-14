<?php
namespace php;
require_once 'php/functions.php';
class User{

    private $pdo;

    private $rules = [
        'name_first' => [
            'required' => 1,
            'field_name' => "Ім'я"
        ],
        'name_last' => [
            'required' => 1,
            'field_name' => 'Прізвище'
        ]
    ];
    private $attrs = [
        'name_first' => '',
        'name_last' => '',
        'role' => 'user',
        'status' => 0
    ];
    private $response = [
        'status' => false,
        'error' => null,
    ];

    public function __construct()
    {
        $this->pdo = require_once 'php/connect_db.php';

    }

    public function showUsers(){
        $res = $this->pdo->query("SELECT * FROM `user` ORDER BY id");
        $users = $res->fetchAll();
        return $users;
    }

    public function addUser(){
        if (isset($_GET['type']) && isset($_POST) && $_GET['type'] == 'add' ){
            $this->loadAttrs($_POST);
            $res = $this->pdo->prepare("INSERT INTO `user`(name_first, name_last, status, role) VALUES (?, ?, ?, ?)");
            try {
                $this->validate();
                $res->execute([$this->attrs['name_first'], $this->attrs['name_last'], $this->attrs['status'], $this->attrs['role']]);
                $id = $this->pdo->lastInsertId();
                $this->loadResponse($id);
            } catch (\PDOException |\Exception $e){
                $this->response['error']['message'] = $e->getMessage();
                $this->response['error']['code'] = $e->getCode();
            }

            echo json_encode($this->response);
            die();
        }
    }

    public function editUser(){
        if (isset($_GET['type']) && !empty($_POST) && $_GET['type'] == 'edit'){
            $this->loadAttrs($_POST);
            $res = $this->pdo->prepare("UPDATE `user` SET name_first = ?, name_last = ?, status = ?, role = ? WHERE id = ?");
            $id = $_GET['id'];
            try {
                $this->validate();
                $res->execute([$this->attrs['name_first'], $this->attrs['name_last'], $this->attrs['status'], $this->attrs['role'], $id]);
                $this->loadResponse($id);
            } catch(\PDOException |\Exception $e) {
                $this->response['error']['message'] = $e->getMessage();
                $this->response['error']['code'] = $e->getCode();
            }
            echo json_encode($this->response);
            die();
        }

        if (isset($_GET['type']) && empty($_POST) && $_GET['type'] == 'edit'){
            $ids = explode(',',$_GET['id']);
            $res = $this->pdo->prepare("UPDATE `user` SET status = ? WHERE id = ?");
            foreach ($ids as $id) $res->execute([$_GET['act'], $id]);
            list($this->response['status'], $this->response['user']['id'], $this->response['user']['status']) = [true, $ids, $_GET['act']];
            echo json_encode($this->response);
            die();
        }
    }

    public function deleteUser(){
        if (isset($_GET['type']) && $_GET['type'] == 'del'){
            $ids = explode(',',$_GET['id']);
            $res = $this->pdo->prepare("DELETE FROM `user` WHERE id = ?");
            foreach ($ids as $id) $res->execute([$id]);
            $this->response['status'] = true;
            $this->response['id'] = $ids;
            echo json_encode($this->response);
            die();
        }
    }

    private function loadAttrs($array) {
        foreach ($array as $name => $value){
            str_replace(' ','', $value);
            $this->attrs[$name] = $value;
        }
        $this->attrs['status'] = isset($array['status']) && !empty($array['status']) ? '1' : '0';
    }

    private function loadResponse($id){
        $this->response['status'] = true;
        $this->response['user']['id'] = $id;
        foreach ($this->attrs as $name => $value){
            $this->response['user'][$name] = $value;
        }
    }

    private function validate(){
        $error = null;
        foreach ($this->attrs as $name => $value){
            if (!array_key_exists($name, $this->rules)) continue;
            if ($this->rules[$name]['required'] && empty($this->attrs[$name])){
                $error .= "<li>Поле {$this->rules[$name]['field_name']} не може бути пустим!</li>";
            }
        }

        if ($error) throw new \Exception($error,100);
    }


}
$user = new User();
$user->editUser();
$user->addUser();
$user->deleteUser();
$users = $user->showUsers();



