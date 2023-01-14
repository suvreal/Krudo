<?php


namespace model;

use db\MySQLConnection;
use mysqli;
use mysqli_stmt;
use ReflectionClass;
use stdClass;

/**
 * Performs general tasks towards database such as insert, select, delete, update
 */
class Model
{

    /**
     * Data properties of model instance
     *
     * @var $ModelData
     */
    public $ModelData;

    /**
     * @var $Instance
     */
    private static $Instances = array();

    /**
     * Contains MySQL object to perform database connection
     *
     * @var mysqli $Connection
     */
    public $Connection = null;

    public function __construct(mysqli $connection)
    {
        $this->Connection = $connection;
    }

    /**
     * Singleton instance obtain
     *
     * @param ?int $IDModel
     *
     * @return null|Model
     */
    public static function getInstance(int $IDModel = 0): ?Model
    {
        $calledClass = new ReflectionClass(get_called_class());

        // Creating new Model instance for new record
        if ($IDModel == 0 && class_exists($calledClass->name)) {
            return self::setInstanceCore($calledClass->name, MySQLConnection::getDatabaseConnection(), $IDModel);
        }

        // Check if instance of model is already existing
        if (array_key_exists($IDModel, ($calledClass->name)::$Instances)) {
            // Instance of model exists and then is returned
            return ($calledClass->name)::$Instances[$IDModel];
        } else {
            // Instance of model is does not exist and then is prepared from database record
            if ($results = (self::getInstance())::obtainSingleRecordByIDByModel($IDModel)) {
                $aModelInstance = self::setInstanceCore(
                    $calledClass->name,
                    MySQLConnection::getDatabaseConnection(),
                    $results["ID"]
                );
                // Set obtained data from DB records into called class property values
                $aModelInstance->setAttributeValues($results);
                // Save instance as value by instance model record ID as a key and return
                $aModelInstance::$Instances[$aModelInstance->ModelData->ID] = $aModelInstance;
                return $aModelInstance;
            }
        }

        // If no instance of called model is not either available or obtainable
        return null;
    }

    /**
     * Sets particular model class properties
     *
     * @param string $calledClass
     * @param int $id
     * @param mysqli $connection
     *
     * @return Model
     */
    public static function setInstanceCore(string $calledClass, mysqli $connection, int $id = 0): Model
    {
        $aModelInstance = new $calledClass($connection);
        $aModelInstance->ModelData = new stdClass();
        $aModelInstance->ModelData->ID = $id;
        self::setAttributeKeys($aModelInstance);
        return $aModelInstance;
    }

    /**
     * Get all instances
     *
     * @return array $instances
     */
    public static function getAllInstances(): array
    {
        return self::$Instances;
    }

    /**
     * Set attribute property keys for created model object
     *
     * @param Model $modelInstance
     * @return void set $classObjectAttributes
     */
    public static function setAttributeKeys(Model $modelInstance)
    {
        $calledClass = new ReflectionClass(get_class($modelInstance));
        if (class_exists($calledClass->name)) {
            foreach (array_keys($calledClass->getStaticProperties()) as $propertyKey) {
                $modelInstance->ModelData->{$propertyKey} = "";
            }
        }
    }

    /**
     * Obtains called model bind params
     *
     * @return string $bindParamValues
     */
    public static function getModelBindParams(): ?string
    {
        $calledClass = new ReflectionClass(get_called_class());
        if (class_exists($calledClass->name)) {
            return implode("", array_values($calledClass->getStaticProperties())); // TODO: https://www.php.net/manual/en/function.str-repeat.php
        }
        return null;
    }

    /**
     * Obtains table name of called class
     *
     * @return string
     */
    public static function getModelTableName(): ?string
    {
        $calledClass = new ReflectionClass(get_called_class());
        if (class_exists($calledClass->name)) {
            return ($calledClass->name)::TABLENAME;
        }
        return null;
    }


    /**
     * Obtain database single record by ID and model class
     *
     * @param int $ID as data values to be saved
     * @return null|array
     */
    public static function ObtainSingleRecordByIDByModel(int $ID): ?array
    {
        if (is_null($table = self::getModelTableName())) {
            return null;
        }

        // TODO: 172-176 very duplicity through this doc
        $connection = MySQLConnection::getDatabaseConnection();
        $statement = $connection->prepare("SELECT * FROM $table WHERE ID = ? LIMIT 1");
        $statement->bind_param('i', $ID);
        $statement->execute();
        $result = $statement->get_result();
        return $result->fetch_array(MYSQLI_ASSOC);
    }

    /**
     *
     * Obtain database single record by where query
     *
     * @param string $attributeSelect
     * @param string $queryTail
     * @param string $whereQuery
     * @param string $bindTypes
     * @param array $bindValues
     *
     * @return null|array
     */

    public static function BuildQueryByModel(
        string $attributeSelect,
        string $queryTail = "",
        string $whereQuery = "",
        string $bindTypes = null,
        array $bindValues = array()
    ): ?array
    {

        if ($whereQuery != "") {
            $whereQuery = "WHERE " . $whereQuery;
        }

        if ($attributeSelect == "") {
            $attributeSelect = "*";
        }

        if (is_null($table = self::getModelTableName())) {
            return null;
        }

        $connection = MySQLConnection::getDatabaseConnection();
        if (!is_null($bindTypes)) {
            $statement = $connection->prepare("SELECT $attributeSelect FROM $table $whereQuery $queryTail");
            $statement->bind_param($bindTypes, ...$bindValues);
            $statement->execute();
            $statement = $statement->get_result();
            if ($statement && $statement->num_rows > 0) {
                $returnInstances = array();
                while ($row = $statement->fetch_assoc()) {
                    $returnInstances[] = self::getInstance($row["ID"]);
                }
                return $returnInstances;
            }
        } else {
            $result = $connection->query("SELECT $attributeSelect FROM $table $whereQuery $queryTail");
            $returnInstances = array();
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $returnInstances[] = self::getInstance($row["ID"]);
                }
            }
            return $returnInstances;
        }

        return null;
    }

    /**
     * Obtain database records according to model class and where string
     *
     * @param string $postWhereQuery query to proceed
     * @param bool $returnObjects query to proceed
     * @return null|array
     */
    public static function ObtainAllRecordsByModel(string $postWhereQuery = "", bool $returnObjects = null): ?array
    {
        if (is_null($table = self::getModelTableName())) {
            return null;
        }
        if ($postWhereQuery != "") {
            $postWhereQuery = "WHERE " . $postWhereQuery;
        }
        $connection = MySQLConnection::getDatabaseConnection();
        $result = $connection->query("SELECT * FROM $table $postWhereQuery");
        $resultArray = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($returnObjects) {
                    $resultArray[] = self::getInstance($row["ID"]);
                } else {
                    $resultArray[] = $row;
                }
            }
            $result = $resultArray;
        } else {
            $result = null;
        }
        return $result;
    }

    /**
     * Select from DB to lookup
     *
     * @param string $query
     * @return mysqli|bool
     */
    public static function PerformQuery(string $query): ?mysqli
    {
        $connection = MySQLConnection::getDatabaseConnection();
        $result = $connection->query($query);
        if ($result->num_rows > 0) {
            return $result;
        }
        return false;
    }

    /**
     * Get attribute values of called class
     *
     * @return stdClass
     */
    public function getAttributeValues(): stdClass
    {
        return $this->ModelData;
    }

    /**
     * Set ID of desired object
     *
     * @param int $recordID
     * @return int|null
     */
    public function setId(int $recordID): ?int
    {
        if (property_exists($this, "ModelData")) {
            return $this->ModelData->ID = $recordID;
        }
        return null;
    }

    /**
     * Get ID of desired object
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        if (property_exists($this->ModelData, "ID")) {
            return $this->ModelData->ID;
        }
        return null;
    }

    /**
     * Set attribute property keys for created model object
     * Sets Model @property $ModelData
     *
     * @param array $attributeDataToSave
     * @return void
     */
    public function setAttributeValues(array $attributeDataToSave): void
    {
        $calledClass = new ReflectionClass(get_called_class());
        if (class_exists($calledClass->name)) {
            foreach (array_keys($calledClass->getStaticProperties()) as $propertyKey) {
                if (array_key_exists($propertyKey, $attributeDataToSave)) {
                    $this->ModelData->{$propertyKey} = $attributeDataToSave[$propertyKey];
                }
            }
        }
    }

    /**
     * Set attribute property keys for created model object
     * Sets Model @property $ModelData by @param $attributeValue
     *
     * @param string $attributeKey
     * @param string $attributeValue
     * @return void
     */
    public function setAttributeValue(string $attributeKey, string $attributeValue): void
    {
        if (property_exists($this, $attributeKey)) {
            $this->ModelData->{$attributeKey} = $attributeValue;
        }
    }

    /**
     * Get single attribute value of called class
     *
     * @param string $recordModelDataKey
     *
     * @return string $classObjectAttributes
     */
    public function getAttributeValue(string $recordModelDataKey): ?string
    {
        if (property_exists($this, $recordModelDataKey)) {
            return $this->ModelData->{$recordModelDataKey};
        }
        return null;
    }

    /**
     * Insert into DB by model instance & data set
     * One array set at the time
     *
     * @return mysqli_stmt|false
     */
    public function SaveRecord(): ?mysqli_stmt
    {
        $data = (array) $this->getAttributeValues();
        $newRecord = null;
        $queryPrefix = "";
        if($this->getId() == 0){
            unset($data["ID"]);
            $newRecord = true;
            $queryPrefix = "INSERT INTO";
        }
        if($this->getId() > 0){
            $queryPrefix = "REPLACE INTO";
        }

        $arrayKeys = implode(",", array_keys($data));
        if (is_null($bindCharacters = rtrim(str_repeat("?,",count($data)), ","))) { //
            return false;
        }
        if(is_null($bindParams = self::getModelBindParams())){
            return false;
        }
        if(is_null($table = self::getModelTableName())){
            return false;
        }
        if($this->getId() > 0){
            $bindParams = "i".$bindParams;
        }


        $connectionStatement = $this->Connection->prepare("$queryPrefix $table ($arrayKeys) VALUES ($bindCharacters)");
        $connectionStatement->bind_param($bindParams, ...array_values($data));

        $connectionStatement->execute();
        if($newRecord){
            $this->setId($connectionStatement->insert_id);
            $this::$Instances[$connectionStatement->insert_id] = $this;
        }
        return $connectionStatement;
    }


    /**
     * Performs delete of record
     *
     * @return bool
     */
    public function DeleteRecord(): bool
    {

        if(!($ID = $this->getId()) || $ID <= 0){
            return false;
        }

        if (is_null($table = self::getMOdelTableName())) {
            return false;
        }

        $connection = MySQLConnection::getDatabaseConnection();
        $statement = $connection->prepare("DELETE FROM $table WHERE ID = ?");
        $statement->bind_param('i', $ID);
        $statement->execute();
        if(!$statement->get_result()){
            return true;
        }
        return false;
    }
}
