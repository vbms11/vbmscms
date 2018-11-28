<?php

class ObjectUtil {
    
    function getAccessorNames () {
        
    }
    
    function getGetterNames () {
        
    }
    
    function getSetterNames () {
        
        
        
        if (stripos($method, "get") === 0) {
            $name = strtolower(substr($method, 3, 1)).substr($method, 4);
            if (isset(self::$attributes[$name])) {
                return self::$attributes[$name];
            }
            return null;
        } else if (stripos($method, "set") === 0 && isset($parameters[0])) {
            $name = strtolower(substr($method, 3, 1)).substr($method, 4);
            if (isset(self::$attributes[$name])) {
                self::$attributes[$name] = $parameters[0];
            }
        } else if (stripos($method, "has") === 0 && isset($parameters[0])) {
                }
    }
    
    function __call ($method, $parameters) {
        if (stripos($method, "get") === 0) {
            $name = strtolower(substr($method, 3, 1)).substr($method, 4);
            if (isset($this->attributes[$name])) {
                return $this->attributes[$name];
            }
            return null;
        } else if (stripos($method, "set") === 0 && isset($parameters[0])) {
            $name = strtolower(substr($method, 3, 1)).substr($method, 4);
            if (isset($this->attributes[$name])) {
                $this->attributes[$name] = $parameters[0];
            }
        } else if (stripos($method, "has") === 0 && isset($parameters[0])) {
            $name = strtolower(substr($method, 3, 1)).substr($method, 4);
            return isset($this->attributes[$name]);
        }
    }
}

?>