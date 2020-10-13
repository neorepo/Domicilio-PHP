<?php
/**
 * Para el domicilio de la persona lo haremos utilizando la relación
 * de asociación (agregación) y podemos utilizar tanto el constructor
 * como el método setResideEn que asigna el objeto domicilio a la
 * variable privada $resideEn
 * sexo, alimento, descanso
 */
abstract class Persona {

    private $id;
    // Atributos de una persona física
    private $apellido;
    private $nombre;
    private $sexo;
    // Estos atributos por ahora no los tendremos en cuenta
    private $estadoCivil; // Personas fisicas: casado, soltero, divorciado, viudo, ser padre, hijo, esposo
    private $nacionalidad; //Argentina, Chilena, Peruana
    
    // Estos atributos esperan un objeto de tipo DateTime
    private $fechaNacimiento;
    private $created;
    private $lastModified;

    // Convertir a boolean
    private $deleted;

    /**
     * http://servicios.infoleg.gob.ar/infolegInternet/anexos/105000-109999/109481/texactley340_libroI_S1_tituloVI.htm
     * 
     * Referencia a la clase Domicilio
     * Muchas personas residen en un mismo domicilio, relación de agregación * a 1
     */
    private $resideEn;

    /*public function __construct(Domicilio $resideEn) {
        $now = new DateTime();
        $this->resideEn = $resideEn;
        $this->setCreated($now);
        $this->setLastModified($now);
        $this->setDeleted(false);
    }*/
    public function __construct() {
        $now = new DateTime();
        $this->setCreated($now);
        $this->setLastModified($now);
        $this->setDeleted(false);
    }

    // Getter
    public function getId() {
        return $this->id;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getSexo() {
        return $this->sexo;
    }

    public function getFechaNacimiento() {
        return $this->fechaNacimiento;
    }

    public function getCreated() {
        return $this->created;
    }

    public function getLastModified() {
        return $this->lastModified;
    }

    public function getDeleted() {
        return $this->deleted;
    }

    public function getResideEn() {
        return $this->resideEn;
    }

    // Setter
    public function setId($id): void {
        $this->id = $id;
    }

    public function setApellido($apellido): void {
        $this->apellido = $apellido;
    }

    public function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    public function setSexo($sexo): void {
        $this->sexo = $sexo;
    }

    public function setFechaNacimiento(DateTime $fechaNacimiento): void {
        $this->fechaNacimiento = $fechaNacimiento;
    }

    public function setCreated(DateTime $created): void {
        $this->created = $created;
    }

    public function setLastModified(DateTime $lastModified): void {
        $this->lastModified = $lastModified;
    }

    public function setDeleted($deleted): void {
        $this->deleted = (bool) $deleted;
    }

    public function setResideEn(Domicilio $resideEn): void {
        $this->resideEn = $resideEn;
    }
}