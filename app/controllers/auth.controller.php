<?php
require_once './app/views/auth.view.php';
require_once './app/models/user.model.php';
require_once './app/helpers/auth.helper.php';

class AuthController {
    private $view;
    private $model;

    function __construct() {
        $this->model = new UserModel();
        $this->view = new AuthView();
    }

    public function showLogin() {
        $this->view->showLogin();
    }

    public function auth() {
        $user = $_POST['username'];
        $password = $_POST['password'];

        if (empty($user) || empty($password)) {
            $this->view->showLogin('Faltan completar datos');
            return;
        }

        $user = $this->model->getUserByUsername($user);
        if ($user && password_verify($password, $user->password)) {
            AuthHelper::login($user);
            header('Location: ' . BASE_URL);
        } else {
            $this->view->showLogin('Usuario inválido');
        }
    }
    public function logout(){
        AuthHelper::logout();
        header('Location: ' . BASE_URL); 
    }

}
