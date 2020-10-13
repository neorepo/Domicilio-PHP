<?php

/**
 * Description of Dao
 * Si la clase se define como final, entonces no se podrá heredar de ella.
 */
abstract class Dao {

    private $db = null;

    public function __destruct() {
        $this->db = null;
    }

    /**
     * Método de Conexión a base de datos, retorna un objeto de la clase PDO
     */
    protected final function getDb() {
        if ($this->db !== null) {
            return $this->db;
        }
        $config = Config::getConfig('sqlitedb');
        try {
            $this->db = new PDO($config['dsn'], $config['username'], $config['password'], [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
        } catch (PDOException $ex) {
            echo 'Error: ' . $ex->getMessage();
            exit;
            // throw new Exception('DB connection error: ' . $ex->getMessage());
        }
        return $this->db;
    }

    protected abstract function insert(object $data);

    protected abstract function findById($id);

    protected abstract function update(object $data);

    protected abstract function delete($id);

    /**
     * Executes SQL statement, possibly with parameters, returning
     * an array of all rows in result set or false on (non-fatal) error.
     */
    protected final function query(/* $sql [, ... ] */) {
        // SQL statement
        $sql = func_get_arg(0);

        // parameters, if any
        $parameters = array_slice(func_get_args(), 1);

        $stmt = $this->getDb()->prepare($sql);

        if ($stmt === false) {
            // trigger (big, orange) error
            trigger_error($this->getDb()->errorInfo()[2], E_USER_ERROR);
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