<?php

require_once ('core/ddm/mysqlDataModel.php');
require_once ('core/ddm/sqLiteDataModel.php');
require_once ('core/ddm/virtualDataModel.php');

class DMCriteria {
    // operators
    public static $dm_contains = "like";
    public static $dm_equals = "=";
    public static $dm_notEquals = "!=";
    public static $dm_largerThan = ">";
    public static $dm_smallerThan = "<";
    // criteria joiners
    public static $dm_all = "all";
    public static $dm_and = "and";
    public static $dm_or = "or";
    // attributes
    public $columnName;
    public $operand;
    public $value;
    function DMCriteria ($value, $operand, $columnName = null) {
        $this->operand = $operand;
        $this->value = $value;
        $this->columnName = $columnName;
    }
    static function addAnd ($criteriaArray) {
        return new DMCriteria($criteriaArray,DMCriteria::$dm_and);
    }
    static function addOr ($criteriaArray) {
        return new DMCriteria($criteriaArray,DMCriteria::$dm_or);
    }
    static function equals ($value,$columnName) {
        return new DMCriteria($value,DMCriteria::$dm_equals,$columnName);
    }
    static function notEquals ($value,$columnName) {
        return new DMCriteria($value,DMCriteria::$dm_notEquals,$columnName);
    }
    static function larger ($value,$columnName) {
        return new DMCriteria($value,DMCriteria::$dm_largerThan,$columnName);
    }
    static function smaller ($value,$columnName) {
        return new DMCriteria($value,DMCriteria::$dm_smallerThan,$columnName);
    }
    static function like ($value,$columnName) {
        return new DMCriteria($value,DMCriteria::$dm_contains,$columnName);
    }
    static function all () {
        return new DMCriteria(null,DMCriteria::$dm_all);
    }
    function getCondition () {
        $condition = "";
        if ($this->operand == DMCriteria::$dm_or) {
            $criteria = array();
            foreach ($this->value as $criteria)
                $criteria[] = $criteria->getCondition();
            $condition .= "(".implode(" or ", $criteria).")";
        } else if ($this->operand == DMCriteria::$dm_and) {
            $criteria = array();
            foreach ($this->value as $criteria)
                $criteria[] = $criteria->getCondition();
            $condition .= "(".implode(" and ", $criteria).")";
        } else if ($this->operand == DMCriteria::$dm_equals) {
            $condition .= "'$this->columnName' = '$this->value'";
        } else if ($this->operand == DMCriteria::$dm_notEquals) {
            $condition .= "'$this->columnName' != '$this->value'";
        } else if ($this->operand == DMCriteria::$dm_largerThan) {
            $condition .= "'$this->columnName' < '$this->value'";
        } else if ($this->operand == DMCriteria::$dm_smallerThan) {
            $condition .= "'$this->columnName' > '$this->value'";
        } else if ($this->operand == DMCriteria::$dm_contains) {
            $condition .= "'$this->columnName' like '$this->value'";
        }
        return $condition;
    }
    function setCondition ($condition) {
        
    }
}

class DMQuery {
    public $orderDirection;
    public $orderColumn;
    public $criteria;
    public $table;
    function DMQuery ($table,$criteria,$orderColumn = null,$orderDirection = null) {
        $this->table = $table;
        $this->criteria = $criteria;
        $this->orderColumn = $orderColumn;
        $this->orderDirection = $orderDirection;
    }
    function setTable ($table) {
        $this->table = $table;
    }
    function getTable () {
        return $this->table;
    }
    function setCriteria ($criteria) {
        $this->criteria = $criteria;
    }
    function getCriteria () {
        return $this->criteria;
    }
    function setOrder ($orderColumn,$orderDirection) {
        $this->orderColumn = $orderColumn;
        $this->orderDirection = $orderDirection;
    }
}

interface IValidator {
    
    /* returns teck name as type of validator */
    static function getType ();
    
    /* returns true if validates and validation message if failed */
    static function validate ($data,$input);
}

abstract class XDataModel {
    
    // edit types
    public static $dm_type_text = 1;
    public static $dm_type_textbox = 2;
    public static $dm_type_121 = 3;
    public static $dm_type_12n = 4;
    public static $dm_type_n21 = 5;
    public static $dm_type_n2n = 6;
    public static $dm_type_date = 7;
    public static $dm_type_boolean = 8;
    public static $dm_type_freetext = 9;
    public static $dm_type_dropdown = 10;
    
    public static $dm_validator_none = 1;
    public static $dm_validator_text = 2;
    public static $dm_validator_alphabetic = 3;
    public static $dm_validator_numeric = 4;
    public static $dm_validator_email = 5;
    
    
    abstract function install ();
    
    // tables
    abstract function createTable ($tableName);
    abstract function deleteTable ($tableName);
    abstract function getTables ();
    abstract function getTable ($tableName);
    
    // columns
    abstract function addColumn ($tableName, $columnName, $editType, $validator=null, $position=null);
    abstract function deleteColumn ($tableName, $columnName);
    abstract function updateColumn ($tableName, $columnName, $editType, $validator=null, $position=null);
    abstract function getColumns ($tableName);
    abstract function hasColumn ($tableName, $columnName);
    
    // row operations
    abstract function insertRow ($tableName, $rowNamesValues);
    abstract function deleteRow ($tableName, $objectId);
    abstract function updateRow ($tableName, $objectId, $rowNamesValues);
    abstract function getAllRows ($tableName);
    abstract function getAllRowsAsArray ($tableName);
    abstract function getRowByObjectId ($tableName, $objectId);
    abstract function getRowByObjectIdAsArray ($tableName, $objectId);
    
    // search operations
    abstract function getResults ($query);
    abstract function getResultsAsArray ($query);
    
    // unique values
    abstract function getColumnValues ($tableName,$columnName);
}

require_once('core/ddm/mysqlDataModel.php');
require_once('core/ddm/sqLiteDataModel.php');
require_once('core/ddm/virtualDataModel.php');

?>