<?php

namespace controller;

/**
 * Router class for providing routes according to URL path params or path names
 */
Class Router {

    /**
     * Static routes for router control
     * Provides path name by KEY and controller name by VALUE in routerClass and GET and POST values in requestKeys
     * 
     * 
     * Model, Controller class and its View are expected to be named same in defined folders
     * 
     * @property static $Routes
     */
    static $Routes = array(
        "404" => array(
            "routerClass" => "NotFound",
            "requestKeys" => null,
        ),
        "login" => array(
            "routerClass" => "User",
            "requestKeys" => array(
                "GET" => null,
                "POST" => array("name" => "s", "password" => "s")
            ),
        ),
        "logout" => array(
            "routerClass" => "User",
            "requestKeys" => array(
                "GET" => null,
                "POST" => array("ID" => "i")
            ),
        ),
        "products" => array(
            "routerClass" => "Products",
            "requestKeys" => array(
                "GET" => null,
                "POST" => null
            ),
        ),
        "product" => array(
            "routerClass" => "Product",
            "requestKeys" => array(
                "GET" => array("ID" => "i"),
                "POST" => null
            ),
        ),
        "productDelete" => array(
            "routerClass" => "Product",
            "requestKeys" => array(
                "GET" => array("ID" => "i"),
                "POST" => null
            ),
        ),
        "app" => array(
            "routerClass" => "About",
            "requestKeys" => array(
                "GET" => null,
                "POST" => null
            ),
        ),
    );

    /**
     * View parts files definition
     * 
     * @property $ViewParts
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
     * @param string $pathName
     */
    public function __construct(string $pathName){
        $this->setPathName($pathName);
        $this->setExpectedRequestKeys();
        $this->provideRoute();
    }


    /**
     * Obtains allowed request keys according to POST and GET values
     * 
     * @return @property $ExpectedRequestKeys
     */
    public function getExpectedRequestKeys(){
        return $this->ExpectedRequestKeys;
    }

    /**
     * Obtains all request keys according to POST and GET values
     * 
     * @return @property $PathName
     */
    public function getPathName(){
        return $this->PathName;
    }


    /**
     * Obtains allowed request keys according to POST and GET values
     * 
     * @return array @property $ExpectedRequestKeys
     */
    public function setExpectedRequestKeys(){
        $returnArray = array("GET", "POST");
        $requestKeys = self::getRouteRequestKeys($this->PathName);
        if(!is_null($requestKeys)){
            if(!is_null($requestKeys["GET"])){
                foreach($requestKeys["GET"] as $val => $type){ // TODO: add check type in $type
                    if(isset($_GET[$val])){
                        $returnArray["GET"][$val] = $_GET[$val];
                    }
                }
            }
            if(!is_null($requestKeys["POST"])){
                foreach($requestKeys["POST"] as $val => $type){ // TODO: add check type in $type
                    if(isset($_POST[$val])){
                        $returnArray["POST"][$val] = $_POST[$val];
                    }
                }
            }
        }

        return $this->ExpectedRequestKeys = $returnArray;
    }

    /**
     * Obtains all request keys according to POST and GET values
     * 
     * @param string $pathName
     * @return @property $PathName
     */
    public function setPathName(string $pathName){
        return $this->PathName = $pathName;
    }


    /**
     * Get route controller content according to value and controller settings
     * 
     * @return void
     */
    public function provideRoute(){
        if($resultRouteControllerContent = $this->provideContent($this->getRouteValue($this->PathName))){
            return $resultRouteControllerContent;
        }else{
            throw new \Exception("Route cannot be provided");
        }
    }

    /**
     * Obtains route by URL path params
     * 
     * @param string $pathName
     * @return string 
     */
    public function getRouteValue(string $pathName){
        if(array_key_exists($pathName, self::$Routes)){
            if(class_exists("\\controller\\".self::$Routes[$pathName]["routerClass"])){
                return self::$Routes[$pathName]["routerClass"];
            }else{
                throw new \Exception("Demanded controller class is not existing: ".self::$Routes[$pathName]["routerClass"]);
            }
        }
        return self::$Routes["404"]["routerClass"];
    }

    /**
     * Obtains route request keys by URL path params
     * 
     * @param string $pathName
     * @return null|array 
     */
    public function getRouteRequestKeys(string $pathName){
        if(array_key_exists($pathName, self::$Routes)){
            if(class_exists("\\controller\\".self::$Routes[$pathName]["routerClass"])){
                return self::$Routes[$pathName]["requestKeys"];
            }else{
                throw new \Exception("Demanded controller class is not existing: ".self::$Routes[$pathName]["routerClass"]);
            }
        }
        return null;
    }

    /**
     * Provide content of particular controller with its views/view by controller settings
     * 
     * @param string $controllerClassName
     * @return void
     */
    public function provideContent(string $controllerClassName){
        $controllerClass = "\\controller\\".$controllerClassName;
        if(class_exists("\\models\\".$controllerClassName)){
            $modelControllerClass = "\\models\\".$controllerClassName;
            $expectedRouteRequestKeys = $this->getExpectedRequestKeys();
            if(!is_null($expectedRouteRequestKeys) && 
            array_key_exists("GET", $expectedRouteRequestKeys) && 
            array_key_exists("ID", $expectedRouteRequestKeys["GET"]) && 
            !is_null($ID = $expectedRouteRequestKeys["GET"]["ID"])){
                $modelControllerClassInstance = $modelControllerClass::getInstance($ID);
                $this->Controller = $controllerClassInstance = new $controllerClass($modelControllerClassInstance);
            }else{
                $modelControllerClassInstance = $modelControllerClass::getInstance();
                $this->Controller = $controllerClassInstance = new $controllerClass($modelControllerClassInstance);
            }
        }else{
            $this->Controller = $controllerClassInstance = new $controllerClass();
        }

        if(property_exists($controllerClass, "ViewType")){
            if(file_exists(self::$ViewParts["Header"]) && file_exists(self::$ViewParts["Footer"])){
                require(self::$ViewParts["Header"]);
                if($controllerClass::$ViewType == "template"){
                    require("View\\".$controllerClassName.".phtml");
                }
                if($controllerClass::$ViewType == "controller"){
                    echo $controllerClassInstance->controllerView();
                }
                require(self::$ViewParts["Footer"]);
            }
        }

        return true;

    }

}