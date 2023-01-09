# Krudo
A basic PHP framework application for your product management written in pure PHP OOP.
- PHP 8
- Made with fun and love
- version 0.2

## Features:
- CRUD of product data
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
6. Run application in PHP webserver
7. App is implemented and provied on desired path

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


## Author
SVRL