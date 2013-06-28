<?php

class SPDO {

    // Instance de la classe PDO
    private $PDOInstance = null;
    // Instance de la classe SPDO
    private static $instance = null;

    /**
     * Constante: nom d'utilisateur de la bdd
     *
     * @var string
     */
    static $user = 'root';
    static $host = 'localhost';
    static $pass = '';
    static $bdname = 'db';
    static $sgbd = 'mysql';

    /**
     * Constructeur
     */
    private function __construct() {
        $this->PDOInstance = new PDO(self::$sgbd . ':dbname=' . self::$bdname . ';host=' . self::$host, self::$user, self::$pass);
    }

    /**
     * Cr�e et retourne l'objet SPDO
     */
    public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new SPDO();
        }
        return self::$instance;
    }

    static function config($config) {
        self::$user = $config['user'];
        self::$host = $config['host'];
        self::$pass = $config['pass'];
        self::$bdname = $config['dbname'];
        self::$sgbd = $config['sgbd'];
        self::$instance = new SPDO();
    }

    private function __clone() {
        
    }

    /**
     * Ex�cute une requ�te SQL avec PDO
     *
     * @param string $query La requ�te SQL
     * @return PDOStatement Retourne l'objet PDOStatement
     */
    public function query($query) {
        return $this->PDOInstance->query($query);
    }

    public function beginTransaction() {
        return $this->PDOInstance->beginTransaction();
    }

    public function commit() {
        return $this->PDOInstance->commit();
    }

}
