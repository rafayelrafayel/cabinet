<?php

/**
 * Description of Model_Pdo
 * Connect to Database
 * @author Rafayel Khachatryan
 */

namespace models;

class PDOWrapper extends \PDO {

    private static $_queries = array();

    public function prepare($statement, $driver_options = array()) {
        if (DB_SQL_DEBUG_MODE) {
            self::$_queries[] = $statement;
            //var_dump(debug_backtrace());
        }
        return parent::prepare($statement, $driver_options);
    }

    public static function dumpQueries() {
        if (DB_SQL_DEBUG_MODE) {
            $i = 0;
            foreach (self::$_queries as $q) {
                echo ($i++) . '. ' . $q, PHP_EOL, PHP_EOL;
            }
        }
    }

}

class Pdo {

    protected $_adapter = null;
    private static $_instance = null;

    public static function getInstance() {

        if (NULL === self::$_instance) {

            self::$_instance = new Pdo();
        }
        return self::$_instance;
    }

    private function __clone() {
        
    }

    private function __construct() {
        $this->pdo = $this->connect();
    }

    public function get() {
        return $this->pdo;
    }

    public function connect() {


        try {
            $dbh = new PDOWrapper('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD, array(
                //  PDO::ATTR_PERSISTENT => 0,
                \PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
               \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            ));
            return $dbh;
        } catch (\PDOException $e) {

            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public static function dumpQueries() {
        PDOWrapper::dumpQueries();
    }

}
