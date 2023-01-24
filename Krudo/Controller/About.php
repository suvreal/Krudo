<?php

namespace Controller;

/**
 * Controller class which is supposed to show quick information about application
 */
final class About extends Controller
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
     * Provides addition to document's head tag
     *
     * @return string
     */
    public static function provideHeaderControllerAddition(): string
    {
        return(<<<EOT
        <meta name="keywords" content="Krudo, krucial done, tiny MVP framework">
        <meta name="description" content="Krudo krucial done">
        <meta name="author" content="Bartoloměj Eliáš">
        EOT);
    }

    /**
     * Controller view method by @var $ViewType
     * 
     * @return string
     */
    public function controllerView(): string
    {
        return(<<<EOT
        <div class="page-content-container">
        <h2>This is my app</h2>
        <br/>
        <p>Welcome and be my guest</p>
        <p>This is page about this app</p>
        </div>
        EOT);
    }
}
