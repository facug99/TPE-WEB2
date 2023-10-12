<?php

require_once './app/models/album.model.php';
require_once './app/views/album.view.php';

class AlbumController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new AlbumModel();
        $this->view = new AlbumView();
    }

    public function showAlbums() {
        
    }

    public function showAlbumById($id) {

    }

}
