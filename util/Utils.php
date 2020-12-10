<?php

class Utils {

    public static function positiveInt(string $s): bool {
        if ($s === null) {
            return false;
        }
        if (self::isInteger($s)) {
            if ((int) $s > 0) {
                return true;
            }
        }
        return false;
    }

    public static function isInteger(string $s): int {
        if ($s === null) {
            return 0;
        }
        return preg_match('/^[-+]?\d+$/', $s);
    }

    public static function escape(string $s): string {
        if ($s === null) {
            return "";
        }
        return htmlspecialchars(stripslashes(trim($s)));
    }

    /**
     * Y => Una representación numérica completa de un año, 4 dígitos - Ejemplos: 1999 o 2003
     * m y n => Representación numérica de un mes, con o sin ceros iniciales - 01 hasta 12 o 1 hasta 12
     * d y j => Día del mes, 2 dígitos con o sin ceros iniciales - 01 a 31 o 1 a 31
     */
    public static function createDateTime(string $input) {
        return DateTime::createFromFormat('Y-n-j H:i:s', $input);
    }
    public static function createDate(string $input) {
        return DateTime::createFromFormat('Y-n-j', $input);
    }
    public static function formatDate(DateTime $date = null) {
        if ($date === null) {
            return '';
        }
        return $date->format('d/m/Y');
    }
    public static function formatDateTime(DateTime $date = null) {
        if ($date === null) {
            return '';
        }
        return $date->format('d/m/Y H:i');
    }
    public static function formatDateOfBirth(string $date): string { // 03/09/2000
        $dc = explode('/', $date);
        return $dc[2] . "-" . $dc[1] . "-" . $dc[0]; // 2000-09-03 
    }

    public static function formatBoolean($bool) {
        return $bool ? 1 : 0;
    }

    /**
     * Calcula la edad de una persona a partir de su fecha de nacimiento
     * Recibe un string en el formato 03/03/2020 o 3/3/2000
     */
    public static function calculateAge($birth_date) {
        $current_date = date_create( date("Y-m-d") );
        $birth_date = date_create( str_replace('/', '-', $birth_date) );
        $diff = date_diff( $birth_date, $current_date );
        // La fecha de nacimiento debe ser anterior a la fecha actual.
        if($birth_date > $current_date) {
            return $diff->format('%y') * -1;
        }
        return $diff->format('%y');
    }

    /**
     * Recibe un objeto DateTime 
     */
    public static function validateDate($date) {
        // formato; año, mes, día => 2000-6-20
        $parts = explode('-', $date);
        if( !($parts[0] >= 1905 && $parts[0] <= date('Y') ) ){
            return false;
        }
        // checkdate ( int $month , int $day , int $year ) : bool
        // Returns TRUE if the date given is valid; otherwise returns FALSE.
        return checkdate($parts[1], $parts[2], $parts[0]); 
    }
}