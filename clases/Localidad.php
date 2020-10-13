<?php

class Localidad {

    private $id;
    private $nombre;
    private $codigoPostal;
    
    // Referencia a la clase Provincia, muchas localidades hay dentro de una Provincia * a 1
    private $provincia;

    public function __construct() {
        // Relación de composición
        $this->provincia = new Provincia();
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getCodigoPostal() {
        return $this->codigoPostal;
    }

    public function getProvincia() {
        return $this->provincia;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    public function setCodigoPostal($codigoPostal): void {
        $this->codigoPostal = $codigoPostal;
    }

    /*public function setProvincia(Provincia $provincia): void {
        $this->provincia = $provincia;
    }*/
}