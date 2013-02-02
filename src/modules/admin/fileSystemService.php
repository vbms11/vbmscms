<?php

require_once 'core/plugin.php';
require_once 'resource/js/elfinder/connectors/php/elFinder.class.php';

class FileSystemService extends XModule {
    
    function onProcess () {
        
        $opts = null;
        
        switch (parent::getAction()) {
            
            case "www":
                $opts = array (
                    'root'            => ResourcesModel::getResourcePath("www"),    // path to root directory
                    'URL'             => ResourcesModel::createResourceLink("www"), // root directory URL
                    'rootAlias'       => 'WWW Files',       // display this instead of root directory name
                );
                break;
            case "user":
                $userHome = Context::getUserHome();
                if ($userHome != null) {
                    $opts = array (
                        'root'            => ResourcesModel::getResourcePath($userHome),    // path to root directory
                        'URL'             => ResourcesModel::createResourceLink($userHome), // root directory URL
                        'rootAlias'       => 'User Files',       // display this instead of root directory name
                    );
                }
                break;
            case "all":
                $opts = array (
                    'root'            => ResourcesModel::getResourcePath(),    // path to root directory
                    'URL'             => ResourcesModel::createResourceLink(), // root directory URL
                    'rootAlias'       => 'All Files',       // display this instead of root directory name
                );
                break;
            case "module":
                $opts = array (
                    'root'            => ResourcesModel::getResourcePath("module/".Common::hash($_GET['id'],false,false)),    // path to root directory
                    'URL'             => ResourcesModel::createResourceLink("module/".Common::hash($_GET['id'],false,false)), // root directory URL
                    'rootAlias'       => 'Module Files',       // display this instead of root directory name
                );
                break;
            case "template":
                $opts = array (
                    'root'            => ResourcesModel::getResourcePath("template/".Common::hash($_GET['id'],false,false)),    // path to root directory
                    'URL'             => ResourcesModel::createResourceLink("template/".Common::hash($_GET['id'],false,false)), // root directory URL
                    'rootAlias'       => 'Template Files',       // display this instead of root directory name
                );
                break;
        }
        
        if ($opts != null) {
            $fm = new elFinder($opts); 
            $fm->run();
        }
        Context::returnValue("");
        
    }
    
    function onView () {
        
        switch (parent::getAction()) {
            
            default:
                $this->renderMainView();
        }
    }
    
    function getRoles () {
        return array("filesystem.all","filesystem.user","filesystem.www");
    }
    
    function renderMainView () {
        
    }
    
}

?>