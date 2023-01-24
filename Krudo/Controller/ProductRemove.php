<?php

namespace Controller;

final Class ProductRemove extends Controller
{
    

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
            try {
                if (!\Model\Product::doesRecordExists($_GET["ID"])){
                    throw new \Exceptions\UserDeletionIDNull();
                }
            }catch(\Exceptions\UserDeletionIDNull $e){
                echo("Message: ". $e->errorMessage($_GET["ID"]));
            }
            if (\Model\Product::getInstance(intval($_GET["ID"]))->DeleteRecord()) {
                Router::routeHeader("/products");
            } else {
                $this->ResultMessageState = TRUE;
                $this->ResultMessage["title"] = "Error occurred while deletion";
                $this->ResultMessage["content"] = "Try operation later or contact administrator";
            }
        }else{
            Router::routeHeader("/products");
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
                <span class="material-icons" title="add new product">warning</span>
                <h3 class="user-message-title"> {$this->ResultMessage['title']} </h3>
                <span class="user-message-content"> {$this->ResultMessage['content']} </span>
            </div>
            EOT);    
        }
        return null;
    }


}