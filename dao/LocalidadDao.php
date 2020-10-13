<?php

class LocalidadDao extends Dao {

    public function findById($id) {
        $sql = 'SELECT * FROM localidad WHERE id_localidad = ?';
        $row = $this->query($sql, (int) $id)[0];
        if (!$row) {
            return null;
        }
        $localidad = new Localidad();
        $this->map($localidad, $row);
        return $localidad;
    }

    public function findByIdProvincia(int $id) {
        $sql = 'SELECT * FROM localidad WHERE id_provincia = ? ORDER BY nombre;';
        $result = [];
        foreach ($this->query($sql, (int) $id) as $row) {
            $localidad = new Localidad();
            $this->map($localidad, $row);
            $result[$localidad->getId()] = $localidad;
        }
        return $result;
    }

    /**
     * ¿Debería crear una clase para está tarea?
     */
    private function map(Localidad $localidad, array $row) {

        if (array_key_exists('id_localidad', $row)) {
            $localidad->setId($row['id_localidad']);
        }
        if (array_key_exists('nombre', $row)) {
            $localidad->setNombre(trim($row['nombre']));
        }
        if (array_key_exists('codigo_postal', $row)) {
            $localidad->setCodigoPostal(trim($row['codigo_postal']));
        }
        if (array_key_exists('id_provincia', $row)) {
            $localidad->getProvincia()->setId($row['id_provincia']);
        }
    }

    public function insert($localidad) {
        
    }

    public function update($localidad) {
        
    }

    public function delete($id) {
        
    }
}