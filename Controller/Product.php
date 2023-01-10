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
    static $PageTitle = "Produkt"; 

    /**
     * Product Model object avaiable for Product controller
     */
    public $Product = null;

    public function __construct(\models\Product $Product = null)
    {
        $this->Product = $Product;
    }
    
}