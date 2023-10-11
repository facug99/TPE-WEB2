<?php

class BandModel {
    private $db;

    public function __construct() {
        // Se abre la conexión con la base de datos
        $this->db = new PDO('mysql:host=localhost;dbname=web2_tpe;charset=utf8', 'root', '');
    }

    public function getBands() {
        // Se prepara y ejecuta la consulta
        $sql = 'SELECT * FROM bands';
        $query = $this->db->prepare($sql);
        $query->execute();

        // Se obtienen y devuelven los resultados
        $bands = $query->fetchAll(PDO::FETCH_OBJ);
        return $bands;
    }

    public function getBandById($id) {
        $sql = 'SELECT * FROM bands WHERE id = ?';
        $query = $this->db->prepare($sql);
        $query->execute([$id]);

        $band = $query->fetch(PDO::FETCH_OBJ);
        return $band;
    }

    public function getBandAlbums($idBand) {
        $sql = 'SELECT * FROM albums WHERE band_id = ?';
        $query = $this->db->prepare($sql);
        $query->execute([$idBand]);

        $band = $query->fetch(PDO::FETCH_OBJ);
        return $band;
    }
}
