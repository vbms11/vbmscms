<?php

class VideoModel {
    
    static function createVideo ($file, $title, $description, $userId, $album) {
        $file = Database::escape($file);
        $title = Database::escape($title);
        $description = Database::escape($description);
        $userId = Database::escape($userId);
        $album = Database::escape($album);
        Database::query("insert into t_video (file,title,description,userid,album,uploaddate) values('$file','$title','$description','$userId','$album',now())");
        $result = Database::queryAsObject("select max(id) as lastid from t_video");
        return $result->lastid;
    }
    
    static function getVideoByAlbum ($album) {
        $album = Database::escape($album);
        return Database::queryAsArray("select * from t_video where album = '$album'");
    }
    
    static function getVideoByFileName ($filename) {
        $filename = Database::escape($filename);
        return Database::queryAsObject("select * from t_video where file='$filename'");
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
        $id = Database::escape($id);
        Database::query("delete from t_video where id = '$id'");
    }
    
    function updateVideo ($id, $file, $titel, $description, $album, $userId) {
        $id = Database::escape($id);
        $file = Database::escape($file);
        $title = Database::escape($title);
        $description = Database::escape($description);
        $album = Database::escape($album);
        $userId = Database::escape($userId);
        Database::query("update t_video set file='$file', title='$title', description='$description', album='$album', userid='$userId' where id='$id'");
    }
    
    /**
     * video album
     */
    
    static function createVideoAlbum ($name, $description, $siteId=null) {
        if ($siteId == null) {
            $siteId = Context::getSiteId();
        }
        $name = Database::escape($name);
        $description = Database::escape($description);
        $siteId = Database::escape($siteId);
        Database::query("insert into t_video_album (siteid, name, description) values ('$siteId','$name','$description')");
    }
    
    static function updateVideoAlbum ($id, $name, $description, $siteId=null) {
        if ($siteId == null) {
            $siteId = Context::getSiteId();
        }
        $id = Database::escape($id);
        $name = Database::escape($name);
        $description = Database::escape($description);
        Database::query("update t_video_album set name='$name', description='$description', siteid='$siteId' where id='$id'");
    }
    
    static function listVideoAlbum ($siteId=null) {
        if ($siteId == null) {
            $siteId = Context::getSiteId();
        }
        $siteId = Database::escape($siteId);
        return Database::queryAsArray("select * from t_video_album where siteid = '$siteId'");
    }
    
    static function deleteVideoAlbum ($albumId) {
        $albumId = Database::escape($albumId);
        Database::query("delete t_video_album where id = '$albumId'");
    }
    
    static function getVideoAlbum ($id) {
        $id = Database::escape($id);
        return Database::queryAsObject("select * from t_video_album where id = '$id'");
    }
}
