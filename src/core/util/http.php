<?php

class Http {
    
    function doseFileExist ($url) {
        
    }
    
    static function getContent ($url) {
        return @file_get_contents($url);
    }
    
}