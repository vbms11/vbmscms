<?php

class Gradient {
    
    static function render ($width,$height,$srcColor,$dstColor,$vertical = true) {
        
        // create names and paths
        $filename = "grad-$width-$height-$srcColor-$dstColor-$vertical";
        $url = ResourcesModel::createResourceLink("cache/gradients", $filename);
        $filePath = ResourcesModel::getResourcePath("cache/gradients", $filename);
        
        // create file in cache if it dosent exist
        if (!file_exists($filePath)) {
            
        }
        
        // return the url to the gradient
        return $url;
    }
}

?>