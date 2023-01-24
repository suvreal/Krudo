<?php

namespace controller\component;

use controller\Controller;

/**
 * Component class providing message return
 */
final class Message extends Controller
{

    /**
     * Definition of view type
     *
     * @property string $viewType
     */
    static $ViewType = "template";

    /**
     * @var null
     */
    public $Message;

    /**
     * @var null
     */
    public $MessageType;

    /**
     * @var null
     */
    public $MessageBody;

    public function __construct($MessageType, $Message, $MessageBody)
    {
        try {
            $this->setMessageType($MessageType)->setMessageText($Message)->setMessageBody($MessageBody);
            if(is_null($this->getMessageType()) ||
                is_null($this->getMessageBody()) ||
                is_null($this->getMessageText())){
                throw new \Exceptions\MessageParametersException();
            }
        }catch(\Exceptions\MessageParametersException $e){
            echo("Message: ".$e->errorMessage());
            return null;
        }
    }

    /**
     * @return string
     */
    public function getMessageType(): ?string
    {
        if(!is_null($this->MessageType))
            return $this->MessageType;
        return null;
    }

    /**
     * @return string
     */
    public function getMessageText(): ?string
    {
        if(!is_null($this->Message))
            return $this->Message;
        return null;
    }

    /**
     * @return string
     */
    public function getMessageBody(): ?string
    {
        if(!is_null($this->MessageBody))
            return $this->MessageBody;
        return null;
    }

    /**
     * Provides message for user to report about relevant info
     *
     * @param String|null $messageText
     * @return String|Message
     */
    public function setMessageText(string $messageText = null): ?Message
    {
        if(is_null($messageText)) return null;
        $this->Message = $messageText;
        return $this;
    }

    /**
     * Provides message type for user to report about relevant info
     *
     * @param String|null $messageType
     * @return Null|Message
     */
    public function setMessageType(string $messageType = null): ?Message
    {
        if(is_null($messageType)) return null;
        $this->MessageType = $messageType;
        return $this;
    }

    /**
     * Provides message body for user to report about relevant info
     *
     * @param String|null $messageBody
     * @return String|Message
     */
    public function setMessageBody(string $messageBody = null): ?Message
    {
        if(is_null($messageBody)) return null;
        $this->MessageBody = $messageBody;
        return $this;
    }

    /**
     * Component view method by @var $ViewType
     *
     * @return string|null
     */
    public function controllerView(): ?string
    {
        return(<<<EOT
            <div class="user-message">
                <span class="material-icons" title="{$this->getMessageText()}">{$this->getMessageType()}</span>
                <h3 class="user-message-title"> {$this->getMessageText()} </h3>
                <span class="user-message-content"> {$this->getMessageBody()} </span>
            </div>
        EOT);
    }



}