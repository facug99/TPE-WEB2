<?php

require_once './app/views/home.view.php';
require_once './app/helpers/auth.helper.php';

class HomeController {
    private $view;

    public function __construct() {
        AuthHelper::init();
        $this->view = new HomeView();
    }

    /**
     * Muestra la página de inicio
     */
    public function showHome() {
        $this->view->showHome();
    }

    /**
     * Envía a la vista un error dado para que lo muestre
     */
    public function showError($error) {
        $this->view->showError($error);
    }
}
