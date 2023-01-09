<?php

/*****************/
/*App preparation*/
/*****************/
error_reporting(E_ALL);
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
// $model->SaveRecord();
// $model->getId();



/*
$model = models\Product::getInstance(); 
$dataToSave = array(
    "Title" => "Test product 6",
    "Description" => "test product 6",
    "ShortDescription" => "prod 6",
    "DiscountPrice" => 850,
    "Price" => 700,
);
$model->setAttributeValues($dataToSave);
var_export($model->getAttributeValues());
$model->SaveRecord();
$model->getId();
*/

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
// var_export(($testModelInstance2->SaveRecord())->get_result());

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
// var_export(models\Product::ObtainAllRecordsByModel("Price < 500")); // ObtainAllRecordsByModel
// echo("</pre>");
/*MODEL QUERY SINGLE TEST END*/

/*MODEL INSTANCE DELETION START*/
// $testModel4 = models\Product::getInstance(8);
// $model = models\Product::getInstance(); 
// $dataToSave = array(
//     "Title" => "Test product 6",
//     "Description" => "test product 6",
//     "ShortDescription" => "prod 6",
//     "DiscountPrice" => 850,
//     "Price" => 700,
// );
// // $testModel4->DeleteRecord();
// $model->setAttributeValues($dataToSave);
// $model->SaveRecord();
// echo($model->getId());

// echo($model->getId());
// $model = models\Product::getInstance(8);
// echo("<pre>");
// var_export($model->DeleteRecord());
// echo("</pre>");
// echo("<pre>");
// var_export($model->removeInstance());
// echo("</pre>");

// echo("<pre>");
// var_export(models\Product::getAllInstances());
// echo("</pre>");

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



/*MULTIPLE DIFFERENT INSTANCES - START*/
// $testUser = models\User::getInstance(1);
// $testProduct = models\Product::getInstance(9);
// echo("<pre>");
// var_export(models\Model::getAllInstances());
// echo("</pre>");
/*MULTIPLE DIFFERENT INSTANCES - END*/



/*authentication - START*/

// models\User::getInstance(6)->DeleteRecord();
// models\User::getInstance(5)->DeleteRecord();
// models\User::getInstance(4)->DeleteRecord();
// models\User::getInstance(3)->DeleteRecord();



// echo("<pre>");
// $userModelInstance = models\User::getInstance();
// $userModelInstance->setAttributeValues(
//     array(
//         "Name" => "Asd User",
//         "Email" => "asd@asd.asd",
//         "Phone" => "987987987",
//         "Password" => "6546544fdasdf",
//         "DateCreated" => date('Y-m-d H:i:s'),
//         "UserType" => "created",
//         "Active" => 0,
//     )
// );
// var_export($userModelInstance->setAttributeValue("Email", "asdasd654asdsadada@test.test"));
// var_export($userModelInstance->SaveRecord());
// var_export($userModelInstance->getAttributeValues());
// echo("</pre>");


// $userModelInstance = models\User::getInstance(2);
// echo(password_verify('6546544fdasdf', $userModelInstance->ModelData->Password));
// echo("<pre>");
// var_export($userModelInstance->AuthenticateCheck("asdasd@test.test", "6546544fdasdf")); //6546544fdasdf
// echo("</pre>");
// $userModelInstance->Authenticate();
// var_export($userModelInstance->DeAuthenticate());

/*authentication - END*/



/*BUILD QUERY TEST - START*/

// var_export(
//     models\User::BuildQueryByModel(
//         "*", 
//         "ORDER BY Title ASC", 
//         "Title LIKE '?'", 
//         array("prod" => "s")
//     )
// );
// var_export(models\Product::BuildQueryByModel("*", "", "ID = 17"));
// var_export(models\Product::BuildQueryByModel("*", "", "ID = ?", array(17 => 'i')));
// models\User::BuildQueryByModel("*", "LIMIT 2", "Email = ?", array("asdasd@test.test" => "s"))
// var_export(models\Product::BuildQueryByModel("*", "", "Price > ? OR Price < ?", array(100 => "i", 1000 => "i")));
// echo("<pre>");
// var_export(models\Product::BuildQueryByModel("*", "", "Title LIKE ? OR Description LIKE ?", array("Test product 5" => "s", "prod 5" => "s")));
// echo("</pre>");

/*BUILD QUERY TEST - END*/




// TODO: create URL identification
// TODO: call static page or instance of model (Product and app settings)
// TODO: complet return page with templates: header, content, footer
// TODO: content of tempate structure might be extra content with CSS or just controller (identify it in controller class with static property $templateType with values "controller" or "template")
// TODO: create FE components: forms - C&D, 
// TODO: solve submits and processing of forms

