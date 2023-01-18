<?php

namespace controller;

use Exception;
use Component;

/**
 * Top level Controller providing general methods for all Controllers
 */
class Controller
{

    /**
     * @var $component
     */
    public $Component;


    /**
     * Provides Controller Component according to name of controller $componentClassName
     *
     * @param string $componentClassName
     * @param array $componentParameters
     * @return void
     */
    public function getComponent(string $componentClassName, array $componentParameters): void
    {
        //Preparation of expected folders
        $viewTemplate = "View\\Component\\" . $componentClassName . ".phtml";
        $componentClass = "Controller\\Component\\".$componentClassName;

        // Check for existence of component
        if(class_exists($componentClass)) {
            // Obtaining Component class instance
            if(count($componentParameters) > 0){
                $componentClassInstance = new $componentClass(...$componentParameters);
            }else{
                $componentClassInstance = new $componentClass();
            }
            $this->Component = $componentClassInstance;
            // Check which ViewType settings current Controller has - showing template
            if ($componentClassInstance::$ViewType == "template") {
                require($viewTemplate);
            }
            // Check which ViewType settings current Controller has - showing method html without template
            if ($componentClassInstance::$ViewType == "controller") {
                echo $componentClassInstance->controllerView();
            }
        }

    }

}


