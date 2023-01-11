<?php


namespace models;

use db\MySQLConnection;
use stdClass;

/**
 * Performs general tasks towards database such as insert, select, delete, update
 */
Class Model{

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
     * Contains MySQLI object to perform database connection
     * 
     * @var \mysqli $Connection
     */
    public $Connection = null;

    public function __construct(\mysqli $connection)
    {
        $this->Connection = $connection;
    }

    /**
     * Singleton instance obtain
     * 
     * @param int $IDModel
     * @return null|MySQLConnection
     */
    public static function getInstance(int $IDModel = null){
        $calledClass = new \ReflectionClass(get_called_class());
        if((is_null($IDModel) || $IDModel == 0) && class_exists($calledClass->name)){
            $className = $calledClass->name;
            $aModelInstance = new $className(MySQLConnection::getDatabaseConnection());
            $aModelInstance->ModelData = new stdClass();
            $aModelInstance->ModelData->ID = 0;
            self::setAttributeKeys($aModelInstance);
            return $aModelInstance;
        }
        if(!is_null($IDModel) && ($IDModel > 0)){
            if (array_key_exists($IDModel, ($calledClass->name)::$Instances)){
                return ($calledClass->name)::$Instances[$IDModel];
            }else{
                if($results = (self::getInstance())::obtainSingleRecordByIDByModel($IDModel)){
                    $className = $calledClass->name;
                    $aModelInstance = new $className(MySQLConnection::getDatabaseConnection());
                    $aModelInstance->ModelData = new stdClass();
                    $aModelInstance->ModelData->ID = $results["ID"]; 
                    self::setAttributeKeys($aModelInstance);
                    $aModelInstance->setAttributeValues($results);
                    $aModelInstance::$Instances[$aModelInstance->ModelData->ID] = $aModelInstance;
                    return $aModelInstance;
                }else{
                    return null;
                }
            }
        }
    }

    /**
     * Get all instances
     * 
     * @return array $instances
     */
    public static function getAllInstances(){
        return self::$Instances;
    }

    /**
     * Set attribute property keys for created model object
     * 
     * @param Model $modelInstance
     * @return array $classOjectAttributes
     */
    public static function setAttributeKeys(Model $modelInstance)
    {
        $calledClass = new \ReflectionClass(get_class($modelInstance));
        if(class_exists($calledClass->name)){
            foreach(array_keys($calledClass->getStaticProperties()) as $propertyKey){               
                $modelInstance->ModelData->{$propertyKey} = "";
            }
        }
    }

    /**
     * Obtains called model bind parans
     * 
     * @return string $bindParamValues
     */
    public static function getModelBindParams()
    {
        $calledClass = new \ReflectionClass(get_called_class());
        if(class_exists($calledClass->name)){
            return implode("",array_values($calledClass->getStaticProperties()));
        }
        return null;
    }

    /**
     * Obtains called model bind parans
     * 
     * @param array $dataCount
     * @return string $bindCharacters
     */
    public static function getModelBindCharacters(int $dataCount)
    {
        $bindCharacters = "";
        $j = $dataCount;
        for($i=0;$i<$j;$i++){
            $bindCharacters .= (($bindCharacters) ? ",?" : "?");
        }
        return $bindCharacters;
    }

    /**
     * Obtains table name of called class
     * 
     * @return string $tablename
     */
    public static function getModelTableName()
    {
        $calledClass = new \ReflectionClass(get_called_class());
        if(class_exists($calledClass->name)){
            $tablename = ($calledClass->name)::TABLENAME;
            return $tablename;
        }       
        return null;
    }
     
    /**
     * Obtain database single record by ID and model class
     *
     * @param int $ID as data values to be saved
     * @return null|array
     */
    public static function ObtainSingleRecordByIDByModel(int $ID)
    {
        if(is_null($table = self::getModelTableName())){
            return null;
        }
        $connection = MySQLConnection::getDatabaseConnection();
        $statement = $connection->prepare("SELECT * FROM {$table} WHERE ID = ? LIMIT 1");
        $statement->bind_param('i', $ID);
        $statement->execute();
        $result = $statement->get_result();
        $result = $result->fetch_array(MYSQLI_ASSOC);   
        return $result;
    }

    /**
     * Obtain database single record by where query
     *
     * @param string $attributeSelect
     * @param string $queryTail
     * @param string $whereQuery
     * @param array $bindValues
     * @return null|array
     */
    public static function BuildQueryByModel(string $attributeSelect, string $queryTail = "", string $whereQuery = "", string $bindTypes = null, array $bindValues = null)
    {
        if(!is_null($bindValues) && ($whereQuery == "")){
            return null;
        }   

        if($whereQuery != ""){
            $whereQuery = "WHERE ".$whereQuery;
        }
        if($attributeSelect == ""){
            $attributeSelect = "*";
        }

        if(is_null($table = self::getModelTableName())){
            return null;
        }
                
        $connection = MySQLConnection::getDatabaseConnection();
        if(!is_null($bindTypes)){
            $statement = $connection->prepare("SELECT {$attributeSelect} FROM {$table} {$whereQuery} {$queryTail}");
            $statement->bind_param($bindTypes, ...$bindValues);
            $statement->execute();
            $statement = $statement->get_result();     
            if($statement && $statement->num_rows > 0){
                $returnInstances = array();
                while($row = $statement->fetch_assoc()) {
                    $returnInstances[] = self::getInstance($row["ID"]);
                }
                return $returnInstances;
            }
        }else{
            $result = $connection->query("SELECT {$attributeSelect} FROM {$table} {$whereQuery} {$queryTail}");
            $returnInstances = array();
            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
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
    public static function ObtainAllRecordsByModel(string $postWhereQuery = "", bool $returnObjects = null)
    {
        if(is_null($table = self::getModelTableName())){
            return null;
        }
        if($postWhereQuery != ""){
            $postWhereQuery = "WHERE ".$postWhereQuery;
        }
        $connection = MySQLConnection::getDatabaseConnection();
        $result = $connection->query("SELECT * FROM {$table} {$postWhereQuery}");
        $resultArray = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if(($returnObjects == TRUE)){
                    $resultArray[] = self::getInstance(intval($row["ID"]));
                }else{
                    $resultArray[] = $row;
                }
                
            }
            $result = $resultArray;
        }else{
            $result = null;
        }
        return $result;
    }

    /**
    * Select from DB to lookup
    *
    * @param string $query
    * @return null|\mysqli
    */
    public static function PerformQuery(string $query)
    {
        $connection = MySQLConnection::getDatabaseConnection();
        $result = $connection->query($query);
        if($result->num_rows > 0){
            return $result;
        }else{
            return null;
        }
    }

    /**
     * Removes instance of deleted record or non-existent record in database
     * 
     * @return void
     */
    public function removeInstance()
    {  
        unset(self::$Instances[$this->getId()]);
    }

    /**
     * Get attribute values of called class
     * 
     * @param array $recordModelData
     * @return array $classOjectAttributes
     */
    public function getAttributeValues()
    {
        return $this->ModelData;
    }

    /**
     * Set ID of desired object
     * 
     * @param int $recordID
     * @return int|null
     */
    public function setId(int $recordID)
    {
        if(property_exists($this, "ModelData")){
           return $this->ModelData->ID = $recordID;
        }
        return null;
    }

    /**
     * Get ID of desired object
     * 
     * @param int $recordID
     * @return Model|null
     */
    public function getId()
    {
        if(property_exists($this->ModelData, "ID")){
            return $this->ModelData->ID;
        }
        return null;
    }

    /**
     * Set attribute property keys for created model object
     * 
     * @param array $attributeDataToSave
     * @return Model $ModelData
     */
    public function setAttributeValues(array $attributeDataToSave)
    {
        $calledClass = new \ReflectionClass(get_called_class());
        if(class_exists($calledClass->name)){
            foreach(array_keys($calledClass->getStaticProperties()) as $propertyKey){
                if(array_key_exists($propertyKey, $attributeDataToSave)){
                    $this->ModelData->{$propertyKey} = $attributeDataToSave[$propertyKey];
                }
            }
        }
    }

    /**
     * Set attribute property keys for created model object
     * 
     * @param string $attributeKey
     * @param string $attributeValue
     * @return Model $ModelData
     */
    public function setAttributeValue(string $attributeKey, $attributeValue)
    {
        if(property_exists($this, $attributeKey)){
            $this->ModelData->{$attributeKey} = $attributeValue;
        }
    }

    /**
     * Get single attribute value of called class
     * 
     * @param string $recordModelDataKey
     * @return string|int $classOjectAttributes
     */
    public function getAttributeValue(string $recordModelDataKey)
    {
        if(property_exists($this, $recordModelDataKey)){
            return $this->ModelData->{$recordModelDataKey};
        }
    }

    /**
    * Insert into DB by model instance & data set
    * One array set at the time
    *
    * @param $data as data values to be saved
    * @return null|true
    */
    public function SaveRecord()
    {
        $data = (array) $this->getAttributeValues();
        $newRecord = NULL;
        if($this->getId() == 0){
            unset($data["ID"]);
            $newRecord = TRUE;
            $queryPrefix = "INSERT INTO";
        }
        if($this->getId() > 0){
            $queryPrefix = "REPLACE INTO";
        }
      
        $arrayKeys = implode(",", array_keys($data));      
        if(is_null($bindCharacters = self::getModelBindCharacters(count($data)))){
            return null;
        }
        if(is_null($bindParams = self::getModelBindParams())){
            return null;
        }
        if(is_null($table = self::getModelTableName())){
            return null;
        }

        if($this->getId() > 0){
            $bindParams = "i".$bindParams;
        }    

        $connectionStatement = $this->Connection->prepare("{$queryPrefix} {$table} ({$arrayKeys}) VALUES ({$bindCharacters})");
        $connectionStatement->bind_param($bindParams, ...array_values($data));
        
        $connectionStatement->execute();
        if($newRecord == TRUE){
            $this->setId($connectionStatement->insert_id);
            $this::$Instances[$connectionStatement->insert_id] = $this;
        }
        return $connectionStatement;
   
    }

    /**
     * Performs delete of record
     * 
     * @return false|null
     */
    public function DeleteRecord()
    {
        if(is_null($table = self::getMOdelTableName())){
            return null;
        }
        if($this->getId() <= 0){
            return null;
        }
        $ID = $this->getId();
        $connection = MySQLConnection::getDatabaseConnection();
        $statement = $connection->prepare("DELETE FROM {$table} WHERE ID = ?");
        $statement->bind_param('i', $ID);
        $statement->execute();
        $result = $statement->get_result();
        return $result;  
    }

}