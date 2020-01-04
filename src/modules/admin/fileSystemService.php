<?php

require_once 'core/plugin.php';
include_once 'resource/js/elfinder/php/elFinderConnector.class.php';
include_once 'resource/js/elfinder/php/elFinder.class.php';
include_once 'resource/js/elfinder/php/elFinderVolumeDriver.class.php';
include_once 'resource/js/elfinder/php/elFinderVolumeLocalFileSystem.class.php';

function fileSystemServiceAccessControl ($attr, $path, $data, $volume) {
    return strpos(basename($path), '.') === 0       // if file/folder begins with '.' (dot)
        ? !($attr == 'read' || $attr == 'write')    // set read+write to false, other (locked+hidden) set to true
        :  null;                                    // else elFinder decide it itself
}

class FileSystemService extends XModule {
    
    function onProcess () {
        
        $opts = null;
        
        switch (parent::getAction()) {
            
            case "www":
                if (Context::hasRole("filesystem.all")) {
                    $opts = array (
                        'driver'        => 'LocalFileSystem',   // driver for accessing file system (REQUIRED)
                        'path'          => Resource::getResourcePath("www"),    // path to root directory
                        'URL'           => Resource::createResourceLink("www"), // root directory URL
                        'alias'         => 'WWW Files',       // display this instead of root directory name
                        'accessControl' => 'fileSystemServiceAccessControl'
                    );
                }
                break;
            case "user":
                if (Context::hasRole("filesystem.user")) {
                    $userHome = Context::getUserHome();
                    if ($userHome != null) {
                        $opts = array (
                            'driver'        => 'LocalFileSystem',   // driver for accessing file system (REQUIRED)
                            'path'          => Resource::getResourcePath($userHome),    // path to root directory
                            'URL'           => Resource::createResourceLink($userHome), // root directory URL
                            'alias'         => 'User Files',       // display this instead of root directory name
                            'accessControl' => 'fileSystemServiceAccessControl'
                        );
                    }
                }
                break;
            case "all":
                if (Context::hasRole("filesystem.all")) {
                    $opts = array (
                        'driver'        => 'LocalFileSystem',   // driver for accessing file system (REQUIRED)
                        'path'          => Resource::getResourcePath(),    // path to root directory
                        'URL'           => Resource::createResourceLink(), // root directory URL
                        'alias'         => 'All Files',       // display this instead of root directory name
                        'accessControl' => 'fileSystemServiceAccessControl'
                    );
                }
                break;
            case "module":
                if (Context::hasRole("filesystem.all")) {
                    $opts = array (
                        'driver'        => 'LocalFileSystem',   // driver for accessing file system (REQUIRED)
                        'path'          => Resource::getResourcePath("module/".Common::hash($_GET['id'],false,false)),    // path to root directory
                        'URL'           => Resource::createResourceLink("module/".Common::hash($_GET['id'],false,false)), // root directory URL
                        'alias'         => 'Module Files',       // display this instead of root directory name
                        'accessControl' => 'fileSystemServiceAccessControl'
                    );
                }
                break;
            case "template":
                if (Context::hasRole("filesystem.all")) {
                    $template = TemplateModel::getTemplate($_GET["id"]);
                    $opts = array (
                        'driver'        => 'LocalFileSystem',   // driver for accessing file system (REQUIRED)
                        'path'          => Resource::getResourcePath("template/".$template->path),    // path to root directory
                        'URL'           => Resource::createResourceLink("template/".$template->path), // root directory URL
                        'alias'         => 'Template Files',       // display this instead of root directory name
                        'accessControl' => 'fileSystemServiceAccessControl'
                    );
                }
                break;
            case "company":
                if (Context::hasRole("filesystem.company")) {
                    $opts = array (
                        'driver'        => 'LocalFileSystem', 
                        'path'          => Resource::getResourcePath("company/".Common::hash($_GET['id'],false,false)),    // path to root directory
                        'URL'           => Resource::createResourceLink("company/".Common::hash($_GET['id'],false,false)), // root directory URL
                        'alias'         => 'Company Files', 
                        'accessControl' => 'fileSystemServiceAccessControl'
                    );
                }
                break;
        }
        
        if ($opts != null) {
            $opts = array(
                'roots' => array(
                    $opts
                )
            ); 
            error_reporting(E_ERROR);
            $connector = new elFinderConnector(new elFinder($opts));
            $connector->run();
        }
        Context::setReturnValue("");
        
    }
    
    function onView () {
        
    }
    
    function getRoles () {
        return array("filesystem.all","filesystem.user","filesystem.www","filesystem.www");
    }
    
}

?>