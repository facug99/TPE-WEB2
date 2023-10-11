<?php

class BandView {
    public function showBands($bands) {
        require_once 'templates/band_table.phtml';
    }

    public function showBandAlbums() {
        require_once 'templates/band_albums.phtml';
    }
}
