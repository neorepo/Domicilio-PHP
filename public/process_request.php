<?php

require_once '../config/Config.php';
require_once '../dao/Db.php';

$id_provincia = null;

if(array_key_exists('provincia', $_POST)) {
    $id_provincia = $_POST['provincia'];
}

if($id_provincia !== null) {

    $rows = getLocalitiesByIdProvince($id_provincia);

    echo json_encode($rows);

} else {

    $rows = getAllContries();

    echo json_encode($rows);
}

function getLocalitiesByIdProvince($id) {
    return Db::query('SELECT * FROM localidad WHERE id_provincia = ? ORDER BY nombre;', $id);
}