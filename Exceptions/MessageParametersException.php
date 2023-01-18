<?php

Namespace Exceptions;

Use Exception;

/**
 * Message Exception class to provide more information about message components error
 */
Class MessageParametersException extends Exception
{

    /**
     * Returns Message components error message
     *
     * @return string
     */
    public function errorMessage(): string
    {
        echo("<pre>");
        $exceptionText = <<<EOT
        Component Message parameters has not been set properly:
        - Message type
        - Message title = text
        - Message text = body
        EOT;
        echo($exceptionText);
        return 'Error - line '.$this->getLine().' in '.$this->getFile()
            .': <b>'.$this->getMessage().'</b></pre>';
    }

}