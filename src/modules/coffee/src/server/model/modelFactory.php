<?php

class ModelFactory {
    
    public $model = array();
    
    function get ($name) {
        
        if (isset(self::$model[$name])) {
            return clone self::$model[$name];
        }
    }
    
    static function setModel ($model) {
        
        self::$model = $model;
    }
}

?>