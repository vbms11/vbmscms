<?php

class ImageUtil {
    
    static function crop ($imageFile,$width,$height,$outputFile,$x=null,$y=null,$w=null,$h=null) {
	
        $pathInfo = pathinfo($imageFile);
        $ext = strtolower($pathInfo['extension']);
        
        $originalImage = null;
        $originalImageSize = null;
        
        switch ($ext) {
            case "jpeg":
            case "jpg":
                $originalImage = imagecreatefromjpeg($imageFile);
                $originalImageSize = getimagesize($imageFile);
                break;
            case "png":
                $originalImage = imagecreatefrompng($imageFile);
                $originalImageSize = getimagesize($imageFile);
                break;
            case "gif":
                $originalImage = imagecreatefromgif($imageFile);
                $originalImageSize = getimagesize($imageFile);
                break;
        }
        
        $image = imagecreatetruecolor($width,$height);
        
        if ($x == null && $y == null && $w == null && $h == null) {
            
            if ($originalImageSize[0] > $originalImageSize[1]) {
                $ratio = $originalImageSize[0] / $originalImageSize[1];
                $w = $originalImageSize[0] / $ratio;
                $h = $originalImageSize[1];
                $x = ($originalImageSize[0] - $w) / 2;
                $y = 0;
            } else {
                $ratio = $originalImageSize[1] / $originalImageSize[0];
                $w = $originalImageSize[0];
                $h = $originalImageSize[1] / $ratio;
                $x = 0;
                $y = ($originalImageSize[1] - $h) / 2;
            }
        }
        
        imagecopyresampled($image,$originalImage, 0, 0, $x, $y, $width, $height, $w, $h);
        imagejpeg($image,$outputFile,90);
        imagedestroy($image);
    }
    
    static function renderImage ($imageId,$width,$height,$x=null,$y=null,$w=null,$h=null) {
        /* TODO crop with graphics context
        $image = self::getImage($imageId);
        
        if (!empty($image)) {
            
            $image = $image->image;
            
            $filename = $width.'_'.$height.'_'.$x.'_'.$y.'_'.$w.'_'.$h.'_'.$imageId.'.jpg';
            $filePath = ResourcesModel::getResourcePath("gallery/crop",$filename);
            
            if (!is_file($filePath)) {
                
                $originalImage = ResourcesModel::getResourcePath("gallery",$image);
                self::cropImage($originalImage,$width,$height,$filePath,$x,$y,$w,$h);
            }
            
            // header('Content-Description: File Transfer');
            // header('Content-Type: application/octet-stream');
            header("Content-Type: image/jpg");
            header('Content-Disposition: inline; filename="'.$filename.'"');
            //header('Content-Transfer-Encoding: binary');
            header('Connection: Keep-Alive');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            //header('Pragma: public');
            header('Content-Length: '.filesize($filePath));
            readfile($filePath);
            Context::setReturnValue("");
        }
        */
    }
}