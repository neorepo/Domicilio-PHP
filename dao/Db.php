<?php

/**
 * Singleton
 */
class Db {

    private $db;
    private static $instance = null;

    public function __destruct() {
        $this->db = null;
    }

    private function __construct() {
        $config = Config::getConfig('sqlitedb');
        // SQLite: dsn => 'sqlite:../db/yourdatabase.sqlite/.db', username => '', password => ''
        // MySQL: dsn => 'mysql:host=localhost:dbname=yourdatabase;charset=utf8mb4', username => 'root', password => ''
        try {
            $this->db = new PDO($config['dsn'], $config['username'], $config['password']);
        } catch (PDOException $e) {
            trigger_error('Could not connect to database: ' . $e->getMessage(), E_USER_ERROR);
            exit;
        }
    }

    /**
     * Devuelve la instancia de la clase PDO
     */
    private function getDb() {
        return $this->db;
    }

    /**
     * Devuelve una instancia de la clase
     */
    public static function getInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance->getDb();
    }

    /**
     * 
     */
    public static function query(/* $sql [, ... ] */) {
        // SQL statement
        $sql = func_get_arg(0);

        // parameters, if any
        $parameters = array_slice(func_get_args(), 1);

        $stmt = self::getInstance()->prepare($sql);

        if ($stmt === false) {
            // trigger (big, orange) error
            trigger_error(self::getInstance()->errorInfo()[2], E_USER_ERROR);
            exit;
        }

        $result = $stmt->execute($parameters);

        if ($result === false) {
            return false;
        }

        // Determining the Type of a Statement http://www.kitebird.com/articles/php-pdo.html
        if ($stmt->columnCount() > 0) {
            // return result set's rows
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        // if query was DELETE, INSERT, or UPDATE
        else {
            // return number of rows affected
            return ($stmt->rowCount() == 1); // true o false
        }
    }
}