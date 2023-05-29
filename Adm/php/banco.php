<?php
ini_set('display_errors', true);
error_reporting(E_ALL);
class Banco extends PDO{

    static protected $_instance;

    public function __construct($host,$database,$username,$password){
        return parent::__construct($host,$database,$username,$password);
    }


    static public function getInstancePostgresql($host,$database,$username,$password){
        if(!isset(self::$_instance)){
            self::$_instance = new PDO("pgsql:dbname=".$database.";host=".$host.";port=5432;user=".$username.";password=".$password);
        }
        return self::$_instance;
    }

    static public function conectar_postgres(){
        $username = "postgres";
        $password = "Abc25149076";
        $host     = "34.95.183.208"; // google cloud
        //$host     = "74.63.238.118"; // iphosting
        $database = "makecard";
        if(!isset(self::$_instance)){
            self::$_instance = new PDO("pgsql:dbname=".$database.";host=".$host.";port=5432;user=".$username.";password=".$password);        }
        return self::$_instance;
    }
}