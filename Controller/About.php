<?php

namespace controller;

/**
 * Controller class which is supposed to show quick information about application
 */
class About extends Router
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
    static $PageTitle = "About this app";

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
        return(<<<EOT
        <h2>This is my app</h2>
        <br/>
        <p>Welcome and be my guest</p>
        EOT);
    }
}
