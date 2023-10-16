<?php

class AlbumModel {
    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS);
    }

    /**
     * Obtiene los álbumes de la tabla 'albums'
     */
    public function getAlbums() {
        $sql = 'SELECT * FROM albums';
        $query = $this->db->prepare($sql);
        $query->execute();

        $albums = $query->fetchAll(PDO::FETCH_OBJ);
        return $albums;
    }

    /**
     * Obtiene el álbum con el ID dado
     */
    public function getAlbumById($id) {
        $sql = 'SELECT * FROM albums WHERE id = ?';
        $query = $this->db->prepare($sql);
        $query->execute([$id]);
        $album = $query->fetch(PDO::FETCH_OBJ);
        return $album;
    }
    
    public function getBandOfAlbum($idBand){
        $sql = 'SELECT * FROM bands WHERE id = ?';
        $query = $this->db->prepare($sql);
        $query->execute([$idBand]);
        $band = $query->fetch(PDO::FETCH_OBJ);
        return $band;
    }

    /**
     * Inserta un álbum en la DB y, si no se produce ningún error, 
     * devuelve un número distinto de 0
     */
    public function insertAlbum($title, $year, $band_id) {
        $sql = 'INSERT INTO albums (title,year,band_id) VALUES (?, ?, ?)';
        $query = $this->db->prepare($sql);
        $query->execute([$title, $year, $band_id]);
        return $this->db->lastInsertId();
    }

    /**
     * Elimina un álbum dado su ID
     */
    public function deleteAlbum($id) {
        $sql = 'DELETE FROM albums WHERE id = ?';
        $query = $this->db->prepare($sql);
        $query->execute([$id]);
        return $query->rowCount() > 0;
    }

    /**
     * Modifica una banda dado su ID
     */
    public function editAlbum($id, $title, $year, $band_id) {
        $sql = 'UPDATE albums 
                SET title = ?, year = ?, band_id = ? 
                WHERE id = ?';
        $query = $this->db->prepare($sql);
        $query->execute([$title, $year, $band_id, $id]);
        $count = $query->rowCount();
        return $count > 0;
    }

    /**
     * Verifica si existe la banda dado su ID. Esto es útil para respetar las
     * restricciones de la clave foránea álbumes-bandas
     */
    public function checkBandExists($band_id) {
        // Consulta SQL para verificar si el band_id existe en la tabla de bandas
        $sql = "SELECT COUNT(*) FROM bands WHERE id = ?";
        $query = $this->db->prepare($sql);
        $query->execute([$band_id]);

        // Se obtiene el resultado de la consulta
        $count = $query->fetchColumn();

        // Si count es mayor que 0, significa que el band_id existe
        return $count > 0;
    }

    /**
     * Se obtienen las bandas de la base de datos para generar los formularios
     */
    public function getBands() {
        $sql = 'SELECT * FROM bands';
        $query = $this->db->prepare($sql);
        $query->execute();

        $bands = $query->fetchAll(PDO::FETCH_OBJ);
        return $bands;
    }
}
