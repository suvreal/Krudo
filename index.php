<?php


/*****************/
/*App preparation*/
/*****************/
declare(strict_types=1);
mysqli_report(MYSQLI_REPORT_ERROR);
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', "1");
ini_set('log_errors', "1");
session_start();


/**********/
/*Autoload*/
/**********/
spl_autoload_register(function ($class) {
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (file_exists($file)) {
        require $file;
        return true;
    }
    return false;
});


/*******************/
/*App Configuration*/
/*******************/
try {
    if (file_exists("appConfiguration.php")) {
        require("appConfiguration.php");
    }else{
        throw new Exceptions\AppConfigurationException();
    }
}catch(\Exceptions\AppConfigurationException $e){
    echo("Message " .$e->errorMessage());
}


/*********/
/*Routing*/
/*********/
\Controller\Router::Route();

