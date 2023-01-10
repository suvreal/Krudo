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
    static $PageTitle = "Produkty"; 

    public function __construct()
    {
        
    }
    
    // TODO: remove later, testing
    /**
     * Search for product
     * 
     * @param string $term
     */
    public function searchProducts(string $term){

        $termsProducts = array(
            "asd" => array(1,2,3,5,4,6,8,1,351,351,351,351,3515),
            "test" => array(1,2,3,5),
            "asdtest" => array(1,2,3,5),
        );
        if(array_key_exists($term, $termsProducts)){
            return $termsProducts[$term];
        }
    
    }
}