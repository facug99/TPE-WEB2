<?php

class AlbumView {
    /**
     * Muestra la lista de álbumes recibida por parámetro
     */
    public function showAlbums($albums) {
        require_once 'templates/album_table.phtml';
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
    public function showAlbumEditForm($album){
        require_once 'templates/album_form.phtml';
    }

    /**
     * Muestra el error recibido por parámetro
     */
    public function showError($error) {
        require_once 'templates/error.phtml';
    }
}