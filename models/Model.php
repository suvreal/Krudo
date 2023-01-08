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
     * @var mysqli $Connection
     */
    public $Connection = null;

    public function __construct()
    {
        $conn = MySQLConnection::getInstance();
        $conn::performDatabaseConnection();
        $this->Connection = $conn::getDatabaseConnection();
      
    }

    /**
     * Prepare DB connection
     * 
     * @return \mysqli|null
     */
    public static function prepareConnection(){
        try{
            $conn = MySQLConnection::getInstance();
            $conn::performDatabaseConnection();
            return $conn::getDatabaseConnection();
        }catch(\Exception $e){
            echo("Database connect problem:". $e->getMessage());
            return null;
        }
    }

    /**
     * Singleton instance obtain
     * 
     * @param int $IDModel
     * @return null|MySQLConnection
     */
    public static function getInstance(int $IDModel = null){
        $calledClass = new \ReflectionClass(get_called_class());
        if(is_null($IDModel) || ($IDModel == 0)){
            if(class_exists($calledClass->name)){
                $className = $calledClass->name;
                $aModelInstance = new $className;
                $aModelInstance->ModelData = new stdClass();
                $aModelInstance->ModelData->ID = 0;
                self::setAttributeKeys($aModelInstance);
            }
        }
        if(!is_null($IDModel) && ($IDModel > 0)){
            if (array_key_exists($IDModel, ($calledClass->name)::$Instances)){
                return ($calledClass->name)::$Instance[$IDModel];
            }else{
                if(($results = (self::getInstance())::obtainSingleRecordByIDByModel($IDModel))){ // TODO: add static method here to obtain single record this is weird
                    $className = $calledClass->name;
                    $aModelInstance = new $className;
                    $aModelInstance->ModelData = new stdClass();
                    $aModelInstance->ModelData->ID = $results["ID"]; 
                    self::setAttributeKeys($aModelInstance);
                    $aModelInstance->setAttributeValues($results);
                    $aModelInstance::$Instances[$aModelInstance->ModelData->ID] = $aModelInstance;
                }else{
                    return null;
                }
            }
        }
        return $aModelInstance;
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
            $calledClassStatics = $calledClass->getStaticProperties();
            $bindParamValues = implode("",array_values($calledClassStatics));
            return $bindParamValues;
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
     * Obtain database single record according to model class and query
     *
     * @param string $postWhereQuery query to proceed
     * @return null|array
     */
    public static function PerformQueryByModel(string $postWhereQuery = ""){
        if(is_null($table = self::getModelTableName())){
            return null;
        }
        if($postWhereQuery != ""){
            $postWhereQuery = "WHERE ".$postWhereQuery;
        }
        try{
            $connection = self::prepareConnection();
            $result = $connection->query("SELECT * FROM {$table} {$postWhereQuery} LIMIT 1");
            $resultArray = array();
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $resultArray[] = $row;
                }
                $result = $resultArray;
            }else{
                $result = null;
            }
        }catch(\Exception $e){
            echo("Database operation problem:". $e->getMessage());
        }
        return $result;
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
        try{
            $connection = self::prepareConnection();
            $statement = $connection->prepare("SELECT * FROM {$table} WHERE ID = ? LIMIT 1");
            $statement->bind_param('i', $ID);
            $statement->execute();
            $result = $statement->get_result();
            $result = $result->fetch_array(MYSQLI_ASSOC);   
        }catch(\Exception $e){
            echo("Database operation problem:". $e->getMessage());
        }
        return $result;
    }

    // TODO: this should be prepared even though as single value
    /**
     * Obtain database single record by where query
     *
     * @param string $whereQuery
     * @return null|array
     */
    public static function ObtainSingleRecordByIDByModelByQuery(string $whereQuery)
    {  
        if(is_null($table = self::getModelTableName())){
            return null;
        }
        if($whereQuery != ""){
            $whereQuery = "WHERE ".$whereQuery;
        }
        try{
            $connection = self::prepareConnection();

            $result = $connection->query("SELECT * FROM {$table} {$whereQuery} LIMIT 1");
            if($result->num_rows == 0){
                return null;
            }

            $result = $connection->get_result();
            $result = $result->fetch_array(MYSQLI_ASSOC);   
        }catch(\Exception $e){
            echo("Database operation problem:". $e->getMessage());
        }
        return $result;
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
        try{
            $connection = self::prepareConnection();
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
        }catch(\Exception $e){
            echo("Database operation problem:". $e->getMessage());
        }
        return $result;
    }

    /**
    * Select from DB to lookup
    *
    * @param string $query
    * @return null|mysqli
    */
    public static function PerformQuery(string $query)
    {
        $connection = self::prepareConnection();
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
        if($this instanceof \models\Model){
            return $this->ModelData;
        }
    }

    /**
     * Set ID of desired object
     * 
     * @param int $recordID
     * @return Model|null
     */
    public function setId(int $recordID)
    {
        if($this instanceof \models\Model){
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
        if($this instanceof \models\Model){
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
    public function setAttributeValue(string $attributeKey, string $attributeValue)
    {
        $calledClass = new \ReflectionClass(get_called_class());
        if(class_exists($calledClass->name)){
            if(property_exists($this, $attributeKey)){
                $this->ModelData->{$attributeKey} = $attributeValue;
            }
        }
    }

    /**
     * Get single attribute value of called class
     * 
     * @param array $recordModelData
     * @return array $classOjectAttributes
     */
    public function getAttributeValue($recordModelDataKey)
    {
        if($this instanceof \models\Model){
            if(property_exists($this, $recordModelDataKey)){
                return $this->ModelData->{$recordModelDataKey};
            }
        }
    }

    /**
    * Insert into DB by model instance & data set
    * One array set at the time
    *
    * @param $data as data values to be saved
    * @return null|true
    */
    public function SaveRecords()
    {
        $data = (array) $this->getAttributeValues();
        if($this instanceof \models\Model){
            $newRecord = NULL;
            if($this->getId() == 0){
                unset($data["ID"]);
                $newRecord = TRUE;
                $queryPrefix = "INSERT INTO";
            }
            if($this->getId() > 0){
                $queryPrefix = "REPLACE INTO";
            }       
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
        
        try{
            $connectionStatement->execute();
            if($newRecord == TRUE){
                $this->setId($connectionStatement->insert_id);
                $this::$Instances[$connectionStatement->insert_id] = $this;
            }
            return $connectionStatement;
        }catch(\Exception $e){
            echo("Database operation problem:". $e->getMessage());
        }
    }

    /**
     * Performs delete of record
     * 
     * @return true|null
     */
    public function DeleteRecord()
    {
        if(is_null($table = self::getModelTableName())){
            return null;
        }
        try{
            $result = $this->Connection->query("DELETE FROM {$table} WHERE ID = {$this->getId()}");
            $this->removeInstance();
        }catch(\Exception $e){
            echo("Database operation problem:". $e->getMessage());
        }
        return $result;
    }

}