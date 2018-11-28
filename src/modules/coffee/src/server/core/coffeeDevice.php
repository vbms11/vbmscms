<?php

class DeviceState {
    
    function clear () {
        
    }
    
    function addDefaultRoles () {
        
    }
    
    // location
    // product
    
}

class Device {
    
    public static $ui = null;
    public static $model = array(
        "tasks" => null, 
        "forms" => null, 
        "tables" => null, 
        "actions" => null, 
        "conditions" => null
    );
    public static $controller = array(
        "session" => null, 
        "order" => null, 
        "product" => null, 
        "user" => null
    );
    public static $factory = array(
        "controller" => null,
        "model" => null,
        "view" => null
    );
    
    public static $view = array ();
    
    public static $process = null;
    public static $state = null;
    public static $user = null;
    public static $log = null;
    
    public static $defaultLanguage = "en";
    public static $language = null;
    public static $translations = null;
    
    static function init () {
        
        // 
        $loaded = Config::load();
        
        // init language
        if (Config::isLoaded() && Config::getDefaultLanguage() != null) {
            $this->defaultLanguage = Config::getDefaultLanguage();
        }
        self::$language = self::$defaultLanguage;
        
        // init log 
        self::$log = new Log();
        self::$translations = new Translations();
        
        // init state
        self::$state = new DeviceState();
        
        // factory
        self::$factory["model"] = new ModelFactory();
        self::$factory["controller"] = new ControllerFactory();
        
        if ($loaded) {
            // init models by name
            ModelFactory::setModel(MappingLoader::load());
            foreach (self::$model as $obj => $name) {
                self::$model[$name] = ModelFactory::get($name);
            }
        }
        
        // init models by name
        //ControllerFactory::setModel(MappingLoader::load());
        $controllerFactory = self::$factory["controller"];
        foreach (self::$controller as $obj => $name) {
            self::$controller[$name] = $controllerFactory->get($name);
        }
        
        
    }
    
    static function translation ($name) {
        
        if (isset(self::$translations[$name]) && isset(self::$translations[$name][self::$language])) {
            return self::$translations[$name][self::$language];
        }
        return null;
    }
}

?>