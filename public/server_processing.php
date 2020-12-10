<?php
// https://neorepo.github.io/localidades-argentinas/
// https://github.com/neorepo/localidades-argentinas

require_once '../config/Config.php';
require_once '../dao/Db.php';

$cod_3166_2 = null;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(array_key_exists('provincia', $_POST)) {
        $cod_3166_2 = 'AR-' . $_POST['provincia'];
    }
    if($cod_3166_2) {
        $provincia = getProvinciaPorCod($cod_3166_2)[0];
        $rows = getLocalidadesPorIdProvincia($provincia['id_provincia']);
        echo json_encode($rows);
        exit;
    }
} else {
    header('Location: index.php');
    exit;
}

function getLocalidadesPorIdProvincia($id_provincia) {
    return Db::query('SELECT * FROM localidad WHERE id_provincia = ? ORDER BY nombre;', $id_provincia);
}

function getProvinciaPorCod($cod_3166_2) {
    return Db::query('SELECT id_provincia FROM provincia WHERE codigo_3166_2 = ?;', $cod_3166_2);
}