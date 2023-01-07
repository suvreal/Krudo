<?php

namespace db;

/**
 * Database configuration static class
 */
Class MySQLDatabaseConfiguration {

    /**
     * Database configuration attributes
     * 
     * @var $DatabaseConfiguration
     */
    public static $DatabaseConfiguration;

    /**
     * Provides database configuration data as static property
     * 
     * @return array $DatabaseConfiguration
     */
    public static function getDatabaseConfiguration(){
        return static::$DatabaseConfiguration = array(
            'DatabaseName' => constant("APP_DB_NAME"),
            'User' => constant("APP_DB_USER"),
            'Pass' => constant("APP_DB_PASSWORD"),
            'Port' => constant("APP_DB_PORT"),
            'Address' => constant("APP_DB_ADDRESS")
        );
    }

}