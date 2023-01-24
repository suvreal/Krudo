<?php


/**
  * Imports & sets
 */
declare(strict_types=1);
use Controller\Router;
use Exceptions\AppConfigurationException;


/**
 * App preparation
 */
mysqli_report(MYSQLI_REPORT_ERROR);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', "1");
ini_set('log_errors', "1");
session_start();


/**
 * App Configuration
 */
try {
    if (file_exists("appConfiguration.php")) {
        require("appConfiguration.php");
    }else{
        throw new AppConfigurationException();
    }
}catch(AppConfigurationException $e){
    echo("Message " .$e->errorMessage());
}


/**
 * Autoload
 */
spl_autoload_register(function ($class) {
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (file_exists(constant("APP_ROOT_MAIN").'\\'.$file)) {
        require constant("APP_ROOT_MAIN").'\\'.$file;
        return true;
    }
    return false;
});


/**
 * Routing
 */
try {
    Router::Route();
} catch (Exception $e) {
    echo("Message: ".$e->getMessage());
}


