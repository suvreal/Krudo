<?php

Namespace Exceptions;

Use Exception;

/**
 * Route Exception class to provide more information about MySQL Connection errors
 */
Class MySQLConnectionException extends Exception {

    /**
     * Returns MySQLConnectionException error message
     *
     * @return string
     */
    public function errorMessage(): string
    {
        echo("<pre>");
        $exceptionText = <<<EOT
          Connection is not available or set 
          - Check appConfiguration.php for database access settings
          - Check availability of MySQL database server
        EOT;
        echo($exceptionText);
        return 'Error - line '.$this->getLine().' in '.$this->getFile()
            .': <b>'.$this->getMessage().'</b></pre>';
    }

}