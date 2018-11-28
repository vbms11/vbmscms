<?php

class ViewFactory {
    
    public $model = array();
    
    function get ($name) {
        
        $objName = $name."View";
        $className = strtoupper($objName.substr(0,1)).$objName.substr(1);
        Requirements::load("view/{$objName}.php");
        if (class_exists($className)) {
            $class = new ReflectionClass($className);
            $instance = $class->newInstanceArgs(array());
        }
        return $instance;
    }
    
    function setModel ($model) {
        
        self::$model = $model;
    }
}

?>