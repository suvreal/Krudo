# Krudo
A basic pure OOP PHP MVP nano framework application for product management.
- PHP 8
- Made with fun and love
- dev version 0.33
- feedback appreciated
- development but functional version

## Features:
- CRUD (administration) of product data
- Authentification and user settings
- Asynchronous search of product
- Browser responsive and compatible

## Installation steps:
1. Prepare implementation environment: PHP 8.0, MySQL 8.0
2. Clone application from repository into desired folder
3. Check & set name of the app root
4. Create and set file appConfiguration.php (where the index.php is) to name app constants correctly for routing and MySQL DB connection:
    ```
    <?php
    define("APP_ROOT", "/KRUDO");

    define("APP_DB_NAME", "dbname");
    define("APP_DB_USER", "admin");
    define("APP_DB_PASSWORD", "admin");
    define("APP_DB_PORT", "3309");
    define("APP_DB_ADDRESS", "127.0.0.1");
    ```

5. Import database structure from provided file: krudo_sql_structure.sql
6. Run application in PHP webserver. For example as below in root of application:
    ```
    php -S localhost:8000
    ``` 
7. App is implemented and provied on desired path, for example: localhost:8000
8. Default user is provided to login

## Usage:
Generally there is important to clone and paste root of app into adequate folder, import database and run webserver for this app. More steps below.
1. Have PHP 8.0 environment prepared with MySQL 8.0
2. Clone this repository
3. Import database structure included
4. Paste root of this repository into running webserver
5. Application is ready to use - perform login to manage products

## Further work:
1. Other FSOP features: filter-ing, improved search-ing, order-ing, page-inating 
2. User role system (users and roles, roles, entity authorization role setting)
3. Multiple content entites as for small CMS or E-commerce solution
4. Multiple languages
5. Multiple currencies and VATs
6. Taxonomy and tags
7. Dynamic blocks and element ordering for homepages and pages
8. Installation process for user access
9. Provide status messages
10. Activity logss
11. Additional product content: image, gallery, parameters, browse metadata, currency, value added tax
12. Content writeout for external non-admin use
13. Submit & request submit handling (source of route, ID-HASH for route key value)

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
- more work will continue to improve request processing according to POST request keys as for update or insert to 
be better matched with Model attributes
- called method for particular route will be added

## Database:
- database export for implementation & test purposes provided in root directory with name krudo_database.sql - name of database is krudo

## Author
SVRL