<?php

abstract class UIView {
    
    public $parent = null;
    
    abstract function view ();
    
    function process () {
    }
    
    function link ($view, $params) {
        
    }
    
    function getParent () {
        
    }
    
    function getChildren () {
        
    }
}

?>