<?php

class Config {
    
    static $installed = false;
    static $config = null;
    
    const installedLockFileName = "files/install/installed";
    
    static function __callStatic ($name, $args) {
        
        if (stripos($name, "get") === 0) {
            
            $name = substr($name, 3);
            $lower = strtolower(substr($name, 0, 1));
            
            $nameLower = substr_replace($name, $lower, 0, 1);
            //echo $name;
            if (isset(self::$config[$nameLower])) {
                return self::$config[$nameLower];
                //echo self::$config[$name];
                //exit;
            } else {
                throw new Exception("no config attribute named: $nameLower");
            }
        }
        //return self::$name();
    }
    
    static function load () {
        
        if (is_file('config.php')) {
            include_once('config.php');
            if (isset($CONFIG)) {
                self::$config = $CONFIG;
                if (file_exists(self::installedLockFileName)) {
                    self::$installed = true;
                }
            }
        }
    }
    
    static function deleteInstalledLockFile () {
        if (is_file(self::installedLockFileName)) {
            unlink(self::installedLockFileName);
            self::$installed = false;
        }
    }
    
    static function getInstalled () {
        
        return self::$installed;
    }
    
    static function createInstalledLockFile () {
        
        file_put_contents(self::installedLockFileName, "");
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
