<?php

require_once './app/views/home.view.php';
require_once './app/helpers/auth.helper.php';

class HomeController {
    private $view;

    public function __construct() {
        AuthHelper::init();
        $this->view = new HomeView();
    }

    public function showHome() {
        $this->view->showHome();
    }
}
