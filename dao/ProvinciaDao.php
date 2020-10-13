<?php

class ProvinciaDao extends Dao {

    public function findById($id) {
        $sql = 'SELECT * FROM provincia WHERE id_provincia = ?';
        $row = $this->query($sql, (int) $id)[0];
        if (!$row) {
            return null;
        }
        $provincia = new Provincia();
        $this->map($provincia, $row);
        return $provincia;
    }

    public function getAll() {
        $result = [];
        // No es necesario ordenar por nombre ya que la tabla provincia esta ordenada por nombre ASC en la DB
        foreach ($this->query('SELECT * FROM provincia;') as $row) {
            $provincia = new Provincia();
            $this->map($provincia, $row);

            $result[$provincia->getId()] = $provincia;
        }
        return $result;
    }

    /**
     * ¿Debería crear una clase para está tarea?
     */
    private function map(Provincia $provincia, array $row) {

        if (array_key_exists('id_provincia', $row)) {
            $provincia->setId($row['id_provincia']);
        }
        if (array_key_exists('nombre', $row)) {
            $provincia->setNombre(trim($row['nombre']));
        }
        if (array_key_exists('codigo_3166_2', $row)) {
            $provincia->setCodigo_3166_2($row['codigo_3166_2']);
        }
    }

    public function insert($provincia) {
        
    }

    public function update($provincia) {
        
    }

    public function delete($id) {
        
    }
}