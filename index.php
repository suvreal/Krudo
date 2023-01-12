<?php

/*****************/
/*App preparation*/
/*****************/
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
session_start();
if(!file_exists("appConfiguration.php")){
    echo("File app configuration is not existing");
    echo("<br/>");
    echo("- please create appConfiguration.php file in root of Krudo folder according to fourth step in README.md");
    exit;
}
require("appConfiguration.php");


/*************/
/*Autoloading*/
/*************/
spl_autoload_register(function ($class) {
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class).'.php';
    if (file_exists($file)) {
        require $file;
        return true;
    }
    return false;
});


/**************************/
/*URL Processing & ROUTING*/
/**************************/
if(array_key_exists("PATH_INFO", $_SERVER)){
    if($ProcessedURL = explode("/", $_SERVER["PATH_INFO"])[1]){
        new \controller\Router($ProcessedURL);
    }
}
if(!array_key_exists("PATH_INFO", $_SERVER)){
    new \controller\Router("products");
}

