<?php

class BandView {
    /**
     * Muestra la lista de bandas recibida por parámetro
     */
    public function showBands($bands) {
        require_once 'templates/bands.phtml';
    }

    /**
     * Muestra los detalles de la banda dada y sus álbumes
     */
    public function showBand($band, $albums) {
        require_once 'templates/band_info.phtml';
    }

    /**
     * Muestra el formulario de modificación
     */
    public function showBandEditForm($band) {
        require_once 'templates/band_form_edit.phtml';
    }

    /**
     * Muestra el error recibido por parámetro
     */
    public function showError($error) {
        require_once 'templates/error.phtml';
    }
}
