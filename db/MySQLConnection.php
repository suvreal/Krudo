<?php

namespace db;

/**
 * Provides database connection to MySQL database
 */
Class MySQLConnection{

    /**
     * @var $Instance
     */
    private static $Instance;

    /**
     * @var $DatabaseConnection
     */
    private $DatabaseConnection = null;


    /**
     * @var $ApplicationConfiguration
     */
    private $ApplicationConfiguration = null;
    

    public function __construct(){}

    /**
     * Clone secure for singleton object class
     */
    public function __clone() {
        throw new \Exception("Cannot be cloned");
    }

    /**
     * Singleton instance obtain
     * 
     * @return MySQLConnection
     */
    public static function getInstance(){
        if (self::$Instance == null){
            $className = __CLASS__;
            self::$Instance = new $className;
        }

        return self::$Instance;
    }

    /**
     * Performs database connection
     * 
     * @var DatabaseConnection setter
     * @return mysqli
     */
    public static function performDatabaseConnection(){
        $MySQLConnection = self::getInstance();
        $MySQLConnection->ApplicationConfiguration = MySQLDatabaseConfiguration::getDatabaseConfiguration();
        $MySQLConnection->DatabaseConnection = new \mysqli(
            $MySQLConnection->ApplicationConfiguration["Address"], 
            $MySQLConnection->ApplicationConfiguration["User"], 
            $MySQLConnection->ApplicationConfiguration["Pass"],
            $MySQLConnection->ApplicationConfiguration["DatabaseName"],
            $MySQLConnection->ApplicationConfiguration["Port"]
        );

        return $MySQLConnection;
    }

    /**
     * Provides database connection
     * 
     * @var DatabaseConnection getter
     * @return \mysqli
     */
    public static function getDatabaseConnection(){
        try{
            $MySQLConnection = self::getInstance();
            return $MySQLConnection->DatabaseConnection;
        }catch(\Exception $e){
            echo("Database connection problem:". $e->getMessage());           
        }
    }

}

?>