<?php

namespace db;

use Exception;
use mysqli;

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
     * @throws Exception
     */
    public function __clone()
    {
        throw new Exception("Cannot be cloned");
    }

    /**
     * Singleton instance obtain
     * 
     * @return MySQLConnection
     */
    public static function getInstance(): ?MySQLConnection
    {
        if (is_null(self::$Instance)){
            $className = __CLASS__;
            self::$Instance = new $className;
        }

        return self::$Instance;
    }

    /**
     * Performs database connection
     *
     * @return ?MySQLConnection
     */
    public static function performDatabaseConnection(): ?MySQLConnection
    {
        $MySQLConnection = self::getInstance();
        $MySQLConnection->DatabaseConnection = new mysqli(
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
     * @return mysqli
     */
    public static function getDatabaseConnection(): mysqli
    {
        $MySQLConnection = self::getInstance();
        $MySQLConnection::performDatabaseConnection();
        return $MySQLConnection->DatabaseConnection;
    }

}
