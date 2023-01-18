<?php

Namespace Exceptions;

Use Exception;

/**
 * Route Exception class to provide more information about application configuration
 */
class AppConfigurationException extends Exception
{
    /**
     * Returns app configuration erro message
     *
     * @return string
     */
    public function errorMessage(): string
    {
        exit(<<<EOT
        File app configuration is not existing
        <br/>
        - please create appConfiguration.php file in root of Krudo folder according to fourth step in README.md
        EOT);
    }

}