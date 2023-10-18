<?php

require_once './app/models/album.model.php';
require_once './app/models/band.model.php';
require_once './app/views/album.view.php';
require_once './app/helpers/auth.helper.php';

class AlbumController {
    private $albumModel;
    private $bandModel;
    private $view;

    public function __construct() {
        AuthHelper::init();
        $this->albumModel = new AlbumModel();
        $this->bandModel = new BandModel();
        $this->view = new AlbumView();
    }

    /**
     * Muestra todos los álbumes
     */
    public function showAlbums() {
        // Se obtienen los álbumes
        $albums = $this->albumModel->getAlbums();

        // Se obtienen las bandas para generar los formularios
        $bands = $this->bandModel->getBands(); 

        // Se muestra la tabla de álbumes
        $this->view->showAlbums($albums, $bands);
    }

    /**
     *  Muestra el álbum con el ID dado
     */
    public function showAlbumById($id) {
        if ($id) {
            $album = $this->albumModel->getAlbumById($id);
            $band = $this->bandModel->getBandById($album->band_id);
            $this->view->showAlbum($album, $band);
        } else {
            $error = "ID de álbum inválido.";
            $this->view->showError($error);
        }
    }

    /**
     * Crea un álbum en la DB e informa a la vista en caso que se haya producido un error
     */
    public function addAlbum() {
        AuthHelper::verify();
        $title = $_POST["title"];
        $year = $_POST["year"];
        $band_id = $_POST["band_id"];

        if (empty($title) || empty($year) || empty($band_id)) {
            $error = "Faltan completar campos.";
            $this->view->showError($error);
            return;
        }

        $bandExists = $this->albumModel->checkBandExists($band_id);
        if (!$bandExists) {
            $error = "La banda no existe: debe crearla primero.";
            $this->view->showError($error);
            return;
        }

        $id = $this->albumModel->insertAlbum($title, $year, $band_id);
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
        AuthHelper::verify();
        $deleted = $this->albumModel->deleteAlbum($id);
        if ($deleted) {
            header('Location: ' . BASE_URL . '/albums');
        } else {
            $error = "No se pudo eliminar el album de la base de datos.";
            $this->view->showError($error);
        }
    }

    /**
     * Modifica el álbum con el ID dado
     */
    public function editAlbum($id) {
        AuthHelper::verify();
        if (empty($_POST)) {
            $album = $this->albumModel->getAlbumById($id);
            $bands = $this->bandModel->getBands();
            $currentBand = $this->bandModel->getBandOfAlbum($album);
            $this->view->showAlbumEditForm($album, $bands, $currentBand);
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

        $this->albumModel->editAlbum($id, $title, $year, $band_id);

        header('Location: ' . BASE_URL . '/albums');
    }
}
