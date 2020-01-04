<?php

class VideoController {
    
    const tinyWidth = 50;
    const tinyHeight = 50;
    const smallWidth = 170;
    const smallHeight = 170;
    const bigWidth = 1000;
    const bigHeight = 1000;
    
    static function uploadVideo ($postName, $album, $title="", $description="") {
        
        $imageId = null;
        $allowedExtensions = array("avi", "mp4", "mpg");
        $sizeLimit = 128 * 1024 * 1024;
        
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload(Resource::getResourcePath("video/upload"));
        
        if (isset($result['success']) && $result['success']) {
            
            $filename = $result['filename'];
            $filePathFull = Resource::getResourcePath("video/upload",$filename);
            
            $newFilename = null;
            do {
                $newFilename = Common::randHash(32, false);
            } while (VideoModel::getVideoByFileName($filename) != null);
            $jpgFilename = $newFilename.".jpg";
            
            // convert to webm
            //VideoUtil::convertMp4toWebm($filePathFull, ResourcesModel::getResourcePath("video/webm",$newFilename.".webm"));
            
            // convert to mp4
            copy($filePathFull, Resource::getResourcePath("video/mp4",$newFilename.".mp4"));
            
            // get the first frame
            $tempFile = Resource::getResourcePath("video/temp",$jpgFilename);
            VideoUtil::extractImage($filePathFull, $tempFile, "00:00:01");
            
            // create standard images
            ImageUtil::crop($tempFile,self::bigWidth,self::bigHeight,Resource::getResourcePath("video/big",$jpgFilename));
            ImageUtil::crop($tempFile,self::smallWidth,self::smallHeight,Resource::getResourcePath("video/small",$jpgFilename));
            ImageUtil::crop($tempFile,self::tinyWidth,self::tinyHeight,Resource::getResourcePath("video/tiny",$jpgFilename));
            
            $videoId = VideoModel::createVideo($newFilename, $title, $description, Context::getUserId(), $album);
            
            // VideoUtil::extractImageInterval
            // $filePathFull,self::tinyWidth,self::tinyHeight,ResourcesModel::getResourcePath("video/tiny",$newFilename
            
            unlink($tempFile);
            unlink($filePathFull);
            unset($result['filename']);
        }
        
        // to pass data through iframe you will need to encode all html tags
        echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
        return $imageId;
    }
    

    static function deleteVideo ($id) {
        $video = VideoModel::getVideo($id);
        unlink(Resource::getResourcePath("video/big",$video->file.".jpg"));
        unlink(Resource::getResourcePath("video/small",$video->file.".jpg"));
        unlink(Resource::getResourcePath("video/tiny",$video->file.".jpg"));
        unlink(Resource::getResourcePath("video/webm",$video->file.".webm"));
        unlink(Resource::getResourcePath("video/mp4",$video->file.".mp4"));
        VideoModel::deleteVideo($id);
    }
    
    static function deleteVideoAlbum ($albumId) {
        
        $videos = VideoModel::listVideos($albumId);
        foreach ($videos as $pos => $video) {
            self::deleteVideo($video->id);
        }
    }
}