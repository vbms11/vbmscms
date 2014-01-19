<?php

include_once '../resource/js/elfinder/php/elFinderConnector.class.php';
include_once '../resource/js/elfinder/php/elFinder.class.php';
include_once '../resource/js/elfinder/php/elFinderVolumeDriver.class.php';
include_once '../resource/js/elfinder/php/elFinderVolumeLocalFileSystem.class.php';

function fileSystemServiceAccessControl ($attr, $path, $data, $volume) {
    return strpos(basename($path), '.') === 0       // if file/folder begins with '.' (dot)
        ? !($attr == 'read' || $attr == 'write')    // set read+write to false, other (locked+hidden) set to true
        :  null;                                    // else elFinder decide it itself
}

$opts = array (
    'driver'        => 'LocalFileSystem',   // driver for accessing file system (REQUIRED)
    'path'          => dirname(dirname($_SERVER['SCRIPT_FILENAME'])),    // path to root directory
    'URL'           => "/", // root directory URL
    'alias'         => 'All Files',       // display this instead of root directory name
    'accessControl' => 'fileSystemServiceAccessControl'
);

$opts = array(
    'roots' => array(
        $opts
    )
); 
$connector = new elFinderConnector(new elFinder($opts));
$connector->run();
?>