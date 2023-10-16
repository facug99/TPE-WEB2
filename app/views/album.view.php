<?php

class AlbumView {
    /**
     * Muestra la lista de álbumes recibida por parámetro
     */
    public function showAlbums($albums, $bands) {
        require_once 'templates/albums.phtml';
    }
    
    /**
     * Muestra los detalles del álbum dado
     */
    public function showAlbum($album, $band) {
        require_once 'templates/album_info.phtml';
    }

    /**
     * Muestra el formulario de modificación
     */
    public function showAlbumEditForm($album, $bands){
        require_once 'templates/album_form_edit.phtml';
    }

    /**
     * Muestra el error recibido por parámetro
     */
    public function showError($error) {
        require_once 'templates/error.phtml';
    }
}