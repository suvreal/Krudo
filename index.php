<?php


/*****************/
/*App preparation*/
/*****************/
declare(strict_types=1);
mysqli_report(MYSQLI_REPORT_ERROR);
error_reporting(E_ERROR | E_WARNING | E_PARSE); // E_ERROR | E_WARNING | E_PARSE, E_ALL
ini_set('display_errors', "1");
ini_set('log_errors', "1");
session_start();


/***************/
/*Configuration*/
/***************/
if (!file_exists("appConfiguration.php")) {
    exit(<<<EOT
    File app configuration is not existing
    <br/>
    - please create appConfiguration.php file in root of Krudo folder according to fourth step in README.md
    EOT);
}
require("appConfiguration.php");


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


// TODO: add this logic to Router
/**************************/
/*URL Processing & ROUTING*/
/**************************/
if (array_key_exists("PATH_INFO", $_SERVER)) {
    if ($ProcessedURL = explode("/", $_SERVER["PATH_INFO"])[1]) {
        (new \Controller\Router())->performRoute($ProcessedURL);
    }
}
if (!array_key_exists("PATH_INFO", $_SERVER)) {
    (new \Controller\Router())->performRoute("products");
}

