<?php

Namespace Exceptions;

Use Exception;

/**
 * Route Exception class to provide more information about route and controller errors
 */
Class RouteControllerException extends Exception
{

    /**
     * Provides route error message
     *
     * @param string $routerClassTest
     * @return string
     */
    public function errorMessage(string $routerClassTest): string
    {
        echo("<pre>");
        $exceptionText = <<<EOT
          Route is not available or set 
          - Searched controller doesn't exist: $routerClassTest
          - Check routesConfiguration.php if particular route is available or set correctly according to request params
          - Wrong routerClass name in routesConfiguration.php
        EOT;
        echo($exceptionText);
        return 'Error on line '.$this->getLine().' in '.$this->getFile()
            .': <b>'.$this->getMessage().'</b></pre>';
    }

}