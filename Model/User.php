<?php

namespace model;

use Exception;
use mysqli;
use mysqli_stmt;

/**
 * User model class
 */
class User extends Model
{

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
     * Checks user from cookie record
     * 
     * @return bool
     */
    public static function CheckUserActivity(): bool
    {
        return isset($_COOKIE["UserAuthenticatedKrudo"]);
    }

    /**
     * DeAuthenticates user by unsetting user Cookies
     * Operates with cookie UserAuthenticatedKrudo
     * 
     * @return bool|null
     */
    public static function DeAuthenticate(): ?bool
    {
        if (isset($_COOKIE["UserAuthenticatedKrudo"])) {
            unset($_COOKIE["UserAuthenticatedKrudo"]);
            setcookie('UserAuthenticatedKrudo', FALSE, -1, '/');
            return true;
        }
        return false;
    }

    /**
     * SaveRecord method check for validity, duplicities and password
     *
     * @return mysqli_stmt|false
     * @throws Exception
     */
    public function SaveRecord(): ?mysqli_stmt
    {
        $data = (array) $this->getAttributeValues(); // TODO: getAttributeValuesArray
        if (isset($data["Email"]) && mb_strlen($data["Email"]) > 0) {
            if (!is_null(self::BuildQueryByModel(
                "*",
                "LIMIT 1",
                "Email = ?",
                "s", array($data["Email"])))
            ) {
                throw new Exception("User already exists");
            }
        }
        if (isset($data["Password"]) && (mb_strlen($data["Password"]) > 0)) {
            $this->setAttributeValue(
                "Password",
                password_hash($data["Password"],
                    PASSWORD_BCRYPT,
                    array('cost' => 12))
            );
        } else {
            throw new Exception("Password attribute is empty");
        }
        return parent::SaveRecord();
    }

    /**
     * Authenticate user by Email and Password properties
     * 
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function AuthenticateCheck(string $email, string $password): bool
    {

        if (mb_strlen($email) <= 0) {
            return false;
        }

        $product = self::BuildQueryByModel(
            "*",
            "LIMIT 1",
            "Email = ?",
            "s",
            array($email)
        );

        if (is_null($product) || $product[0]->getId() <= 0) {
            return false;
        }

        $this->setAttributeValues((array)$product[0]->ModelData);
        $this->setId($product[0]->getId());
        return password_verify($password, $product[0]->ModelData->Password);

    }

    /**
     * Authenticates user by setting Cookies
     * Operates with cookie UserAuthenticatedKrudo
     * 
     * @return void
     */
    public function Authenticate(): void
    {
        self::DeAuthenticate();
        setcookie("UserAuthenticatedKrudo", $this->getId(), time() + (86400 * 3), "/");
    }
}
