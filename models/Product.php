<?php

namespace models;

/**
 * Product model class
 */
Class Product extends Model{

    /**
     * A table name of object Product
     */
    const TABLENAME = "tableProducts";

    /**
     * Attribute Title of product
     * 
     * @var @$Title
     */
    static $Title = 's';

    /**
     * Attribute Description of product
     * 
     * @var @$Description
     */
    static $Description = 's';

    /**
     * Attribute Short description of product
     * 
     * @var @$ShortDescription
     */
    static $ShortDescription = 's';

    /**
     * Attribute Discount price of product
     * 
     * @var @$DiscountPrice
     */
    static $DiscountPrice = 'd';

    /**
     * Attribute Price of product
     * 
     * @var @$Price
     */
    static $Price = 'd';
   
}