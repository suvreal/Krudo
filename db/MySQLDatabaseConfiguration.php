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
    public static $DatabaseConfiguration = array( 
        'DatabaseName' => 'krudo',
        'User' => 'root',
        'Pass' => '123321',
        'Port' => '3309',
        'Address' => '127.0.0.1'
    );

    /**
     * Provides database configuration data as static property
     * 
     * @return array $DatabaseConfiguration
     */
    public static function getDatabaseConfiguration(){
        return static::$DatabaseConfiguration;
    }

}