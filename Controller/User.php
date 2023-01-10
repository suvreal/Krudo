<?php

namespace controller;

/**
 * Controller class which is result of undefined route by URL path name
 */
Class User extends Controller {

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
    static $PageTitle = "Autentifikace"; 

    /**
     * Product Model object avaiable for Product controller
     */
    public $User = null;

    public function __construct(\models\Model $User = null)
    {
        $this->User = $User;
    }
    
}