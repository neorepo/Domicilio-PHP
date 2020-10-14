<?php
// neodrive.edu@gmail.com
date_default_timezone_set('AMERICA/ARGENTINA/BUENOS_AIRES');

require_once '../util/Utils.php';

require_once '../config/Config.php';
require_once '../dao/Dao.php';
require_once '../dao/Db.php';

require_once '../clases/Provincia.php';
require_once '../clases/Localidad.php';
require_once '../clases/Domicilio.php';

require_once '../dao/ProvinciaDao.php';
require_once '../dao/LocalidadDao.php';
require_once '../dao/DomicilioDao.php';

$domicilio = null;

$errors = [];

$birthday_day = date('j');
$birthday_month = date('n');
$birthday_year = date('Y');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // echo '<pre>';
    // print_r($_POST);
    // echo '</pre>';
    
    $birthday_day = $_POST['birthday_day'];
    $birthday_month = $_POST['birthday_month'];
    $birthday_year = $_POST['birthday_year'];

    if( validarFecha($birthday_day, $birthday_month, $birthday_year) ) {
        $birth_date = $birthday_year . '-' . $birthday_month . '-' . $birthday_day;
        echo 'Fecha de nacimiento: ' . $birth_date . '<br>';
        echo 'Fecha actual: ' . date('Y-n-j') . '<br>';
        echo 'Edad: ' . Utils::calculateAge($birth_date) . '<br>';
    } else {
        $errors['fecha_nacimiento'] = 'La fecha seleccionada no es válida.';
    }
    
    $properties = $_POST;

    $domicilio = new Domicilio();
    // Dao
    $domicilioDao = new DomicilioDao();
    $domicilioDao->map($domicilio, $properties);
    // Le pasamos el objeto domicilio creado anteriormente, y esperamos la misma referencia de objeto
    // $domicilio = $domicilioDao->insert($domicilio);

    // if($domicilio) {
    //     echo 'El domicilio se insertó correctamente.';
    //     echo '<pre>';
    //     print_r($domicilio);
    //     echo '</pre>';
    // } else {
    //     echo 'No pudimos insertar el domicilio';
    // }
    // var_dump($domicilio);
}

// $countries = getAllContries();

// var_dump($countries);

$template = '../templates/asociado/registro.html';

require_once '../templates/index.html';

function getAllContries() {
    return Db::query('SELECT * FROM pais;');
}

function validate_date($day, $month, $year) {
    if( !($year >= 1905 && $year <= date('Y') ) ){
        return false;
    }
    $date = $day . '/' . $month . '/' . $year;
    $matches = [];
    $pattern = '/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/';
    if (!preg_match($pattern, $date, $matches)) return false;
    if (!checkdate($matches[2], $matches[1], $matches[3])) return false;
    return true;
}

function validarFecha($day, $month, $year) {
    if (
        preg_match('/^[0-9]{1,2}$/', $day) &&
        preg_match('/^[0-9]{1,2}$/', $month) &&
        preg_match('/^[0-9]{4}$/', $year)
    ) {
        $valid_day = $valid_month = $valid_year = false;
        if ($day >= 1 && $day <= 31) {
            $valid_day = true;
        }
        if ($month >= 1 && $month <= 12) {
            $valid_month = true;
        }
        if ($year >= 1905 && $year <= date('Y')) {
            $valid_year = true;
        }
        if ($valid_day && $valid_month && $valid_year) {
            if ($day == 29 && $month == 2) {
                return isLeapYear($year);
            }
            return true;
        }
    }
    return false;
}

function isLeapYear($year) {
    $isLeapYear = false;
    // divisible by 4
    $isLeapYear = ($year % 4 == 0);
    // divisible by 4 and not 100
    $isLeapYear = $isLeapYear && ($year % 100 != 0);
    // divisible by 4 and not 100 unless divisible by 400
    return $isLeapYear || ($year % 400 == 0);
}