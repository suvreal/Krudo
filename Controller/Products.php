<?php

namespace controller;

/**
 * Controller class which is result of undefined route by URL path name
 */
final class Products extends Controller
{

    /**
     * Definition of view type
     * 
     * @property string $viewType
     */
    static $ViewType = "template";

    /**
     * Definition of HTML Title
     * 
     * @property string $PageTitle
     */
    static $PageTitle = "Products";

    public function __construct()
    {

        if (!\Model\User::CheckUserActivity()) {
            Router::routeHeader("/login");
        }

        if (isset($_POST["searchProducts"])) {
            $this->searchProducts($_POST["searchProducts"]);
        }
    }

    /**
     * Handler for product search
     * 
     * @param string $term
     */
    public function searchProducts(string $term)
    {
        exit(json_encode(array("Result" => "OK", "Data" => $this->searchProductsQuery($term))));
    }

    /**
     * Search for product into DB
     * 
     * @param string $term - searched input by user
     */
    public function searchProductsQuery(string $term): array
    {
        $resultArray = array();
        // searches for terms inputs in database
        $results = \Model\Product::BuildQueryByModel(
            "*",
            "",
            "Title LIKE ? OR Description LIKE ?",
            "ss",
            array("%$term%", "%$term%")
        );
        if (is_array($results)) {
            foreach ($results as $result) {
                $resultArray[] = $result->ModelData;
            }
        }
        return $resultArray;
    }

    /**
     * Get all products
     * 
     * @return array
     */
    public function getAllProducts(): ?array
    {
        return \Model\Product::BuildQueryByModel("*");
    }
}
