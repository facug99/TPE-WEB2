<?php

class ErrorView {
    public function showError($error) {
        require_once "templates/error.phtml";
    }
}