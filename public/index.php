<?php

date_default_timezone_set('AMERICA/ARGENTINA/BUENOS_AIRES');

// $countries = getAllCoUntries();

// var_dump($countries);

/**
 * La siguiente URL
 * http://localhost/domiciliophp/public/index.php/associate/edit/3
 * Si consultamos la variable $_SERVER['PATH_INFO'], veremos lo siguiente
 * echo $_SERVER['PATH_INFO']; => /associate/edit/3
 */

$template = '../templates/pages/home.html';

require_once '../templates/base.html';