<?php

class VideoModel {
    
    static function createVideo () {
        
    }
    
    static function getVideo ($id) {
        $id = Database::escape($id);
        return Database::queryAsObject("select * from t_video where id = '$id'");
    }
    
    static function listVideos ($albumId) {
        $albumId = Database::escape($albumId);
        return Database::queryAsArray("select * from t_video v where v.pageid = '$albumId'");
    }
    
    static function deleteVideo ($id) {
        $video = self::getVideo($id);
        unlink(ResourcesModel::getResourcePath("video",$video->file));
        unlink(ResourcesModel::getResourcePath("video/poster",$video->image));
        $id = Database::escape($id);
        Database::query("delete from t_video where id = '$id'");
    }
    
    function updateVideo ($id, $titel, $description) {
        $id = Database::escape($id);
        $title = Database::escape($title);
        $description = Database::escape($description);
        Database::query("update t_gallery_image set title='$title' image='$image' description='$description' where id='$id'");
    }
    
    static function uploadImage ($inputName,$category) {
        
        $imageId = null;
        $allowedExtensions = array("jpeg", "jpg", "png", "gif");
        $sizeLimit = 5 * 1024 * 1024;
        
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload(ResourcesModel::getResourcePath("gallery/new"));
        
        if (isset($result['success']) && $result['success']) {
            
            $filename = $result['filename'];
            $newFilename = self::getNextFilename();
            $filePathFull = ResourcesModel::getResourcePath("gallery/new",$filename);
            
            self::cropImage($filePathFull,self::bigWidth,self::bigHeight,ResourcesModel::getResourcePath("gallery",$newFilename));
            self::cropImage($filePathFull,self::smallWidth,self::smallHeight,ResourcesModel::getResourcePath("gallery/small",$newFilename));
            self::cropImage($filePathFull,self::tinyWidth,self::tinyHeight,ResourcesModel::getResourcePath("gallery/tiny",$newFilename));
            
            $imageId = self::addImage($category,$newFilename,"","");
            
            unlink($filePathFull);
            unset($result['filename']);
        }
        
        // to pass data through iframe you will need to encode all html tags
        echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
        return $imageId;
    }
    
    static function getNextFilename ($ext = "jpg") {
        $filename = null;
        do {
            $filename = Common::randHash(32, false).".".$ext;
            $filename = Database::escape($filename);
            $result = Database::queryAsObject("select 1 as taken from t_gallery_image where image = '$filename'");
        } while (!empty($result) && $result->taken == "1");
        return $filename;
    }
    
    static function renderImage ($imageId,$width,$height,$x=null,$y=null,$w=null,$h=null) {
        
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
        
    }
    
    /**
     * video album
     */
    
    function createVideoAlbum ($name) {
        
        $name = Database::escape($name);
        $siteId = Database::escape($siteId);
        Database::query("insert into t_video_album (siteid, name) values ('$siteId','$name')");
    }
    
    function listVideoAlbum ($siteId) {
        
        Database::escape($siteId);
        return Database::queryAsArray("select * from t_video_album where siteid = '$siteId'");
    }
    
    function editVideoAlbum ($id,$name) {
        
        $id = Database::escape($id);
        $name = Database::escape($name);
        Database::query("update t_video_album set name = '$name' where id = '$id'");
    }
    
    function deleteVideoAlbum ($albumId) {
        
        $videos = self::listVideos($albumId);
        foreach ($videos as $pos => $video) {
            self::deleteVideo($video->id);
        }
        Database::query("delete t_video_album where id = '$albumId'");
    }
}
