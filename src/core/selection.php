<?php

class Selection {
    
    private $attributes = array();
    
    function set ($name, $value) {
        
        $this->attributes[$name] = $value;
    }
    
    function get ($name) {
        
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }
        return null;
    }
    
    public function __get ($name) {
        
        return $this->get($name);
    }
    
    public function __set ($name, $value) {
        
        $this->set($name, $value);
    }
    
}

?>