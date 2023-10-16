<?php

require_once './app/models/band.model.php';
require_once './app/views/band.view.php';

class BandController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new BandModel();
        $this->view = new BandView();
    }

    /**
     * Muestra todas las bandas
     */
    public function showBands() {
        // Se obtienen las bandas del modelo
        $bands = $this->model->getBands();

        // Se envían a la vista para que las muestre
        $this->view->showBands($bands);
    }

    /**
     *  Muestra la banda con el ID dado
     */
    public function showBandById($id) {
        // Se verifica si existe la banda
        if ($id) {
            // Se pide la banda a la base de datos
            $band = $this->model->getBandById($id);
            $albums = $this->model->getBandAlbums($id);

            // Se la envía a la vista para que la muestre
            $this->view->showBand($band, $albums);
        } else {
            // La vista muestra un error
            $error = "ID de banda inválido";
            $this->view->showError($error);
        }
    }

    /**
     * Crea una banda en la DB e informa a la vista 
     * en caso que se haya producido un error
     */
    public function addBand() {
        $name = $_POST["name"];
        $genre = $_POST["genre"];
        $country = $_POST["country"];
        $year = $_POST["year"];

        // Se verifican los datos ingresados
        if (empty($name) || empty($genre) || empty($country) || empty($year)) {
            $error = "Faltan completar campos.";
            $this->view->showError($error);
            return;
        }

        // Se verifica si la banda ingresada ya existe
        $exists = $this->model->checkBandExists($name);
        if ($exists) {
            $error = "La banda ya existe.";
            $this->view->showError($error);
            return;
        }

        // Se inserta en la banda DB
        $id = $this->model->insertBand($name, $genre, $country, $year);
        
        // Se verifica si se insertó correctamente
        if ($id != 0) {
            header('Location: ' . BASE_URL . '/bands');
        } else {
            $error = "Error al insertar la banda en la base de datos.";
            $this->view->showError($error);
            return;
        }
    }

    /**
     * Elimina la banda con el ID dado
     */
    public function deleteBand($id) {
        // Se elimina la banda de la DB a través del modelo
        $deleted = $this->model->deleteBand($id);

        // Se verifica si se eliminó correctamente de la DB
        if ($deleted) {
            // Si se eliminó, se actualiza la vista
            $bands = $this->model->getBands();
            $this->view->showBands($bands);
        } else {
            // Sino, se muestra un error
            $error = "No se pudo eliminar la banda de la base de datos";
            $this->view->showError($error);
        }
    }

    /**
     * Modifica la banda con el ID dado
     */
    public function editBand($id) {
        // Si no hay elementos en $_POST se muestra el formulario de edición
        if (empty($_POST)) {
            $band = $this->model->getBandById($id);
            $this->view->showBandEditForm($band);
            return;
        }

        $name = $_POST["name"];
        $genre = $_POST["genre"];
        $country = $_POST["country"];
        $year = $_POST["year"];

        if (empty($name) || empty($genre) || empty($country) || empty($year)) {
            $error = "Faltan completar campos.";
            $this->view->showError($error);
            return;
        }

        // Se verifica si existe otra banda con el mismo nombre
        $band = $this->model->getBandById($id);
        $exists = $this->model->checkBandExists($name, $band->name);

        // Si existe, se muestra un error
        if ($exists) {
            $error = "La banda ya existe.";
            $this->view->showError($error);
            return;
        }

        // Si no existe, se modifica la banda
        $this->model->editBand($id, $name, $genre, $country, $year);

        // Y se actualiza la vista
        $bands = $this->model->getBands();
        $this->view->showBands($bands);
    }
}
