<?php

include_once 'functions.php';
include_once 'Router.php';
class Main_func{

    private $pdo;

    private $rules = [
        'name_first' => [
            'required' => 1,
            'field_name' => "First name"
        ],
        'name_last' => [
            'required' => 1,
            'field_name' => 'Last name'
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

    /**
     * Підключення бази данних
     */
    public function __construct()
    {
        $this->pdo = include_once 'connect_db.php';

    }

    /**
     * Виконує пошук всіх юзерів з таблиці user
     * @return mixed
     */
    public function getUsers(){
        $res = $this->pdo->query("SELECT * FROM `user` ORDER BY id");
        return $res->fetchAll();
    }

    /**
     * Визивається через Ajax.
     * Виконує пошук юзера по id та вертає у відповіді json об'єкт
     */
    public function getOneUser(){
        if (isset($_GET['type']) && isset($_POST) && $_GET['type'] == 'get_user'){
        $id = $_POST['id'];
        $res = $this->pdo->prepare("SELECT * FROM `user` WHERE id = ?");
        try {
            $res->execute([$id]);
            $this->loadAttrs($res->fetch());
            $this->loadResponse($id);
        } catch (\PDOException |\Exception $e){
            $this->response['error']['message'] = $e->getMessage();
            $this->response['error']['code'] = $e->getCode();
        }
        echo json_encode($this->response);
        die();
        }
    }

    /**
     * Визивається через Ajax.
     * Додає нового юзера в таблицю user та вертає у відповіді json об'єкт
     */
    public function addUser(){
        if (isset($_GET['type']) && isset($_POST) && $_GET['type'] == 'add'){
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

    /**
     * Визивається через Ajax.
     * Виконує редагування юзера в таблиці user та вертає у відповіді json об'єкт
     */
    public function editUser(){
        if (isset($_GET['type']) && !empty($_POST) && $_GET['type'] == 'edit_one'){
            $id = $_GET['id'];
            $this->loadAttrs($_POST);
            $res = $this->pdo->prepare("UPDATE `user` SET name_first = ?, name_last = ?, status = ?, role = ? WHERE id = ?");
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
    }

    /**
     * Визивається через Ajax.
     * Виконує редагування поля status юзера/юзерів в таблиці user та вертає у відповіді json об'єкт
     */
    public function editStatusUsers(){
        if (isset($_GET['type']) && !empty($_POST) && $_GET['type'] == 'edit_some'){
            $ids = explode(',',$_POST['id']);
            $res = $this->pdo->prepare("UPDATE `user` SET status = ? WHERE id = ?");
            foreach ($ids as $id) $res->execute([$_POST['act'], $id]);
            list($this->response['status'], $this->response['user']['id'], $this->response['user']['status']) = [true, $ids, $_POST['act']];
            echo json_encode($this->response);
            die();
        }
    }

    /**
     * Визивається через Ajax.
     * Видаляє юзера з таблиці user та вертає у відповіді json об'єкт
     */
    public function deleteUser(){
        if (isset($_GET['type']) && $_GET['type'] == 'del' && !empty($_POST)){
            $ids = explode(',',$_POST['id']);
            $res = $this->pdo->prepare("DELETE FROM `user` WHERE id = ?");
            foreach ($ids as $id) $res->execute([$id]);
            $this->response['status'] = true;
            $this->response['id'] = $ids;
            echo json_encode($this->response);
            die();
        }
    }

    /**
     * Заповнює property $this->attrs даними, отримані параметром $array.
     * @param array $array - массив з данними юзера, переданий з форми методом post
     */
    private function loadAttrs($array) {
        foreach ($array as $name => $value){
            $value = preg_replace("%\s%", '', $value);
            $this->attrs[$name] = $value;
        }
        $this->attrs['status'] = isset($array['status']) && !empty($array['status']) ? '1' : '0';
    }

    /**
     * Заповнює property $this->response отвалідованими даними, які відправляються у відповіді ajax.
     * @param $id - id юзера.
     */
    private function loadResponse($id){
        $this->response['status'] = true;
        $this->response['user']['id'] = $id;
        foreach ($this->attrs as $name => $value){
            $this->response['user'][$name] = $value;
        }
    }

    /**
     * Валідує дані.
     * @throws Exception
     */
    private function validate(){
        $error = null;
        foreach ($this->attrs as $name => $value){
            if (!array_key_exists($name, $this->rules)) continue;
            if ($this->rules[$name]['required'] && empty($this->attrs[$name])){
                $error .= "<li>The \"{$this->rules[$name]['field_name']}\" field cannot be empty!</li>";
            }
        }

        if ($error) throw new \Exception($error,100);
    }

}
return \php\Router::dispatch($_SERVER['PHP_SELF']);
