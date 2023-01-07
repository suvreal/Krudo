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
    private static $Instance = array();

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
            $conn::getDatabaseConnection();
            return $conn;
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

        // TODO: clean up - destruct empty or zero objects
        if(is_null($IDModel) || ($IDModel == 0)){
            if(class_exists($calledClass->name)){
                $className = $calledClass->name;
                $newModelInstance = new $className;
                $newModelInstance->ModelData = new stdClass();
                $newModelInstance->ModelData->ID = 0;
                self::setAttributeKeys($newModelInstance);

                // $className::$Instance = new $className; 
                // $className::$Instance->ModelData = new stdClass();
                // $className::$Instance->ModelData->ID = 0; 
                // self::setAttributeKeys($className::$Instance);
            }
        }

        // TODO: create and save instance as key value pair according to given model $instance = array(IDRecordOFModelClass => actuall model class instance of given ID)
        if(!is_null($IDModel) && ($IDModel > 0)){
            var_export(($calledClass->name)::$Instance);
            die;
            if (array_key_exists($IDModel, ($calledClass->name)::$Instance)){
                return ($calledClass->name)::$Instance[$IDModel];
            }else{
                if(($results = self::getInstance()->obtainSingleRecordByIDByModel($IDModel))){
                    return $results["ID"];     // TODO: fill the object properties and save it to eky value pair for model $instance which have to be saved in session              
                }else{
                    return null;
                }

                // TODO: obtain it from database records to create new
                return ($calledClass->name)::getInstance();
            }
        }

        // return $className::$Instance;
        return $newModelInstance;
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
     * Performs delete of record
     */
    public function Delete()
    {
        // TODO: after successful deletion destroy object of concrete model
    }

    /**
    * Insert into DB by model instance & data set
    *
    * @param $data as data values to be saved
    * @return null|true
    */
    public function InsertRecords()
    {
      
        $data = (array) $this->getAttributeValues();
        if($this instanceof \models\Model){
            if($this->getId() == 0){
                unset($data["ID"]);
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

        $connectionStatement = $this->Connection->prepare("{$queryPrefix} {$table} ({$arrayKeys}) VALUES ({$bindCharacters})");
        $connectionStatement->bind_param($bindParams, ...array_values($data));
        
        try{
            $connectionStatement->execute();
            $this->setId($connectionStatement->insert_id);
            return $connectionStatement;
        }catch(\Exception $e){
            echo("Database operation problem:". $e->getMessage());
        }

    }

    /**
     * Obtain database records according to model class
     * 
     * @param array $query as data values to be saved
     * @return null|array
     */
    public function ObtainAllRecordsByModel(array $queryWhere){

    }

    /**
     * Obtain database single record according to model class and query
     *
     * @param $queryWhere as data values to be saved
     * @return null|array
     */
    public function ObtainSingleRecordByModel(array $queryWhere){

    }

    /**
     * Obtain database single record by ID and model class
     *
     * @param int $ID as data values to be saved
     * @return null|array
     */
    public function ObtainSingleRecordByIDByModel(int $ID){
        
        if(is_null($table = self::getModelTableName())){
            return null;
        }

        try{
            $statement = $this->Connection->prepare("SELECT * FROM {$table} WHERE ID = ?");
            $statement->bind_param('i', $ID);
            $statement->execute();
            $result = $statement->get_result();
            $result = $result->fetch_array(MYSQLI_ASSOC);   
        }catch(\Exception $e){
            echo("Database operation problem:". $e->getMessage());
        }
        return $result;
    }

    /**
    * Insert into DB by model with data as param
    *
    * @param $data as data values to be saved
    * @return null|true
    */
    public function InsertRecordsByModel(array $data)
    {
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
   
        $connectionStatement = $this->Connection->prepare("INSERT INTO {$table} ({$arrayKeys}) VALUES ({$bindCharacters})");
        $connectionStatement->bind_param($bindParams, ...array_values($data));

        try{
            return $connectionStatement->execute();
        }catch(\Exception $e){
            echo("Database operation problem:". $e->getMessage());
        }
                
    }

    /**
    * Select from DB to lookup
    *
    * @param string $query
    * @return null|mysqli
    */
    public function PerformQuery(string $query)
    {
        $result = $this->Connection->query($query);
        if($result->num_rows > 0){
            return $result;
        }else{
            return null;
        }
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
                    if($this instanceof \models\Model){
                        $this->ModelData->{$propertyKey} = $attributeDataToSave[$propertyKey];
                    }
                }
            }
        }
    }


}