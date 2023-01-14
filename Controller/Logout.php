<?php

namespace controller;

/**
 * Controller class which is supposed to log off user
 */
class Logout extends Router
{

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
    public function controllerView(): string
    {
        if (!\Model\User::CheckUserActivity()) {
            $viewData = "<h2>User is not logged in</h2>";
            $viewData .= "<a href='/login'> -- Eventually go to login</a>";
            return $viewData;
        }

        \Model\User::DeAuthenticate();
        $viewData = "<h2>Logout successful</h2>";
        $viewData .= "<a href='/login'> -- Eventually go back to login</a>";
        return $viewData;

    }
}
