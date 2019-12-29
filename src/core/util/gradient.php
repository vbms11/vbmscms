<?php

class Gradient {
    
    static function render ($width,$height,$startR,$startG,$startB,$endR,$endG,$endB,$vertical=true) {
        
        $gradient = self::createGradient($width, $height, $startR, $startG, $startB, $endR, $endG, $endB, $vertical);
        
        header("Content-Type: ".$gradient["type"]);
        header('Content-Disposition: inline; filename="'.$gradient["filename"].'"');
        header('Connection: Keep-Alive');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Content-Length: '.filesize($gradient["file"]));
        readfile($gradient["file"]);
    }
    
    static function createGradient ($width,$height,$startR,$startG,$startB,$endR,$endG,$endB,$vertical=true) {
        
        // create names and paths
        $filename = "grad-$width-$height-$startR-$startG-$startB-$endR-$endG-$endB-".($vertical ? "v" : "h").".png";
        $url = ResourcesModel::createResourceLink("cache/gradients", $filename);
        $filePath = ResourcesModel::getResourcePath("cache/gradients", $filename);
        
        // create file in cache if it dosent exist
        if (!file_exists($filePath)) {
            $img = imagecreatetruecolor($width,$height);
            self::imageGradient($img,0,0,$width,$height,$startR,$startG,$startB,$endR,$endG,$endB);
            imagepng($img,$filePath);
            imagedestroy($img);
        }
        
        // return the url to the gradient
        return array("url"=>$url, "file"=>$filePath, "filename"=>$filename, "type"=>"image/png");
    }
    
    static function imageGradient($img,$x,$y,$x1,$y1,$startR,$startG,$startB,$endR,$endG,$endB) {
        
        if($x > $x1 || $y > $y1) {
            return false;
        }
        $steps = $y1 - $y;
        for($i = 0; $i < $steps; $i++) {
            $r = $startR - ((($startR-$endR)/$steps)*$i);
            $g = $startG - ((($startG-$endG)/$steps)*$i);
            $b = $startB - ((($startB-$endB)/$steps)*$i);
            $color = imagecolorallocate($img,$r,$g,$b);
            imagefilledrectangle($img,$x,$y+$i,$x1,$y+$i+1,$color);
        }
        return true;
}



/* 
header('Content-Type: image/png');
imagepng($img);
*/
    
    
}

?>