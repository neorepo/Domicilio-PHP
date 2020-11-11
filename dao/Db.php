<?php

/**
 * Pseudo - Singleton
 */
final class Db {

    private $connection;
    private static $instance = null;

    private function __construct() {
        $config = Config::getConfig('sqlitedb');
        // SQLite: dsn => 'sqlite:../db/yourdatabase.sqlite/.db', username => '', password => ''
        // MySQL: dsn => 'mysql:host=localhost:dbname=yourdatabase;charset=utf8mb4', username => 'root', password => ''
        try {
            $this->connection = new PDO($config['dsn'], $config['username'], $config['password'],[
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
        } catch (PDOException $e) {
            trigger_error('Could not connect to database: ' . $e->getMessage(), E_USER_ERROR);
            exit;
        }
    }

    /**
     * El método getDb no puede ser static porque no será llamado desde fuera de la clase Db.
     * todo sera gestionado por el método estático getInstance() el cual será llamado desde fuera.
     */
    private function getConnection() {
        return $this->connection;
    }

    /**
     * Crea un instancia de la clase Db y
     * Retorna una instancia de la clase PDO
     */
    public static function getInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance->getConnection();
    }

    // Magic method clone is empty to prevent duplication of connection
    private function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    // https://www.php.net/manual/es/language.oop5.magic.php
    public function __wakeup() {
        trigger_error('Deserializing is not allowed.', E_USER_ERROR);
    }

    public function __destruct() {
        $this->connection = null;
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