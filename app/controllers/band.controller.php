<?php

require_once './app/models/band.model.php';
require_once './app/models/album.model.php';
require_once './app/views/band.view.php';
require_once './app/helpers/auth.helper.php';

class BandController {
    private $bandModel;
    private $albumModel;
    private $bandView;

    public function __construct() {
        AuthHelper::init();
        $this->bandModel = new BandModel();
        $this->albumModel = new AlbumModel();
        $this->bandView = new BandView();
    }

    /**
     * Muestra todas las bandas
     */
    public function showBands() {
        // Se obtienen las bandas del modelo
        $bands = $this->bandModel->getBands();

        // Se envían a la vista para que las muestre
        $this->bandView->showBands($bands);
    }

    /**
     *  Muestra la banda con el ID dado
     */
    public function showBandById($id) {
        // Se verifica si existe la banda
        if ($id) {
            // Se pide la banda y los álbumes a los modelos
            $band = $this->bandModel->getBandById($id);
            $albums = $this->albumModel->getAlbumsOfBand($id);

            // Se la envía a la vista para que la muestre
            $this->bandView->showBand($band, $albums);
        } else {
            // La vista muestra un error
            $error = "ID de banda inválido";
            $this->bandView->showError($error);
        }
    }

    /**
     * Crea una banda en la DB e informa a la vista 
     * en caso que se haya producido un error
     */
    public function addBand() {
        // Se verifica el inicio de sesión
        AuthHelper::verify();

        $name = $_POST["name"];
        $genre = $_POST["genre"];
        $location = $_POST["location"];
        $year = $_POST["year"];

        // Se verifican los datos ingresados
        if (empty($name) || empty($genre) || empty($location) || empty($year)) {
            $error = "Faltan completar campos.";
            $this->bandView->showError($error);
            return;
        }

        // Se verifica si la banda ingresada ya existe
        $exists = $this->bandModel->checkBandExists($name);

        if ($exists) {
            $error = "La banda ya existe.";
            $this->bandView->showError($error);
            return;
        }

        // Se inserta en la banda DB
        $id = $this->bandModel->insertBand($name, $genre, $location, $year);
        
        // Se verifica si se insertó correctamente
        if ($id != 0) {
            header('Location: ' . BASE_URL . '/bands');
        } else {
            $error = "Error al insertar la banda en la base de datos.";
            $this->bandView->showError($error);
            return;
        }
    }

    /**
     * Elimina la banda con el ID dado
     */
    public function deleteBand($id) {
        // Se verifica el inicio de sesión
        AuthHelper::verify();

        // Se verifica si existe la banda a eliminar
        $band = $this->bandModel->getBandById($id);
        if (empty($band)) {
            $error = "La banda con id = $id no existe.";
            $this->bandView->showError($error);
            return;
        }

        // Se obtienen los álbumes para verificar si se puede eliminar la banda (FK)
        $albums = $this->albumModel->getAlbums();

        // Se elimina la banda de la DB a través del modelo
        $deleted = $this->bandModel->deleteBand($id, $albums);

        // Se verifica si se eliminó correctamente de la DB
        if ($deleted) {
            // Si se eliminó, se actualiza la vista
            header('Location: ' . BASE_URL . '/bands');
        } else {
            // Sino, se muestra un error
            $error = "No se pudo eliminar la banda de la base de datos: se deben eliminar primero sus álbumes.";
            $this->bandView->showError($error);
        }
    }

    /**
     * Modifica la banda con el ID dado
     */
    public function editBand($id) {
        // Se verifica el inicio de sesión
        AuthHelper::verify();

        // Si no hay elementos en $_POST se muestra el formulario de edición
        if (empty($_POST)) {
            $band = $this->bandModel->getBandById($id);
            $this->bandView->showBandEditForm($band);
            return;
        }

        $name = $_POST["name"];
        $genre = $_POST["genre"];
        $location = $_POST["location"];
        $year = $_POST["year"];

        if (empty($name) || empty($genre) || empty($location) || empty($year)) {
            $error = "Faltan completar campos.";
            $this->bandView->showError($error);
            return;
        }

        // Se verifica si existe otra banda con el mismo nombre
        $band = $this->bandModel->getBandById($id);
        $exists = $this->bandModel->checkBandExists($name, $band->name);

        // Si existe, se muestra un error
        if ($exists) {
            $error = "La banda ya existe.";
            $this->bandView->showError($error);
            return;
        }

        // Si no existe, se modifica la banda
        $this->bandModel->editBand($id, $name, $genre, $location, $year);

        // Y se actualiza la vista
        header('Location: ' . BASE_URL . '/bands');
    }
}
