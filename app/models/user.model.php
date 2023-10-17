<?php

class UserModel {
    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=web2_tpe;charset=utf8', 'root', '');
    }

    /**
     * Obtiene un usuario dado su nombre de usuario
     */
    public function getUserByUsername($username) {
        $query = $this->db->prepare('SELECT * FROM users WHERE username = ?');
        $query->execute([$username]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
}
