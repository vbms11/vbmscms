<?php

class Config {
    
    static $config = null;
    
    static function __callStatic ($name, $args) {
        
        if (stripos($name, "get") === 0) {
            
            $name = substr($name, 3);
            $lower = strtolower(substr($name, 0, 1));
            $nameLower = substr_replace($name, $lower, 0, 1);
            
            if (isset(self::$config[$nameLower])) {
                return self::$config[$nameLower];
            } else {
                throw new Exception("no config attribute named: $nameLower");
            }
        }
    }
    
    static function load () {
        
        if (is_file('config.php')) {
            include_once('config.php');
            if (isset($CONFIG)) {
                self::$config = $CONFIG;
            }
        }
    }
    
    static function getInstalled () {
        
        return self::$config['installed'];
    }
    
    static function getCurrency () {
        return self::$config['currencySymbol'];
    }

    static function getWeight () {
        return self::$config['weightUnit'];
    }
    
    static function getDBHost () {
        return self::$config['dbHost'];
    }
    
    static function getDBUser () {
        return self::$config['dbUser'];
    }
    
    static function getDBPassword () {
        return self::$config['dbPass'];
    }
    
    static function getDBName () {
        return self::$config['dbName'];
    }
    
    static function getAdminEmail () {
        return self::$config['cmsAdminEmail'];
    }
}
