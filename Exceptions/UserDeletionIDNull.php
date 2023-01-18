<?php

namespace Exceptions;

Use Exception;

/**
 * User deletion of ID null exception
 */
class UserDeletionIDNull extends Exception
{

    /**
     * Return User deletion ID null string
     *
     * @return string
     */
    public function errorMessage(int $id): string
    {
        echo("<pre>");
        $exceptionText = <<<EOT
        Record of deletion attempt is not available
        - record with called ID is not existing
        - record with called ID is not approchable
        EOT;
        echo($exceptionText);
        return 'Error - line '.$this->getLine().' in '.$this->getFile()
            .': <b>'.$this->getMessage().'</b></pre>';
    }

}