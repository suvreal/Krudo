<?php

namespace controller;

/**
 * Controller class which is result of undefined route by URL path name
 */
final class User extends Controller
{

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
     * User Model object available for User controller
     * 
     * @property $User
     */
    public $User = null;

    /**
     * User result message
     * 
     * @property $ResultMessage
     */
    public $ResultMessage = null;

    public function __construct(\Model\User $User = null)
    {
        $this->User = $User;
        if (\Model\User::CheckUserActivity()) {
            Router::routeHeader("/products");
        }
        $this->processAuthentication();
    }

    /**
     * Processes authentication of user
     */
    public function processAuthentication(){
        if (isset($_POST["userEmail"]) && isset($_POST["userPassword"])) {
            if ($this->User->AuthenticateCheck($_POST["userEmail"], $_POST["userPassword"])) {
                $this->User->Authenticate();
                Router::routeHeader("/products");
            } else {
                $this->ResultMessage = true;
            }
        }
    }
}
