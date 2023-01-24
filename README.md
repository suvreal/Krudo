# Krudo
A basic pure OOP PHP MVP nano framework application for product management.
- PHP 8.1.x
- Made with fun and love
- dev version 0.5
- feedback appreciated
- development but functional version

## Features:
- CRUD (administration) of product data
- Authentication
- Asynchronous search of product
- Browser responsive and compatible

## Installation steps:
1. Prepare implementation environment: PHP 8.0, MySQL 8.0
2. Clone application from repository into desired folder
3. Check & set name of the app root
4. Create and set file appConfiguration.php (where the index.php is) to name app constants correctly for routing and MySQL DB connection:
    ```
    <?php
    const APP_ROOT = "/Krudo"; // default
    const APP_ROOT_MAIN = "Krudo"; // default

    const APP_DB_NAME = "krudo";
    const APP_DB_USER = "root";
    const APP_DB_PASSWORD = "123321";
    const APP_DB_PORT = "3309";
    const APP_DB_ADDRESS = "127.0.0.1";
    ```
5. Import database structure from provided file: krudo_sql_structure.sql
6. Run application in PHP webserver. For example as below in root of application:
    ```
    php -S localhost:8000
    ``` 
7. App is implemented and provied on desired path, for example: localhost:8000
8. Default user is provided to login

## Tests installation:
1. In root prepare vendor using (PHPUnit 8.3.0 for PHP 8):
   ```
   composer require --dev phpunit/phpunit ^9.3.0
   ```
2. Test installed version of PHPUnit:
    ```
   ./vendor/bin/phpunit --version
   ```
3. Run autoload dump to prepare loading of tests to Krudo:
    ```
    composer dump-autoload
    ```
4. Run tests prepared for Krudo:
   ```
   ./vendor/bin/phpunit KrudoTest
   ```

## Tests implementation:
- set app source composer.json:
   ```
     {
        "require-dev": {
         "phpunit/phpunit": "9.3.0"
        },
        "autoload": {
           "classmap": [
            "Krudo/"
           ]
        }
     }
   ```
- set tests source in phpunit.xml (example):
   ```
   <?xml version="1.0" encoding="UTF-8"?>
   <phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
   xsi:noNamespaceSchemaLocation="https://schema.phpunit.de/9.3/phpunit.xsd"
   bootstrap="vendor/autoload.php"
   executionOrder="depends,defects"
   forceCoversAnnotation="true"
   beStrictAboutCoversAnnotation="true"
   beStrictAboutOutputDuringTests="true"
   beStrictAboutTodoAnnotatedTests="true"
   failOnRisky="true"
   failOnWarning="true"
   verbose="true"
   colors="true">
   <testsuites>
   <testsuite name="Krudo">
   <directory suffix="Test.php">KrudoTest</directory>
   </testsuite>
   </testsuites>
   
       <coverage processUncoveredFiles="true">
           <include>
               <directory suffix=".php">src</directory>
           </include>
       </coverage>
   </phpunit>
   ```

## Usage:
Generally there is important to clone and paste root of app into adequate folder, import database and run webserver for this app. More steps below.
1. Have PHP 8.0 environment prepared with MySQL 8.0
2. Clone this repository
3. Import database structure included
4. Paste root of this repository into running webserver
5. Application is ready to use - perform login to manage products

## Further possible work:
1. Other FSOP features: filter-ing, improved search-ing, order-ing, page-inating 
2. User role system (users and roles, roles, entity authorization role setting)
3. Multiple content entites
4. Multiple languages
5. Multiple currencies and VATs
6. Taxonomy and tags
7. Dynamic blocks and element ordering for homepages and pages
8. Installation process for user access
9. Provide status messages
10. Activity logs
11. Additional product content: image, gallery, parameters, browse metadata, currency, value added tax
12. Content writeout for external non-admin use

## Short term TODO:
- improve routing for methods and request parameters and controller interaction
- improve request processing
- unit tests
- improve search

## User test access:
- name: admin@krudo.cz
- password: 6546544fdasdf
 
## Routes example
Example of definition of route for in file routesConfiguration.php in root folder:
   ```
    "called-string-URL-path" => array(
        "routerClass" => "adequate-controller-name",
        "requestKeys" => array(
            "GET" => array("ID"),
            "POST" => array("attr-one", "attr-two", "attr-three"),
        ),
    ),
   ```
- called-string-url-path is $_SERVER PATH_INFO value
- routerClass is supposed to be set with valid ClassName of Controller namespace
  - routeClass name is compared in model and view namespaces to get proper view or model
- requestKeys are expected URL params matching DB attributes to process (save, update, delete, visit)


## Database:
- database export for implementation & test purposes provided in root directory with name krudo_database.sql - name of database is krudo

## Author
SVRL