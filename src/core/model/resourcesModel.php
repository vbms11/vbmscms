<?php

require_once 'core/common.php';

class ResourcesModel {
    
    static function getWebPath () {
        return "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/';
    }
    
    static function getBasePath () {
        return dirname($_SERVER['SCRIPT_FILENAME']).'/';
    }
    
    static function getResourcePath ($path = null, $name = null) {
        $resourcePath = ResourcesModel::getBasePath().$GLOBALS['resourcePath'];
        if ($path != null)
            $resourcePath .= $path.'/';
        if (!file_exists($resourcePath))
            mkdir($resourcePath, 0777, true);
        if ($name != null)
            $resourcePath .= $name;
        // echo "resourcePath:".$resourcePath."<br/>";
        // echo "resourcePath:".realpath($resourcePath).'/'.$name."<br/>";
        // return realpath($resourcePath).'/'.$name;
        return $resourcePath;
    }

    static function getModulePath ($moduleObj) {
        return dirname($moduleObj->include).'/';
    }

    static function createResourceLink ($resourceName=null,$fileName=null) {
        //if (!is_dir($resourceName))
        //    mkdir($resourceName);
        $link = ResourcesModel::getWebPath().$GLOBALS['resourcePath'];
        if ($resourceName != null) {
            $link .= $resourceName.'/';
        }
        if ($fileName != null) {
            $link .= $fileName;
        }
        return $link;
    }

    static function createModuleResourceLink ($moduleObj,$fileName) {
        return ResourcesModel::getModulePath($moduleObj).$fileName;
    }

    static function createTemplateResourceLink ($fileName) {
        return TemplateModel::getTemplatePath(Context::getPage()).$fileName;
    }
    
    static function onRequest ($templateObj,$moduleObjs) {
        if ($_SESSION['res.template'] != $templateObj->id) {
            $_SESSION['res.template'] = $templateObj->id;
        }
        foreach ($moduleObjs as $moduleObj) {
            $modules = $_SESSION['res.modules'];
            $hasModule = false;
            foreach ($modules as $module) {
                if ($moduleObj->id == $module) {
                    $hasModule = true;
                }
            }
            if (!$hasModule) {
                
            }
        }
    }
    
    static function downloadResource ($resourceName) {
        // check rights
        // start download
    }
    
    static function uploadResource ($postName, $path, $allowedTypes = array("jpg","jpeg","gif","png"),$maxFileSize=5242880) {
        
        $allowedTypes = implode("|", $allowedTypes);
        $rEFileTypes = "/^\.($allowedTypes){1}$/i";
        $imageName = $_FILES[$postName]['name'];
        $imagePath = ResourcesModel::getResourcePath($path, $imageName);
        if (!file_exists(dirname($imagePath)))
            @mkdir(dirname($imagePath));
        
        // move uploaded file if safe
        $isFile = is_uploaded_file($_FILES[$postName]['tmp_name']);
        if ($isFile) {
            if (preg_match($rEFileTypes, strrchr($imageName, '.'))) {
                if ($_FILES[$postName]['size'] <= $maxFileSize) {
                    $isMove = move_uploaded_file($_FILES[$postName]['tmp_name'],$imagePath);
                } else {
                    // $imageName = null;
                    echo "file larger than maximum file size (".($maxFileSize /(1024*1024))."MB)<br/>";
                }
            } else {
                echo "invalid filetype allowed filetypes are jpg jpeg gif png<br/>";
            }
        } else {
            echo "Error uploading file sorry<br/>";
        }
        return $imageName;
    }
}

?>