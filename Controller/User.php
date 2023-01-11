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
    static $PageTitle = "Authentication"; 

    /**
     * User Model object avaiable for User controller
     * 
     * @property $User
     */
    public $User = null;

    /**
     * User result message
     * 
     * @property $ResultMessage
     * @property $ResultMessageState
     */
    public $ResultMessage = array(
        "title" => "",
        "content" => ""
    );
    public $ResultMessageState = NULL;

    public function __construct(\models\User $User = null)
    {
        $this->User = $User;
        
        if(\models\User::CheckUserActivity() == true){
            header('Location: '.$_SERVER["HTTP_ORIGIN"].'/products', TRUE, 302);
        }

        if(isset($_POST["userEmail"]) && isset($_POST["userPassword"])){
            if($this->User->AuthenticateCheck($_POST["userEmail"], $_POST["userPassword"])){
                $this->User->Authenticate();
                header('Location: '.$_SERVER["HTTP_ORIGIN"].'/products', TRUE, 302);
            }else{
                $this->ResultMessageState = TRUE;
                $this->ResultMessage["title"] = "Wrong user credentials";
                $this->ResultMessage["content"] = "Try different email or password";
            }
        }
 
    }
    
}