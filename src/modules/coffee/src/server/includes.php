<?php

class Requirements {
    
    static $physicalPath = null;
    
    static function getPhysicalPath () {
        if (self::$physicalPath == null) {
            self::$physicalPath = dirname(dirname(__FILE__));
        }
        return self::$physicalPath;
    }
    
    static function load ($requirements) {
        if (is_array($requirements)) {
            foreach ($requirements as $requirement) {
                self::load($requirement);
            }
        } else {
            echo $requirements."<br/>";
            if (!include_once(self::getPhysicalPath().DIRECTORY_SEPARATOR.$requirements)) {
                CoffeeDevice::error(CoffeeDevice::error_include, "Could not include file: '$requirements'");
            }
        }
    }
    
}

Requirements::load(array(
    
    "server/core/translations.php",
    "server/core/errorHandler.php", 
    "server/core/coffeeDevice.php", 
    "server/core/configLoader.php", 
    "server/core/plugin.php", 
    "server/core/log.php", 
    "server/core/request.php", 
    
    
    "server/model/db.php",
    "server/model/dbObject.php",
    "server/model/dbDataSource.php",
    
    "server/util/common.php", 
    
    "server/core/session.php", 
    "server/controller/userController.php", 
    "server/controller/sessionController.php", 
    
    "server/factory/viewFactory.php", 
    "server/factory/controllerFactory.php", 
    
    "server/model/mappingLoader.php",
    "server/model/modelFactory.php",
    
    "server/ui/uiView.php", 
    "server/ui/ui.php"
));

?>