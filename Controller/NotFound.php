<?php

namespace controller;

/**
 * Controller class which is result of undefined route by URL path name
 */
class NotFound extends Router
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
    static $PageTitle = "Not found";

    public function __construct()
    {
    }
}
