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
        $albums = $this->model->getAlbums();
        $this->view->showAlbums($albums);
    }

    public function showAlbumById($id) {
        
        if ($id) {  
            $album = $this->model->getAlbumById($id);
            $this->view->showAlbum($album);
        } else {
            $error = "Error al mostrar el album.";
            $details = "ID inválido.";
            $this->view->showError($error, $details);
           }
        }

    public function addAlbum() {
        $title = $_POST["title"];
        $year = $_POST["year"];
        $band_id = $_POST["band_id"];


        if (empty($title) || empty($year) || empty($band_id) || isset($band_id)) {
            $error = "Faltan completar campos o la banda no esta en la base de datos.";
            $this->view->showError($error);
            return;
        }

        $id = $this->model->insertAlbum($title,$year,$band_id);

        if ($id != 0) {
            header('Location: ' . BASE_URL . '/albums');
        } else {
            $error = "Error al insertar el album en la base de datos ";
            $this->view->showError($error);
            return;
        }

        }

    public function deleteAlbum($id) {    
        $deleted = $this->model->deleteAlbum($id);    
        if ($deleted) {
            $albums = $this->model->getAlbums();
            $this->view->showAlbums($albums);
        } else {
            $error = "No se pudo eliminar el album de la base de datos";
            $this->view->showError($error);
        }
    }

    public function editAlbum($id) {
        if (empty($_POST)) {
            $album = $this->model->getAlbumById($id);
            $this->view->showAlbumEditForm($album);
            return;
        }

        $title = $_POST["title"];
        $year = $_POST["year"];
        $band_id = $_POST["band_id"];

        if (empty($title) || empty($year) || empty($band_id) || isset($band_id)) {
            $error = "Faltan completar campos o la banda no esta en la base de datos.";
            $this->view->showError($error);
            return;
        }

        $modified = $this->model->editAlbum($id, $title, $year, $band_id);

        if ($modified) {
            
            $albums = $this->model->getAlbums();
            $this->view->showAlbums($albums);
        } else {
            $error = "No se pudo eliminar el album de la base de datos";
            $this->view->showError($error);
        }
    }

}
