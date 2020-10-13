<?php

class Domicilio {

    private $id;
    private $calle;
    private $numero;
    private $piso;
    private $departamento;

    private $barrio;

    // Estos atributos esperan un objeto de tipo DateTime
    private $created;
    private $lastModified;

    private $deleted;

    // Referencia a la clase Localidad, muchos domicilios se encuentran en una localidad * a 1
    private $localidad;

    public function __construct(){
        // Relación de composición
        $this->localidad = new Localidad();
        $now = new DateTime();
        $this->setCreated($now);
        $this->setLastModified($now);
        $this->setDeleted(false);
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id):void {
        $this->id = $id;
    }

    public function getCalle() {
        return $this->calle;
    }

    public function setCalle($calle):void {
        $this->calle = $calle;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function setNumero($numero):void {
        $this->numero = $numero;
    }

    public function getPiso() {
        return $this->piso;
    }

    public function setPiso($piso): void {
        $this->piso = $piso;
    }

    public function getDepartamento() {
        return $this->departamento;
    }

    public function setDepartamento($departamento): void {
        $this->departamento = $departamento;
    }

    public function getBarrio() {
        return $this->barrio;
    }

    public function setBarrio($barrio): void {
        $this->barrio = $barrio;
    }

    public function getCreated() {
        return $this->created;
    }

    public function setCreated(DateTime $created): void {
        $this->created = $created;
    }

    public function getLastModified() {
        return $this->lastModified;
    }

    public function setLastModified(DateTime $lastModified): void {
        $this->lastModified = $lastModified;
    }

    public function getDeleted() {
        return $this->deleted;
    }

    public function setDeleted($deleted): void {
        $this->deleted = (bool) $deleted;
    }
    
    public function getLocalidad() {
        return $this->localidad;
    }

    /*public function setLocalidad(Localidad $localidad): void {
        $this->localidad = $localidad;
    }*/
}