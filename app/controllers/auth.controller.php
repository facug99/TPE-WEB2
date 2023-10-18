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

    /**
     * Muestra el formulario de login
     */
    public function showLogin() {
        $this->view->showLogin();
    }

    /**
     * Autenticación del usuario
     */
    public function auth() {
        $user = $_POST['username'];
        $password = $_POST['password'];

        if (empty($user) || empty($password)) {
            $this->view->showLogin('Faltan completar datos');
            return;
        }

        // Se obtiene el usuario de la DB dado un username
        $user = $this->model->getUserByUsername($user);

        // Se verifica que el usuario exista y que coincidan las contraseñas
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
