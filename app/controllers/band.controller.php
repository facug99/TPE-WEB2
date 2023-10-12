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
     *  Muestra la banda dada
     */
    public function showBandById($idBand) {

    }

    /**
     * Crea una banda en la DB e informa a la vista 
     * en caso que se haya producido un error
     */
    public function addBand($data) {
        $name = $data["name"];
        $genre = $data["genre"];
        $country = $data["country"];
        $year = $data["year"];

        // Se verifican los datos ingresados
        if (empty($name) || empty($genre) || empty($country) || empty($year)) {
            $error = "Error al insertar la banda.";
            $details = "Faltan completar campos.";
            $this->view->showError($error, $details);
            return;
        }

        $id = $this->model->insertBand($name, $genre, $country, $year);

        // Se verifica si se insertó correctamente la banda en la DB
        if ($id != 0) {
            header('Location: ' . BASE_URL . '/bands');
        } else {
            $error = "Error al insertar la banda.";
            $details = "No pudo crearse la banda en la base de datos.";
            $this->view->showError($error, $details);
            return;
        }
    }
}
