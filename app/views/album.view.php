<?php

class AlbumView {
    /**
     * Muestra la lista de bandas recibida por parámetro
     */
    public function showAlbums($albums) {
        require_once 'templates/album_table.phtml';
    }
    
    public function showAlbum($album) {
        require_once 'templates/album_info.phtml';
    }
    public function showAlbumEditForm($album){
        require_once 'templates/album_form.phtml';
    }

    public function showError($error) {
        require_once 'templates/error.phtml';
    }
}