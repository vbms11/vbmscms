<?php

class Config {
    
    static $installed = false;
    static $config = null;
    
    static function __callStatic ($name, $args) {
        if (stripos($name, "get") === 0) {
            $name = strstr($name, 3);
            $name = substr_replace($name, strtolower(strstr($name, 0,1)), 0, 1);
            echo $name;
            if (isset(self::$config[$name])) {
                return self::$config[$name];
                echo self::$config[$name];
                exit;
            }
        }
        return self::$name();
    }
    
    static function load () {
        if (include_once('config.php')) {
            if (isset($CONFIG)) {
                self::$config = $CONFIG;
                self::$installed = true;
            }
        }
    }
    
    static function getInstalled () {
        
        return self::$installed;
    }
    
    static function getDbInstalled () {
        
        
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
