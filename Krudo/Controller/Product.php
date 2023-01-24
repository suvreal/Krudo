<?php

namespace Controller;

/**
 * Controller class which is result of undefined route by URL path name
 */
final class Product extends Controller
{

    /**
     * Definition of view type
     * 
     * @property string $ViewType
     */
    static $ViewType = "template";

    /**
     * Definition of HTML Title
     * 
     * @property string $PageTitle
     */
    static $PageTitle = "Product";

    /**
     * Product Model object available for Product controller
     * 
     * @property $Product
     */
    public $Product = null;

    /**
     * Product result message
     * 
     * @property $ResultMessage
     * @property $ResultMessageState
     */
    public $ResultMessage = array(
        "title" => "",
        "content" => ""
    );
    public $ResultMessageState = NULL;

    public function __construct(\Model\Product $Product = null)
    {
        $this->Product = $Product;
        if (!\Model\User::CheckUserActivity()) {
            Router::routeHeader("/login");
        }

        // TODO: user getExpectedRequestKeys with additional functionality & transform it into separate called method
        if (
            isset($_POST) &&
            isset($_POST["Title"]) &&
            isset($_POST["ShortDescription"]) &&
            isset($_POST["Description"]) &&
            isset($_POST["Price"]) &&
            isset($_POST["DiscountPrice"])
        ) {

            if (isset($_POST["ID"])) {
                $ID = $_POST["ID"];
                $this->Product->setId($ID);
            }

            $dataToSave = array(
                "Title" => $_POST["Title"],
                "ShortDescription" => $_POST["ShortDescription"],
                "Description" => $_POST["Description"],
                "Price" => $_POST["Price"],
                "DiscountPrice" => $_POST["DiscountPrice"],
            );
            $this->Product->setAttributeValues($dataToSave);

            $this->Product->SaveRecord();


            if ($this->Product->getId() > 0) {
                Router::routeHeader("/products");
            } else {
                $this->ResultMessageState = TRUE;
                $this->ResultMessage["title"] = "Error occurred while record save";
                $this->ResultMessage["content"] = "Try operation later or contact administrator";
            }
        }
    }
}
