<?php

date_default_timezone_set('AMERICA/ARGENTINA/BUENOS_AIRES');



/**
 * La siguiente URL
 * http://localhost/domiciliophp/public/index.php/associate/edit/3
 * Si consultamos la variable $_SERVER['PATH_INFO'], veremos lo siguiente
 * echo $_SERVER['PATH_INFO']; => /associate/edit/3
 */

// $template = '../templates/pages/home.html';

// require_once '../templates/base.html';

require_once '../config/Config.php';
require_once '../dao/Db.php';
var_dump( Db::query("SELECT * FROM sqlite_sequence;") );
$countries = getAllCountries();
$template = '../templates/xmlhttprequest.html';
require_once '../templates/base.html';
function getAllCountries() {
    return Db::query('SELECT * FROM pais;');
}