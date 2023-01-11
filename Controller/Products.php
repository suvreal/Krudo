<?php

namespace controller;

/**
 * Controller class which is result of undefined route by URL path name
 */
Class Products extends Controller {

    /**
     * Definition of view type
     * 
     * @property string $viewType
     */
    static $ViewType = "template"; 

    /**
     * Definition of HTML Title
     * 
     * @property string $PageTitle
     */
    static $PageTitle = "Products"; 

    /**
     * Product result message
     * 
     * @property $ResultMessage
     * @property $ResultMessageState
     */
    public $ResultMessage = array(
        "title" => "",
        "content" => ""
    );
    public $ResultMessageState = NULL;

    public function __construct(){
        if(\models\User::CheckUserActivity() != true){
            header('Location: '.$_SERVER["HTTP_ORIGIN"].'/login', TRUE, 302);
        }
        if(isset($_GET["deleteProductID"])){
            if(\models\Product::getInstance(intval($_GET["deleteProductID"]))->DeleteRecord() == false){
                header('Location: '.$_SERVER["HTTP_ORIGIN"].'/products', TRUE, 302);
            }else{
                $this->ResultMessageState = TRUE;
                $this->ResultMessage["title"] = "Error occured while deletion";
                $this->ResultMessage["content"] = "Try operation later or contact administrator";
            }
        }
        if(isset($_POST["searchProducts"])){            
            $term = $_POST["searchProducts"];
            $_POST = array();
            echo json_encode(array("Result"=> "OK","Data" => $this->searchProducts(strval($term))));
            exit;
        }
    }
    
    /**
     * Search for product
     * 
     * @param string $term
     */
    public function searchProducts(string $term)
    {
        $resultArray = array();
        if($results = \models\Product::BuildQueryByModel("*", "", "Title LIKE ? OR Description LIKE ?", "ss", array("%{$term}%","%{$term}%"))){
            foreach($results as $result){
                $resultArray[] = $result->ModelData;
            }
        }
        return $resultArray;
    }

    /**
     * Get all products
     * 
     * @param string $term
     */
    public function getAllProducts()
    {
        return \models\Product::BuildQueryByModel("*", "", "", null, null);
    }
}