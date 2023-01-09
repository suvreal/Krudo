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
     * @return \mysqli
     */
    public static function performDatabaseConnection(){
        $MySQLConnection = self::getInstance();
        $MySQLConnection->DatabaseConnection = new \mysqli(
            constant("APP_DB_ADDRESS"), 
            constant("APP_DB_USER"), 
            constant("APP_DB_PASSWORD"),
            constant("APP_DB_NAME"),
            constant("APP_DB_PORT")
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
        $MySQLConnection = self::getInstance();
        $MySQLConnection::performDatabaseConnection();
        return $MySQLConnection->DatabaseConnection;
    }

}

?>