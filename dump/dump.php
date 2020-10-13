<?php

$provincia = 'tucuman';
$id_provincia = 24;

$url = 'https://neorepo.github.io/localidades-argentinas/' . $provincia . '.json';
//Es necesario tener habilitada la directiva allow_url_fopen para usar file_get_contents
if ( ini_get('allow_url_fopen') ) {
    $json = file_get_contents($url);
} else {
    //De otra forma utilizamos cURL
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($curl);
    curl_close($curl);
}

try {

    //$conn = new PDO('sqlite:../db/db.sqlite', '', '');
    echo '<p>Conexión a base de datos creada.</p>';
    
    // begin the transaction
    $conn->beginTransaction();

    foreach (json_decode($json, true) as $key => $value) {
        $id = $value['id'];
        $nombre = $value['nombre'];
        $cp = $value['cp'];

        $conn->exec("INSERT INTO localidad (id_localidad, nombre, codigo_postal, id_provincia) 
        VALUES ('$id', '$nombre', '$cp', '$id_provincia');");
    }

    // commit the transaction
    $conn->commit();
    echo "Insertando localidades de: " . $provincia . " foreign key provincia: " . $id_provincia . "<br>";

} catch (PDOException $e) {
    // roll back the transaction if something failed
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

$conn = null;