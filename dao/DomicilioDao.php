<?php

class DomicilioDao extends Dao {

    public function insert($domicilio) {
        $now = new DateTime();
        $domicilio->setId(null);
        $domicilio->setCreated($now);
        $domicilio->setLastModified($now);
        
        $sql = 'INSERT INTO domicilio (id_domicilio, calle, numero, piso, departamento, barrio, id_localidad, created, last_modified, deleted)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        $result = $this->query($sql, $domicilio->getId(), $domicilio->getCalle(), $domicilio->getNumero(), $domicilio->getPiso(), $domicilio->getDepartamento(), $domicilio->getBarrio(),
        $domicilio->getLocalidad()->getId(), $domicilio->getCreated()->format('Y-m-d H:i:s'), $domicilio->getLastModified()->format('Y-m-d H:i:s'), Utils::formatBoolean($domicilio->getDeleted()));
                        
        if($result) {
            if (!$domicilio->getId()) {
                return $this->findById($this->getDb()->lastInsertId());
            } else {
                throw new Exception('El domicilio con ID "' . $domicilio->getId() . '" no existe.');
            }
            return $domicilio;
        }
    }

    public function findById($id) {
        $sql = 'SELECT * FROM domicilio WHERE id_domicilio = ?';
        $row = $this->query($sql, (int) $id)[0];
        if (!$row) {
            return null;
        }
        $domicilio = new Domicilio();
        $this->map($domicilio, $row);
        return $domicilio;
    }

    public function update($domicilio) {

    }

    public function delete($id) {

    }

    public function map(Domicilio $domicilio, $properties) {
        if( array_key_exists('id_domicilio', $properties) ) {
            $domicilio->setId( $properties['id_domicilio'] );
        }
        if( array_key_exists('calle', $properties) ) {
            $domicilio->setCalle( $properties['calle'] );
        }
        if( array_key_exists('numero', $properties) ) {
            $domicilio->setNumero( $properties['numero'] );
        }
        if( array_key_exists('piso', $properties) ) {
            $domicilio->setPiso( $properties['piso'] );
        }
        if( array_key_exists('departamento', $properties) ) {
            $domicilio->setDepartamento( $properties['departamento'] );
        }
        if( array_key_exists('barrio', $properties) ) {
            $domicilio->setBarrio( trim( $properties['barrio'] ) );
        }
        if( array_key_exists('id_localidad', $properties) ) {
            $domicilio->getLocalidad()->setId( $properties['id_localidad'] );
        }
        if( array_key_exists('id_provincia', $properties) ) {
            $domicilio->getLocalidad()->getProvincia()->setId( $properties['id_provincia'] );
        }
        // Solo se cumplirá esta condición cuando los datos provengan de la base de datos
        if( array_key_exists('created', $properties) ) {
            $created = Utils::createDateTime($properties['created']);
            if ($created) {
                $domicilio->setCreated( $created );
            }
        }
        // Solo se cumplirá esta condición cuando los datos provengan de la base de datos
        if( array_key_exists('last_modified', $properties) ) {
            $last_modified = Utils::createDateTime($properties['last_modified']);
            if($last_modified)
                $domicilio->setLastModified( $last_modified );
        }
        // Solo se cumplirá esta condición cuando los datos provengan de la base de datos
        if( array_key_exists('deleted', $properties) ) {
            $domicilio->setDeleted( $properties['deleted'] );
        }
    }
}