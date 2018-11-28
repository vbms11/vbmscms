<?php 

class Config {
    
    static $configFileName = "config.php";
    static $attributes = null;
    
    function __get ($name) {
        if (self::$attributes != null && isset(self::$attributes[$name])) {
            return $this->attributes;
        }
        return null;
    }
    
    static function __callStatic ($method, $parameters) {
        echo $method." - ".print_r($parameters)."<br/>";
        if (stripos($method, "get") === 0) {
            $name = strtolower(substr($method, 3, 1)).substr($method, 4);
                echo $name." - ".print_r(self::$attributes)."<br/>";
            if (isset(self::$attributes[$name])) {
                echo self::$attributes[$name];
                return self::$attributes[$name];
            }
            return null;
        } else if (stripos($method, "set") === 0 && isset($parameters[0])) {
            $name = strtolower(substr($method, 3, 1)).substr($method, 4);
            if (isset(self::$attributes[$name])) {
                self::$attributes[$name] = $parameters[0];
            }
        } else if (stripos($method, "has") === 0 && isset($parameters[0])) {
            $name = strtolower(substr($method, 3, 1)).substr($method, 4);
            return isset(self::$attributes[$name]);
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
    
    static function load () {
        if (!is_file(self::$configFileName)) {
            return false;
        }
        return include_once(self::$configFileName);
    }
    
    static function isLoaded () {
        return is_array(self::$attributes);
    }
    
    static function generateServerSecret () {
        return md5(rand());
    }
    
    static function generateServerKeyPair () {
        $pair = array();
        return $pair;
    }
    
    static function write ($database,$hostname,$username,$password, $email) {
        
        $domainName = $_SERVER['HTTP_HOST'];
        if (strpos($domainName, "www." === 0)) {
            $domainName = substr($hostName, 4);
        }
        $serverSecret = self::generateServerSecret();
        $serverKeyPair = "";
        $serverPublicKey = "";
        $serverPrivateKey = "";
        
        $config  = '<?php'.PHP_EOL;
        // database config
        $config .= 'Config::attributes = array('.PHP_EOL;
        $config .= PHP_EOL;
        $config .= "\t/* Application Information */".PHP_EOL;
        $config .= "\t'applicationName' => 'coffeeDevice', ".PHP_EOL;
        $config .= "\t'applicationVersion' => '0.1', ".PHP_EOL;
        $config .= "\t'applicationLicese' => '', ".PHP_EOL;
        $config .= "\t'applicationSecureLink' => true, ".PHP_EOL;
        $config .= "\t'applicationMainDomain' => '$domainName', ".PHP_EOL;
        $config .= "\t'applicationAdminEmail' => '$domainName', ".PHP_EOL;
        $config .= PHP_EOL;
        $config .= "\t/* Database Settings */".PHP_EOL;
        $config .= "\t'dbName' => '$database', ".PHP_EOL;
        $config .= "\t'dbHost' => '$hostname', ".PHP_EOL;
        $config .= "\t'dbUser' => '$username', ".PHP_EOL;
        $config .= "\t'dbPass' => '$password', ".PHP_EOL;
        $config .= "\t'dbTablePrefix' => 't_', ".PHP_EOL;
        $config .= PHP_EOL;
        $config .= "\t/* Session Settings */".PHP_EOL;
        $config .= "\t'sessionExpireTime' => '60', ".PHP_EOL;
        $config .= PHP_EOL;
        $config .= "\t/* Date Format */".PHP_EOL;
        $config .= "\t'dbDateFormat' => '', ".PHP_EOL;
        $config .= "\t'phpDateFormat' => '', ".PHP_EOL;
        $config .= "\t'jsDateFormat' => '', ".PHP_EOL;
        $config .= PHP_EOL;
        $config .= "\t/* Folder Paths */".PHP_EOL;
        $config .= "\t'resourcePath' => 'data', ".PHP_EOL;
        $config .= "\t'cachePath' => 'cache', ".PHP_EOL;
        $config .= PHP_EOL;
        $config .= "\t/* Keys */".PHP_EOL;
        $config .= "\t'serverSecret' => '$serverSecret', ".PHP_EOL;
        $config .= "\t'serverPublicKey' => '$serverPublicKey', ".PHP_EOL;
        $config .= "\t'serverPrivateKey' => '$serverPrivateKey', ".PHP_EOL;
        $config .= PHP_EOL;
        $config .= "\t/* Unit Settings */".PHP_EOL;
        $config .= "\t'weightUnit' => 'kg', ".PHP_EOL;
        $config .= "\t'weightInGram' => '1000', ".PHP_EOL;
        $config .= "\t'currencySymbol' => '&euro;', ".PHP_EOL;
        $config .= "\t'defaultLanguage' => 'en', ".PHP_EOL;
        $config .= "\t/* Unit Settings */".PHP_EOL;
        $config .= "\t'debug' => true, ".PHP_EOL;
        
        $config .= ');'.PHP_EOL;
        $config .= "?>";
        
        // write config file
        file_put_contents(self::$configFileName, $config);
    }
    
}

?>