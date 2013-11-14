<?php

require_once '../../resource/js/elfinder/connectors/php/elFinder.class.php';


$dirPath = dirname($_SERVER['SCRIPT_FILENAME']);

$sitesPath = dirname(dirname(dirname($dirPath)));

$opts = array (
    'root'            => $sitesPath,
    'URL'             => "/",
    'rootAlias'       => 'site Files',
);

$fm = new elFinder($opts); 
$fm->run();

?>