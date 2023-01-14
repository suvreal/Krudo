<?php

namespace controller;

Class ProductRemove extends Router{
    

    /**
     * Definition of view type
     * 
     * @property string $viewType
     */
    static $ViewType = "controller";

    /**
     * Definition of HTML Title
     * 
     * @property string $PageTitle
     */
    static $PageTitle = "User remove";

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

    public function __construct()
    {
        if (isset($_GET["ID"])) {
            if (\Model\Product::getInstance(intval($_GET["ID"]))->DeleteRecord()) {
                Router::routeHeader("/products");
            } else {
                $this->ResultMessageState = TRUE;
                $this->ResultMessage["title"] = "Error occurred while deletion";
                $this->ResultMessage["content"] = "Try operation later or contact administrator";
            }
        }
    }
    
    /**
     * Controller view method by @var $ViewType
     * 
     * @return string
     */
    public function controllerView(): ?string
    {
        if (!is_null($this->ResultMessageState)){
            return(<<<EOT
            <div class="user-message">
                <h3 class="user-message-title"> {$this->Controller->ResultMessage['title']} </h3>
                <span class="user-message-content"> {$this->Controller->ResultMessage['content']} </span>
            </div>
            EOT);    
        }
        return null;
    }


}