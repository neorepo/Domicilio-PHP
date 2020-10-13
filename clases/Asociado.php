<?php

class Asociado extends Persona {

    // Condición de ingreso
    const CONDICION_ACTIVO = "ACTIVO";
    const CONDICION_ADHERENTE = "ADHERENTE";
    const CONDICION_JUBILADO = "JUBILADO";

    private $tipoDocumento;
    private $numDocumento;
    private $numCuil;
    private $condicionIngreso;

    /*public function __construct(Domicilio $estaDomiciliadoEn) {
        parent::__construct($estaDomiciliadoEn);
        $this->setCondicionIngreso(self::CONDICION_ACTIVO);
    }*/
    public function __construct() {
        parent::__construct();
        $this->setCondicionIngreso(self::CONDICION_ACTIVO);
    }

    // Getter
    public function getTipoDocumento() {
        return $this->tipoDocumento;
    }

    public function getNumDocumento() {
        return $this->numDocumento;
    }

    public function getNumCuil() {
        return $this->numCuil;
    }

    public function getCondicionIngreso() {
        return $this->condicionIngreso;
    }

    // Setter
    public function setTipoDocumento($tipoDocumento): void {
        $this->tipoDocumento = $tipoDocumento;
    }

    public function setNumDocumento($numDocumento): void {
        $this->numDocumento = $numDocumento;
    }

    public function setNumCuil($numCuil): void {
        $this->numCuil = $numCuil;
    }

    public function setCondicionIngreso($condicionIngreso): void {
        $this->condicionIngreso = $condicionIngreso;
    }
}
