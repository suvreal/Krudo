<?php

/*****************/
/*App preparation*/
/*****************/
session_start();

/*************/
/*Autoloading*/
/*************/
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

/*********/
/*Routing*/
/*********/
// include("appConfiguration.php");
// constant("APP_ROOT");
// TODO: process request and path according to root folder path which is expected as krudo


/************/
/*Run & test*/
/************/


// $conn = MySQLConnection::getInstance();
// $conn::performDatabaseConnection();
// $conn::getDatabaseConnection();

// $model = models\Product::getInstance(); 
// $dataToSave = array(
//     "Title" => "Test product 6",
//     "Description" => "test product 6",
//     "ShortDescription" => "prod 6",
//     "DiscountPrice" => 850,
//     "Price" => 700,
// );
// $model->setAttributeValues($dataToSave);
// echo("<br/>");
// echo("<pre>");
// var_export($model->getAttributeValues());
// echo("</pre>");
// echo("<br/>");
// echo($model->getAttributeValue("Price"));
// $model->InsertRecords();
// $model->getId();

//var_export(\models\Product::prepareConnection());


$model3 = models\Product::getInstance(4);
echo("<pre>");
var_export($model3);
echo("</pre>");

