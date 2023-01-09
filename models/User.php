<?php

namespace models;

/**
 * User model class
 */
Class User extends Model{

    /**
     * A table name of object User
     */
    const TABLENAME = "tableUsers";

    /**
     * Attribute Name of User
     * 
     * @var @$Name
     */
    static $Name = 's';

    /**
     * Attribute Email of User
     * 
     * @var @$Email
     */
    static $Email = 's';

    /**
     * Attribute Phone of User
     * 
     * @var @$Phone
     */
    static $Phone = 's';

    /**
     * Attribute Password price of User
     * 
     * @var @$Password
     */
    static $Password = 's';

    /**
     * Attribute Date Created of User
     * 
     * @var @$DateCreated
     */
    static $DateCreated = 's';
   
    /**
     * Attribute User Type of User
     * 
     * @var @$UserType
     */
    static $UserType = 's';

    /**
     * Attribute Active price of User
     * 
     * @var @$Active
     */
    static $Active = 'i';

    /**
     * SaveRecord method check for validity, duplicities and password
     * 
     * @return bool|null
     */
    public function SaveRecord()
    {
        $data = (array) $this->getAttributeValues();
        if(isset($data["Email"]) && mb_strlen($data["Email"]) > 0){
            if(!is_null(self::BuildQueryByModel("*", "LIMIT 1", "Email = ?", array($data["Email"] => "s")))){ 
                throw new \Exception("User already exists");
            }
        }
        if(isset($data["Password"]) && (mb_strlen($data["Password"]) > 0)){
            $options = [
                'cost' => 12,
            ];
            $this->setAttributeValue("Password", password_hash($data["Password"], PASSWORD_BCRYPT, $options));
        }else{
            throw new \Exception("Password attribute is empty");
        }
        return parent::SaveRecord();
    }

    /**
     * Authenticate user by Email and Password properties
     * 
     * @param string $email
     * @param string $password
     * @return bool|null
     */
    public function AuthenticateCheck(string $email, string $password)
    {
        if(mb_strlen($email) > 0){
            $product = self::BuildQueryByModel("*", "LIMIT 1", "Email = ?", array($email => "s"));
            if($product->getId() > 0){
                if(mb_strlen($password) > 0){
                    if(password_verify($password, $product->ModelData->Password)){
                        return true;
                    }
                }  
            }
        }
        return null;        
    }

    /**
     * Authenticates user by setting Cookies
     * Operates with cookie UserAuthenticatedKrudo
     * 
     * @return bool|null
     */
    public function Authenticate()
    {
        $this->DeAuthenticate();
        setcookie("UserAuthenticatedKrudo", $this->getId(), time() + (86400 * 3), "/");
    }

    /**
     * DeAuthenticates user by unsetting user Cookies
     * Operates with cookie UserAuthenticatedKrudo
     * 
     * @return bool|null
     */
    public function DeAuthenticate()
    {
        if(isset($_COOKIE["UserAuthenticatedKrudo"])){
            unset($_COOKIE["UserAuthenticatedKrudo"]);
            setcookie('UserAuthenticatedKrudo', FALSE, -1, '/');
            return true;
        }else{
            return false;
        }
        return null;
    }

}