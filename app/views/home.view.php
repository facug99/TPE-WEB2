<?php

class HomeView {
    public function showHome() {
        require_once "./templates/home.phtml";
    }

    public function showError($error) {
        require_once "templates/error.phtml";
    }
}