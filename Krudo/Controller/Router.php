<?php

namespace Controller;

use Exception;
use Exceptions\RouteControllerException;

/**
 * Router class for providing routes according to URL path params or path names
 */
class Router
{

    /**
     * Definition of main required folders
     * 
     * @property array $MainFolderPathNames
     */
    static $MainFolderPathNames = array(
        "view" => "View",
        "controller" => "Controller",
        "model" => "Model",
    );

    /**
     * View parts files definition
     * 
     * @property array $ViewParts
     */
    static $ViewParts = array(
        "Header" => "View\\ViewParts\\Header.phtml",
        "Footer" => "View\\ViewParts\\Footer.phtml",
    );

    /**
     * URL pathname of request
     * 
     * @property $pathName
     */
    public $PathName = null;

    /**
     * Expected request keys for GET and POST according to route URL pathname settings
     * 
     * @property $ExpectedRequestKeys
     */
    public $ExpectedRequestKeys = null;

    /**
     * Requested keys for GET and POST - all
     * 
     * @property $RequestKeys
     */
    public $RequestKeys = null;

    /**
     * Routed Controller class according to request
     * 
     * @property $Controller
     */
    public $Controller = null;

    /**
     * Routes by configuration
     * 
     * @property $Routes
     */
    public $Routes;

    public function __construct()
    {

    }

    /**
     * Initializes Router
     *
     * @return void
     * @throws Exception
     */
    public static function Route(): void
    {
        if (array_key_exists("PATH_INFO", $_SERVER)) {
            if ($ProcessedURL = explode("/", $_SERVER["PATH_INFO"])[1]) {
                (new self())->performRoute($ProcessedURL);
            }
        }
        if (!array_key_exists("PATH_INFO", $_SERVER)) {
            (new self())->performRoute("products");
        }
    }

    /**
     * @param string $pathName
     * @return void
     * @throws Exception
     */
    public function performRoute(string $pathName): void
    {
        $this->setRoutes()
            ->setPathName($pathName)
            ->setExpectedRequestKeys()
            ->provideContent($this->getRouteValue($this->PathName));
    }

    /**
     * @param string $urlPath
     * @return void
     */
    public static function routeHeader(string $urlPath = "\\"): void
    {
        header('Location: '.$_SERVER["HTTP_ORIGIN"].$urlPath, TRUE, 302);
    }

    /**
     * A getter for Routes property
     *
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->Routes;
    }

    // TODO: add exception
    /**
     * Sets routes configuration
     *
     * Getter for @property $Routes
     */
    public function setRoutes(): Router
    {
        if (!file_exists(constant("APP_ROOT_MAIN")."/routesConfiguration.php")) {
            exit(<<<EOT
            Routes configuration file is not existing
            <br/>
            - please create routesConfiguration.php file in root of Krudo folder and fill it by Routes example in README.MD
            EOT);
        }
        $this->Routes = include(constant("APP_ROOT_MAIN")."/routesConfiguration.php");
        return $this;
    }

    /**
     * Obtains allowed request keys according to POST and GET values
     * 
     * @return array
     */
    public function getExpectedRequestKeys(): ?array
    {
        return $this->ExpectedRequestKeys;
    }

    /**
     * Obtains allowed request keys according to POST and GET values
     * 
     * @param string $requestType as main key of ExpectedRequestKeys array
     * @param string $key of ExpectedRequestKeys array
     *
     * @return string
     */
    public function getExpectedRequestValueByKey(string $requestType, string $key): ?string
    {
        if(array_key_exists($requestType, $this->ExpectedRequestKeys) && 
        array_key_exists($key, $this->ExpectedRequestKeys[$requestType])){

            return $this->ExpectedRequestKeys[$requestType][$key];
        }   
        return null;
    }

    /**
     * Obtains allowed request keys according to POST
     * 
     * @return array
     */
    public function getExpectedPostRequestKeys(): ?array
    {
        if(array_key_exists("POST",$this->ExpectedRequestKeys)){
            return $this->ExpectedRequestKeys["POST"];
        }
        return null;
    }

    /**
     * Obtains allowed request keys according to GET values
     * 
     * @return array
     */
    public function getExpectedGetRequestKeys(): ?array
    {
        if(array_key_exists("GET",$this->ExpectedRequestKeys)){
            return $this->ExpectedRequestKeys["GET"];
        }
        return null;
    }

    /**
     * Obtains all request keys according to POST and GET values
     * 
     * @return string
     */
    public function getPathName(): string
    {
        return $this->PathName;
    }

    /**
     * Obtains all request keys according to POST and GET values
     *
     * @param string $pathName
     * @return Router|null
     */
    public function setPathName(string $pathName): ?Router
    {
        if($this->PathName = $pathName){
            return $this;
        }
        return null;
    }

    /**
     * Obtains allowed request keys according to POST and GET values
     * 
     * @return Router
     */
    public function setExpectedRequestKeys(): Router
    {
        $returnArray = array(
            "GET" => array(),
            "POST" => array()
        );

        $requestKeys = self::getRouteRequestKeys($this->PathName);       
        if (!is_null($requestKeys)) {
            if (isset($requestKeys["GET"])) {
                foreach ($requestKeys["GET"] as $val) {
                    if (isset($_GET[$val])) {
                        $returnArray["GET"][$val] = $_GET[$val];
                    }
                }
            }
            if (isset($requestKeys["POST"])) {
                foreach ($requestKeys["POST"] as $val) {
                    if (isset($_POST[$val])) {
                        $returnArray["POST"][$val] = $_POST[$val];
                    }
                }
            }
        }

        $this->ExpectedRequestKeys = $returnArray;
        return $this;
    }

    /**
     * Obtains route by URL path params
     *
     * @param string $pathName
     * @return string
     * @throws Exception
     */
    public function getRouteValue(string $pathName): ?string
    {
        if (array_key_exists($pathName, $this->Routes)) {
            try {
                if (class_exists(self::$MainFolderPathNames["controller"] . "\\" . $this->Routes[$pathName]["routerClass"])) {
                    return $this->Routes[$pathName]["routerClass"];
                } else {
                    throw new RouteControllerException("Controller not found");
                }
            }catch(RouteControllerException $e){
                echo("Message: ". $e->errorMessage($this->Routes[$pathName]["routerClass"]));
            }
        }
        return $this->Routes["404"]["routerClass"];
    }

    /**
     * Obtains route request keys by URL path params
     *
     * @param string $pathName
     * @return null|array
     */
    public function getRouteRequestKeys(string $pathName): ?array
    {
        if (array_key_exists($pathName, $this->Routes)) {
            if (class_exists("\\" . self::$MainFolderPathNames["controller"] . "\\" . $this->Routes[$pathName]["routerClass"])) {
                return $this->Routes[$pathName]["requestKeys"];
            }
        }
        return null;
    }

    /**
     * Provide content of particular controller with its views/view controller settings and model by request
     * 
     * @param string $controllerClassName
     * @return void
     */
    public function provideContent(string $controllerClassName)
    {
        // Prepare folders to check Controller and Model classes with Views
        $controllerClass = self::$MainFolderPathNames["controller"] . "\\" . $controllerClassName;
        $modelControllerClass = self::$MainFolderPathNames["model"] . "\\" . $controllerClassName;
        $viewTemplate = constant("APP_ROOT_MAIN")."\\".self::$MainFolderPathNames["view"] . "\\" . $controllerClassName . ".phtml";

        // Get possible model for particular controller
        // Check if current Controller name exists in Model folder to provide common data
        if (class_exists($modelControllerClass)) {
            // Check if provided ID from request is expected for this route
            if(!is_null($ID = $this->getExpectedRequestValueByKey("GET", "ID"))){
                // Creating instance of relevant model with added obtained ID from request
                $modelControllerClassInstance = $modelControllerClass::getInstance($ID);
            }else{
                // Creating instance of relevant model without any ID
                $modelControllerClassInstance = $modelControllerClass::getInstance();
            }
            // Creating new Controller instance with particular model as DI
            $this->Controller = new $controllerClass($modelControllerClassInstance);
        }else{
            // No Model for particular Controller was found - creating just new Controller instance
            $this->Controller = new $controllerClass();
        }

        // Complete whole return page of all additions
        // Provide constant header for provided content Controller
        require(constant("APP_ROOT_MAIN")."\\".self::$ViewParts["Header"]);
        // Check which ViewType settings current Controller has - showing template
        if ($controllerClass::$ViewType == "template") {
            require($viewTemplate);
        }
        // Check which ViewType settings current Controller has - showing method html without template
        if ($controllerClass::$ViewType == "controller") {
            echo $this->Controller->controllerView();
        }
        // Provide constant header for provided content Controller
        require(constant("APP_ROOT_MAIN")."\\".self::$ViewParts["Footer"]);
    }

}
