<?php

require_once 'core/plugin.php';
require_once 'core/util/captcha.php';

class ImageGenerator extends XModule {
    
    function onProcess() {

        switch (parent::getAction()) {
            case "file":
                break;
            case "pattern":
                break;
            case "gradient":
                Gradient::render($_GET['width'],$_GET['height'],$_GET['srcColor'],$_GET['dstColor'],$_GET['vertical']);
                break;
            case "captcha":
                Captcha::createImage($_GET['name']);
                break;
        }
        
    }
}

?>