<?php

class FileSystem {
    
    static function getFilePaths ($directory) {
        $files = array();
        foreach (scandir($directory) as $file) {
            if ($file == "." || $file == "..") {
                continue;
            }
            $files []= $directory."/".$file;
        }
        return $files;
    }
    
    static function getFiles ($directory) {
        $files = array();
        foreach (scandir($directory) as $file) {
            if ($file == "." || $file == "..") {
                continue;
            }
            $files []= $file;
        }
        return $files;
    }
    
    
    
    
    

    function packDirectory ($dir) {
        $dirList = array();
        if (($handle = opendir($dir)) !== false) {
                while (false !== ($entry = readdir($handle))) {
                        if ($entry != "." && $entry != "..") {
                                if (is_dir($dir.$entry)) {
                                        $dirList[$entry] = $this->packDirectory($dir.$entry."\\");
                                } else {
                                        $dirList[$entry] = file_get_contents($dir.$entry);
                                }
                        }
                }
        }
        closedir($handle);
        return $dirList;
    }
}
