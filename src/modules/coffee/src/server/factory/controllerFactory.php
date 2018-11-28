<?php

class ControllerFactory {
    
    public $model = array();
    
    function get ($name) {
        
        $objName = $name."Controller";
        $className = strtoupper($objName.substr(0,1)).$objName.substr(1,0);
        Requirements::load("controller/{$className}.php");
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