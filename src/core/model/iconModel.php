<?php

class IconModel {

    const iconsPath = "resource/img/icons";
 
    function getIcons () {
        
        $result = Database::queryAsArray("select * from t_icon");
        
        if (empty($result)) {
            self::loadIcons();
            return self::getIcons();
        }
        
        return $result;
    }
    
    function addIcon ($file, $width, $height) {
        
        $file = mysql_real_escape_string($file);
        $width = mysql_real_escape_string($width);
        $height = mysql_real_escape_string($height);
        
        Database::query("insert into t_icon (iconfile, width, height) 
            values ('$file', '$width', '$height')");
    }
    
    function loadIcons () {
        
        // open directory
        if ($handle = opendir(self::iconsPath)) {
            
            // itterate files
            while (false !== ($filename = readdir($handle))) {
                
                $file = self::iconsPath."/".$filename;
                
                // get image info
                $result = getimagesize($file);
                if ($result) {
                    
                    // add icon
                    self::addIcon($file, $width, $height);
                }
            }
            
            closedir($handle);
        }
    }

}

?>
