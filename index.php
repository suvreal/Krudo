<?php

/*****************/
/*App preparation*/
/*****************/
session_start();
require("appConfiguration.php");

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

// $model3 = models\Product::getInstance(2);
// echo("<pre>");
// var_export($model3);
// echo("</pre>");


/*INSTANCES TEST START*/
// $testModelInstance = models\Product::getInstance(2);
// $testModelInstance2 = models\Product::getInstance(3);
// $dataToSave = array(
//     "Title" => "eee EDIT asd asdasdadd",
//     "Description" => "edit test product asd",
//     "ShortDescription" => "edit prod edit",
//     "DiscountPrice" => 1000,
//     "Price" => 850,
// );
// $testModelInstance2->setAttributeValues($dataToSave);
// echo($testModelInstance2->getId());
// echo("<br>");
// var_export(($testModelInstance2->InsertRecords())->get_result());

// echo("<pre>");
// var_export($testModelInstance2);
// echo("</pre>");
// echo("<hr>");
// echo("<pre>");
// var_export(models\Product::getAllInstances());
// echo("</pre>");
/*INSTANCES TEST END*/

/*MODEL QUERY SINGLE TEST START*/
// echo("<pre>");
// var_export(models\Product::ObtainAllRecordsByModel("Price < 500")); // ObtainAllRecordsByModel, PerformQueryByModel
// echo("</pre>");
/*MODEL QUERY SINGLE TEST END*/

/*MODEL INSTANCE DELETION START*/
// $modelTest = models\Product::getInstance(3);
// var_export($modelTest->DeleteRecord());
/*MODEL INSTANCE DELETETION END*/

/*SESSION INSTANCES TEST START*/
// TODO: check insert and update
// $testModel1 = models\Product::getInstance();
// $testModel2 = models\Product::getInstance(2);
// $testModel3 = models\Product::getInstance(3);
// $testModel4 = models\Product::getInstance(4);

// Prepare session instances variable - model instances
// if(!array_key_exists("ModelInstances", $_SESSION)){
//     $_SESSION["ModelInstances"] = array();
// }
// Prepare given model class session instances variable - model class name
// if(!array_key_exists(get_class($testModel2), $_SESSION["ModelInstances"])){
//     $_SESSION["ModelInstances"][get_class($testModel2)] = array();
// }

// Existence check of model class object session instance variable
// if(array_key_exists($testModel2->getId(), $_SESSION["ModelInstances"][get_class($testModel2)])){
//     echo("EXISTS");
// }else{
//     echo("DOESN'T EXISTS");
// }

// Prepare given model class object session instances variable - model instance
// if(!array_key_exists($testModel2->getId(), $_SESSION["ModelInstances"][get_class($testModel2)])){
//     $_SESSION["ModelInstances"][get_class($testModel2)][$testModel2->getId()] = $testModel2;
// }
// if(!array_key_exists($testModel3->getId(), $_SESSION["ModelInstances"][get_class($testModel3)])){
//     $_SESSION["ModelInstances"][get_class($testModel3)][$testModel3->getId()] = $testModel3;
// }
// if(!array_key_exists($testModel4->getId(), $_SESSION["ModelInstances"][get_class($testModel4)])){
//     $_SESSION["ModelInstances"][get_class($testModel4)][$testModel4->getId()] = $testModel4;
// }

// Obtain given model class instance from session
// if(array_key_exists($testModel4->getId(), $_SESSION["ModelInstances"][get_class($testModel4)])){
//     $classInstanceSession = $_SESSION["ModelInstances"][get_class($testModel4)][$testModel4->getId()];
//     echo("<pre>");
//     var_export($classInstanceSession);
//     echo("</pre>");
// }

// Remove instance from session by model class name and ID
// unset($_SESSION["ModelInstances"][get_class($testModel2)][$testModel2->getId()]);

// Obtain all instances through classes
// echo("<pre>");
// var_export($_SESSION["ModelInstances"]);
// echo("</pre>");

// Obtain all instances through classes
// echo("<pre>");
// var_export($_SESSION["ModelInstances"][get_class($testModel2)]);
// echo("</pre>");
/*SESSION INSTANCES TEST END*/

// TODO: add method to get all records as instances of given model class not just records - use already existing methods to rework