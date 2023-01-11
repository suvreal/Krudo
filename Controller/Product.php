<?php

namespace controller;

/**
 * Controller class which is result of undefined route by URL path name
 */
Class Product extends Controller {

    /**
     * Definition of view type
     * 
     * @property string $ViewType
     */
    static $ViewType = "template"; 

    /**
     * Definition of HTML Title
     * 
     * @property string $PageTitle
     */
    static $PageTitle = "Product"; 

    /**
     * Product Model object avaiable for Product controller
     * 
     * @property $Product
     */
    public $Product = null;

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

    public function __construct(\models\Product $Product = null)
    {
        $this->Product = $Product;
        if(\models\User::CheckUserActivity() != true){
            header('Location: '.$_SERVER["HTTP_ORIGIN"].'/login', TRUE, 302);
        }

        if(isset($_POST) && 
        isset($_POST["Title"]) && 
        isset($_POST["ShortDescription"]) && 
        isset($_POST["Description"]) &&
        isset($_POST["Price"]) && 
        isset($_POST["DiscountPrice"])
        ){

            if(isset($_POST["ID"])){
                $ID = $_POST["ID"];
                $this->Product->setId($ID);
            }

            $dataToSave = array(
                "Title" => $_POST["Title"],
                "ShortDescription" => $_POST["ShortDescription"],
                "Description" => $_POST["Description"],
                "Price" => $_POST["Price"],
                "DiscountPrice" => $_POST["DiscountPrice"],
            );
            $this->Product->setAttributeValues($dataToSave);

            $this->Product->SaveRecord();


            if($this->Product->getId() > 0){
                header('Location: '.$_SERVER["HTTP_ORIGIN"].'/products', TRUE, 302);
            }else{
                $this->ResultMessageState = TRUE;
                $this->ResultMessage["title"] = "Error occured while record save";
                $this->ResultMessage["content"] = "Try operation later or contact administrator";
            }
            
        }

    }
    
}