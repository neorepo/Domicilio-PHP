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

require_once '../clases/Persona.php';
require_once '../clases/Asociado.php';

require_once '../dao/ProvinciaDao.php';
require_once '../dao/LocalidadDao.php';
require_once '../dao/DomicilioDao.php';

$domicilio = null;

$now = new DateTime();
$asociado = new Asociado();
$asociado->setFechaNacimiento($now);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo 'Datos contenidos en el array $_POST';
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';

    $data = [
        'apellido' => $_POST['asociado']['apellido'],
        'nombre' => $_POST['asociado']['nombre'],
        'tipo_documento' => $_POST['asociado']['tipo_documento'],
        'num_documento' => $_POST['asociado']['num_documento'],
        'fecha_nacimiento' => $_POST['asociado']['fecha_nacimiento'],
        'dateOfBirth' => $_POST['asociado']['birthday_year'] . '-' . $_POST['asociado']['birthday_month'] . '-' . $_POST['asociado']['birthday_day'],
        'num_cuil' => $_POST['asociado']['num_cuil'],
        'condicion_ingreso' => $_POST['asociado']['condicion_ingreso'],
        'email' => $_POST['asociado']['email'],
        'telefono_movil' => $_POST['asociado']['telefono_movil'],
        'telefono_linea' => $_POST['asociado']['telefono_linea'],
        'sexo' => $_POST['asociado']['sexo'] ?? null,
        // Datos del docmicilio
        'calle' => $_POST['domicilio']['calle'],
        'numero' => $_POST['domicilio']['numero'],
        'piso' => $_POST['domicilio']['piso'],
        'departamento' => $_POST['domicilio']['departamento'],
        'barrio' => $_POST['domicilio']['barrio'],
        'manzana' => $_POST['domicilio']['manzana'],
        'casa_lote' => $_POST['domicilio']['casa_lote'],
        'provincia' => $_POST['domicilio']['provincia'],
        'localidad' => $_POST['domicilio']['localidad'],
    ];

    echo 'Datos contenidos en el array $data.';
    echo '<pre>';
    print_r($data);
    echo '</pre>';

    // Asignamos el valor proveniente del formulario
    if (array_key_exists('dateOfBirth', $data)) {
        /**
         * Si la fecha no es válida, por ejm: '2011-2-29' DateTime setea la fecha a: 2011-03-01.
         * DateTime entiende que '2011-2-29' es en realidad '2011-3-1' el primer día del siguiente mes.
         */
        if ( !Utils::validateDate($data['dateOfBirth']) ) {
            $errors['fecha_nacimiento'] = 'La fecha de nacimiento no es válida.';
        } else {
            $dateOfBirth = DateTime::createFromFormat('Y-n-j', $data['dateOfBirth'] );
            if ($dateOfBirth) {
                $asociado->setFechaNacimiento($dateOfBirth);
            }
        }
    }

    echo 'La fecha seteada del objeto es: ' . $asociado->getFechaNacimiento()->format('Y-n-j');

    // Validamos que la fecha sea válida.
    // if ( !Utils::validateDate($asociado->getFechaNacimiento()) ) {
    //     $errors['fecha_nacimiento'] = 'La fecha de nacimiento no es válida.';
    // }

    $domicilio = new Domicilio();
    // Dao
    $domicilioDao = new DomicilioDao();
    $domicilioDao->map($domicilio, $data);
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


$template = '../templates/asociado/registro.html';

require_once '../templates/base.html';

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

        if ($day >= 1 && $day <= 31) $valid_day = true;
        if ($month >= 1 && $month <= 12) $valid_month = true;
        if ($year >= 1905 && $year <= date('Y')) $valid_year = true;

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
    // divisible by 4
    $isLeapYear = ($year % 4 == 0);
    // divisible by 4 and not 100
    $isLeapYear = $isLeapYear && ($year % 100 != 0);
    // divisible by 4 and not 100 unless divisible by 400
    return $isLeapYear || ($year % 400 == 0);
}