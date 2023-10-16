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

    /**
     * Muestra todos los álbumes
     */
    public function showAlbums() {
        $albums = $this->model->getAlbums();
        $this->view->showAlbums($albums);
    }

    /**
     *  Muestra el álbum con el ID dado
     */
    public function showAlbumById($id) {
        if ($id) {
            $album = $this->model->getAlbumById($id);
            $this->view->showAlbum($album);
        } else {
            $error = "ID de álbum inválido.";
            $this->view->showError($error);
        }
    }

    /**
     * Crea un álbum en la DB e informa a la vista 
     * en caso que se haya producido un error
     */
    public function addAlbum() {
        $title = $_POST["title"];
        $year = $_POST["year"];
        $band_id = $_POST["band_id"];

        if (empty($title) || empty($year) || empty($band_id)) {
            $error = "Faltan completar campos.";
            $this->view->showError($error);
            return;
        }

        $bandExists = $this->model->checkBandExists($band_id);
        if (!$bandExists) {
            $error = "La banda no existe: debe crearla primero.";
            $this->view->showError($error);
            return;
        }

        $id = $this->model->insertAlbum($title, $year, $band_id);
        if ($id != 0) {
            header('Location: ' . BASE_URL . '/albums');
        } else {
            $error = "Error al insertar el album en la base de datos.";
            $this->view->showError($error);
            return;
        }
    }

    /**
     * Elimina el álbum con el ID dado
     */
    public function deleteAlbum($id) {
        $deleted = $this->model->deleteAlbum($id);
        if ($deleted) {
            $albums = $this->model->getAlbums();
            $this->view->showAlbums($albums);
        } else {
            $error = "No se pudo eliminar el album de la base de datos.";
            $this->view->showError($error);
        }
    }

    /**
     * Modifica el álbum con el ID dado
     */
    public function editAlbum($id) {
        if (empty($_POST)) {
            $album = $this->model->getAlbumById($id);
            $this->view->showAlbumEditForm($album);
            return;
        }

        $title = $_POST["title"];
        $year = $_POST["year"];
        $band_id = $_POST["band_id"];

        if (empty($title) || empty($year) || empty($band_id)) {
            $error = "Faltan completar campos.";
            $this->view->showError($error);
            return;
        }

        $modified = $this->model->editAlbum($id, $title, $year, $band_id);

        if ($modified) {
            $albums = $this->model->getAlbums();
            $this->view->showAlbums($albums);
        } else {
            $error = "No se pudo modificar el album en la base de datos.";
            $this->view->showError($error);
        }
    }
}
