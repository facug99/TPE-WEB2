<?php

class AlbumModel {
    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=web2_tpe;charset=utf8', 'root', '');
    }

    /**
     * Obtiene los albumes de la tabla 'albums'
     */
    public function getAlbums() {
        // Se prepara y ejecuta la consulta
        $sql = 'SELECT * FROM albums';
        $query = $this->db->prepare($sql);
        $query->execute();

        // Se obtienen y devuelven los resultados
        $albums = $query->fetchAll(PDO::FETCH_OBJ);
        return $albums;
    }

    /**
     * Obtiene el album con el ID dado
     */
    public function getAlbumById($id) {
        // Se prepara y ejecuta la consulta
        $sql = 'SELECT * FROM albums WHERE id = ?';
        $query = $this->db->prepare($sql);
        $query->execute([$id]);

        // Se obtiene y devuelve el resultado
        $album = $query->fetch(PDO::FETCH_OBJ);
        return $album;
    }
    
    public function insertAlbum($title, $year, $band_id) {
        $sql = 'INSERT INTO albums (title,year,band_id) VALUES (?, ?, ?)';
        $query = $this->db->prepare($sql);
        $query->execute([$title,$year,$band_id]);
        return $this->db->lastInsertId();    
    }

    public function deleteAlbum($id) {
        $sql = 'DELETE FROM albums WHERE id = ?';
        $query = $this->db->prepare($sql);
        $query->execute([$id]);

        
        return $query->rowCount() > 0;
    }

    
    public function editAlbum($id, $title, $year, $band_id) {
        $sql = 'UPDATE albums 
                SET title = ?, year = ?, band_id = ? 
                WHERE id = ?';
        $query = $this->db->prepare($sql);
        $query->execute([$title, $year, $band_id, $id]);

        
        $count = $query->rowCount();
        return $count > 0;
    }
}