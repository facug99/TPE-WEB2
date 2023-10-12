<?php

class BandView {
    /**
     * Muestra la lista de bandas recibida por parámetro
     */
    public function showBands($bands) {
        require_once 'templates/band_table.phtml';
    }

    /**
     * Muestra el error recibido por parámetro
     */
    public function showError($error, $details) {
        require_once 'templates/error.phtml';
    }
}
