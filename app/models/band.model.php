<?php

class BandModel {
    private $db;

    public function __construct() {
        // Se abre la conexión con la base de datos
        $this->db = new PDO('mysql:host=localhost;dbname=web2_tpe;charset=utf8', 'root', '');
    }

    /**
     * Obtiene las bandas de la tabla 'bands'
     */
    public function getBands() {
        // Se prepara y ejecuta la consulta
        $sql = 'SELECT * FROM bands';
        $query = $this->db->prepare($sql);
        $query->execute();

        // Se obtienen y devuelven los resultados
        $bands = $query->fetchAll(PDO::FETCH_OBJ);
        return $bands;
    }

    /**
     * Obtiene la banda con el ID dado
     */
    public function getBandById($id) {
        // Se prepara y ejecuta la consulta
        $sql = 'SELECT * FROM bands WHERE id = ?';
        $query = $this->db->prepare($sql);
        $query->execute([$id]);

        // Se obtiene y devuelve el resultado
        $band = $query->fetch(PDO::FETCH_OBJ);
        return $band;
    }

    /**
     * Obtiene los álbumes de una banda dada
     */
    public function getBandAlbums($idBand) {
        $sql = 'SELECT * FROM albums WHERE band_id = ?';
        $query = $this->db->prepare($sql);
        $query->execute([$idBand]);
        $band = $query->fetch(PDO::FETCH_OBJ);
        return $band;
    }

    /**
     * Inserta una banda en la DB y, si no se produce ningún error, 
     * devuelve un número distinto de 0 si no hubo error
     */
    public function insertBand($name, $genre, $country, $year) {
        $sql = 'INSERT INTO bands (name, genre, formed_country, formed_year) VALUES (?, ?, ?, ?)';
        $query = $this->db->prepare($sql);
        $query->execute([$name, $genre, $country, $year]);
        return $this->db->lastInsertId();    
    }

    /**
     * Elimina una banda dado su ID
     */
    public function deleteBand($id) {
        $sql = 'DELETE FROM bands WHERE id = ?';
        $query = $this->db->prepare($sql);
        $query->execute([$id]);

        // Si la consulta no produjo ningún cambio en la tabla se devuelve false
        return $query->rowCount() > 0;
    }

    /**
     * Modifica una banda dado su ID
     */
    public function modifyBand($id, $genre, $name, $country, $year) {
        
    }
}
