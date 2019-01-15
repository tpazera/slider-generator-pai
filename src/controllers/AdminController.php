<?php

require_once __DIR__.'/../model/UserMapper.php';

class AdminController extends AppController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllUsers() {
        $mapper = new UserMapper();
        $users = $mapper->getUsers();
        return $users;
    }

    public function admin() {
        if(isset($_SESSION['id_user']) && isset($_SESSION['role']) && $_SESSION['role'] == 1) {
            $this->render('admin', ['users' => $this->getAllUsers()]);
        } else {
            $url = "http://$_SERVER[HTTP_HOST]/";
            header("Location: {$url}?page=index");
            exit();
        }
    }

    public function changeRole() {
        if (!isset($_POST['id_user']) && !isset($_POST['id_role'])) {
            http_response_code(404);
            return;
        }
        $mapper = new UserMapper();
        if(!$mapper->changeRole((int) $_POST['id_user'], (int) $_POST['id_role'])) {
            http_response_code(404);
            return;
        }
        http_response_code(200);
    }

}