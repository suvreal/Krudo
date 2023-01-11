<?php

namespace controller;

/**
 * Controller class which is supposed to log off user
 */
Class Logout extends Controller {

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
    static $PageTitle = "Logout"; 

    public function __construct()
    {
        
    }

    /**
     * Controller view method by @var $ViewType
     * 
     * @return string
     */
    public function controllerView(){
        if(\models\User::CheckUserActivity() == false){
            $viewData = "";
            $viewData .= "<h2>User is not logged in</h2>";
            $viewData .= "<a href='login'> -- Eventually go to login</a>";
            return $viewData;
        }else{
            \models\User::DeAuthenticate();
            $viewData = "";
            $viewData .= "<h2>Logout successful</h2>";
            $viewData .= "<a href='login'> -- Eventually go back to login</a>";
            return $viewData;
        }
    }
    
}