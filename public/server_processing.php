<?php
// https://neorepo.github.io/localidades-argentinas/
// https://github.com/neorepo/localidades-argentinas

require_once '../config/Config.php';
require_once '../dao/Db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $codigo3166_2 = null;
    $response = ['success' => false, 'localidades' => null];
    $provincia = null;

    if(array_key_exists('provincia', $_POST)) {
        $codigo3166_2 = 'AR-' . $_POST['provincia'];
    }
    if($codigo3166_2) {
        $provincia = getProvinciaPorCodigo($codigo3166_2)[0];
    }
    if ($provincia) {
        $response['localidades'] = getLocalidadesPorIdProvincia( (int) $provincia['id_provincia'] );
    }
    if ($response['localidades']) {
        $response['success'] = true;
    }

    echo json_encode($response);
    exit;
}

header('Location: index.php');
exit;

function getLocalidadesPorIdProvincia($id_provincia) {
    return Db::query('SELECT * FROM localidad WHERE id_provincia = ? ORDER BY nombre;', $id_provincia);
}

function getProvinciaPorCodigo($codigo3166_2) {
    return Db::query('SELECT id_provincia FROM provincia WHERE codigo_3166_2 = ? LIMIT 1;', $codigo3166_2);
}