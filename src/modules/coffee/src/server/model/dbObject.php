<?php

abstract class DBObject {
    
    static $type_varchar;
    static $type_text;
    static $type_int;
    static $type_double;
    static $type_boolean;   
    static $type_timestamp;
    static $type_date;
    
    abstract function getTableName (); 
            
    abstract function getColumns ();
    
    function save () {
        // DB::save($this->getTableName(), $this->getId(), $this);
    }
    
    function delete () {
        // DB::delete($this->getTableName(), $this->getId());
    }
    
    function __get ($name) {
    }
    function __set ($name, $value) {
    }
    function __call ($name, $args) {
    }
    function __callStatic ($name, $args) {
    }
}

?>