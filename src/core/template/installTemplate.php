<?php

require_once("core/plugin.php");
require_once("modules/admin/installerView.php");

class InstallTemplate extends XTemplate {

    function getAreas () {
        return array("center");
    }

    function render () {
	
	$installModule = new InstallView();

	// process actions

	if ($installModule->onProcess() == true) {
		
            // render page

            echo '<?xml version="1.0" encoding="ISO-8859-1" ?>'.PHP_EOL;
            echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">'.PHP_EOL;
            ?>
            <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
            <link type="text/css" href="resource/js/jquery/css/base/jquery.ui.all.css" media="all" rel="stylesheet"/>
            <script type="text/javascript" src="resource/js/jquery/js/jquery-1.9.1.js"></script>
            <script type="text/javascript" src="resource/js/jquery/js/jquery-ui-1.10.3.custom.min.js"></script>
            <script type="text/javascript" src="resource/js/main.js"></script>
            <link type="text/css" href="resource/css/main.css" media="all" rel="stylesheet"/>
            <link rel="stylesheet" href="core/template/css/install.css" type="text/css" media="screen" charset="utf-8"/>
            </head>
            <body>
            <div id="cmsBodyDiv">
            <div align="center" id="bgBottomDiv">
                    <div id="frameDiv" align="left">
                        <div id="headerDiv" class="transparent">
                    <div id="headerDivMargin">
                        <div id="logoDiv"></div>
                    </div>
                 </div>
                 <div id="contentDiv" class="roundedBorder transparent">
                    <div id="contentMargin">
                            <?php
                            $installModule->onView();
                            ?>
                    </div>
                </div>
            </div>
            </div>
            </div></body></html>
            <?php

	} else {
            $installModule->onView();
	}


    }
    
    function getStyles () {
        return array("css/default.css");
    }
}

?>