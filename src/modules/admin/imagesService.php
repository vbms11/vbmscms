<?php

require_once 'core/plugin.php';
require_once 'core/util/captcha.php';

class ImageGenerator extends XModule {
    
    function onProcess() {

        switch (parent::getAction()) {
            case "gallery":
                GalleryModel::renderImage(parent::get('image'),parent::get('width'),parent::get('height'),parent::get('x'),parent::get('y'),parent::get('w'),parent::get('h'));
                break;
            case "file":
                break;
            case "pattern":
                break;
            case "gradient":
                $vertical = true;
                if (isset($_GET['vertical'])) {
                    $vertical = $_GET['vertical'];
                }
                Gradient::render($_GET['width'],$_GET['height'],$_GET['startR'],$_GET['startG'],$_GET['startB'],$_GET['endR'],$_GET['endG'],$_GET['endB'],$vertical);
                break;
            case "captcha":
                Captcha::createImage($_GET['name']);
                break;
        }
        
    }
}

?>