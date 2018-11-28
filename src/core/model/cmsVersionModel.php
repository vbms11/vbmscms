<?php

class CmsVersionModel {
    
    static function getCmsVersion () {
        
        $versoin = Database::escape(Config::getVersion());
        return Database::queryAsObject("select * from t_cms_version where number = '$versoin'");
    }
    
    static function isModelInstalled () {
        
        return self::getCmsVersion() != null;
    }
    
}

?>