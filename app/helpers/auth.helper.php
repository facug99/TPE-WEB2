<?php

class AuthHelper {
    /**
     * Verifica el estado de la sesión (si no está iniciada, la inicia)
     */
    public static function init() {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    /**
     * Inicia una sesión almacenando el id y nombre del usuario
     */
    public static function login($user) {
        AuthHelper::init();
        $_SESSION['USER_ID'] = $user->id;
        $_SESSION['USER_USERNAME'] = $user->username; 
    }

    /**
     * Cierra la sesión
     */
    public static function logout() {
        AuthHelper::init();
        session_destroy();
    }

    /**
     * Verifica si el usuario está loggeado (si no lo está, lo redirige al login)
     */
    public static function verify() {
        AuthHelper::init();
        if (!isset($_SESSION['USER_ID'])) {
            header('Location: ' . BASE_URL . '/login');
            die();
        }
    }
}