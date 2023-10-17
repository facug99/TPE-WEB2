<?php

require_once './app/models/user.model.php';
require_once './app/views/auth.view.php';
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

    /**
     * Función de autenticación de usuarios
     */
    public function auth() {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (empty($username) || empty($password)) {
            $this->view->showLogin('Faltan completar datos');
            return;
        }
    
        // Se obtiene el usuario de la base de datos
        $user = $this->model->getUserByUsername($username);

        // Si el usuario existe y coinciden los contraseñas
        if ($user && password_verify($password, $user->password)) {
            // Se inicia sesión y se redirige al usuario al home
            AuthHelper::login($user);
            header('Location: ' . BASE_URL);
        } else {
            // Se muestra un error
            $this->view->showLogin('Usuario inválido');
        }
    }

    public function logout() {
        AuthHelper::logout();
        header('Location: ' . BASE_URL);    
    }
}
