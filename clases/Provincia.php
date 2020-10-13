<?php

class Provincia {

    private $id;
    private $nombre;
    private $codigo_3166_2;

    // Muchas provincias estan dentro de un País, * a 1
    private $pais;

    public function __construct() {
        
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getCodigo_3166_2() {
        return $this->codigo_3166_2;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    public function setCodigo_3166_2($codigo_3166_2): void {
        $this->codigo_3166_2 = $codigo_3166_2;
    }
}