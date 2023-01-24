<?php

/**
 * Routes for router control
 * Provides searched path name by KEY
 *
 * in Key routerClass is provided name of relevant controller class
 * in Key requestKeys is provided expected POST & GET request values
 *
 * Model, Controller class and its View are expected to be named same in defined folders
 *
 * @return array
 */
return array(
    "404" => array(
        "routerClass" => "NotFound",
        "requestKeys" => null,
    ),
    "login" => array(
        "routerClass" => "User",
        "requestKeys" => array(
            "POST" => array("userEmail", "userPassword"),
        ),
    ),
    "logout" => array(
        "routerClass" => "Logout",
        "requestKeys" => null,
    ),
    "products" => array(
        "routerClass" => "Products",
        "requestKeys" => null,
    ),
    "product" => array(
        "routerClass" => "Product",
        "requestKeys" => array(
            "GET" => array("ID"),
            "POST" => array("Title", "Description", "ShortDescription", "Price", "DiscountPrice"),
        ),
    ),
    "product-delete" => array(
        "routerClass" => "ProductRemove",
        "requestKeys" => array(
            "GET" => array("ID"),
            "POST" => null,
        ),
    ),
    "app" => array(
        "routerClass" => "About",
        "requestKeys" => null,
    ),
);
