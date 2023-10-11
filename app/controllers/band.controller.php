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

    public function showBands() {
        // Se obtienen las bandas del modelo
        $bands = $this->model->getBands();

        // Se envían a la vista para que las muestre
        $this->view->showBands($bands);
    }
}
