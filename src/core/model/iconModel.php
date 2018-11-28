<?php

class IconModel {

    const iconsPath = "resource/img/icons";
 
    static function getIcons () {
        
        $result = Database::queryAsArray("select * from t_icon");
        
        if (empty($result)) {
            self::loadIcons();
            return self::getIcons();
        }
        
        return $result;
    }
    
    static function addIcon ($file, $width, $height) {
        
        $file = Database::escape($file);
        $width = Database::escape($width);
        $height = Database::escape($height);
        
        Database::query("insert into t_icon (iconfile, width, height) 
            values ('$file', '$width', '$height')");
    }
    
    static function loadIcons () {
        
        // open directory
        if ($handle = opendir(self::iconsPath)) {
            
            // itterate files
            while (false !== ($filename = readdir($handle))) {
                
                $file = self::iconsPath."/".$filename;
                
                // get image info
                $result = getimagesize($file);
                if ($result) {
                    
                    // add icon
                    self::addIcon($file, $result[0], $result[1]);
                }
            }
            
            closedir($handle);
        }
    }

}

?>
