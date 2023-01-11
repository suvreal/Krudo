<?php

/*****************/
/*App preparation*/
/*****************/
error_reporting(0);
session_start();
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
