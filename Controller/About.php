<?php

namespace controller;

/**
 * Controller class which is supposed to show quick information about application
 */
Class About extends Controller {

    /**
     * Definition of view type
     * 
     * @property string $viewType
     */
    static $ViewType = "controller"; 

    /**
     * Definition of HTML Title
     * 
     * @property string $PageTitle
     */
    static $PageTitle = "About this app"; 

    public function __construct()
    {
        
    }

    /**
     * Controller view method by @var $ViewType
     * 
     * @return string
     */
    public function controllerView(){
        $viewData = "";
        $viewData .= "<h2>This is my app</h2>";
        $viewData .= "<p>Welcome and be your guest</p>";
        return $viewData;
    }
    
}