<?php

require_once('core/plugin.php');

class VideoPlayerModule extends XModule {
    
    function onProcess () {
        
        switch (parent::getAction()) {
            case "edit":
                if (Context::hasRole("gallery.edit")) {
                    parent::focus();
                }
                break;
            case "save":
                if (Context::hasRole("gallery.edit")) {
                    parent::param("mode", parent::post("mode"));
                }
                break;
            case "upload":
                break;
            case "delete":
                break;
            default:
                parent::blur();
        }
    }
    
    function onView () {
        
        switch ($this->getAction()) {
            case "edit":
                if (Context::hasRole("videoPlayer.edit")) {
                    $this->printEditView();
                }
                break;
            case "view":
                if (Context::hasRole("videoPlayer.view")) {
                    $this->printVideoPlayer();
                }
                break;
            case "upload":
                if (Context::hasRole("videoPlayer.upload")) {
                    $this->printUploadVideos();
                }
                break;
            default:
                if (Context::hasRole("videoPlayer.view")) {
                    $this->printListVideos();
                }
                break;
        }
    }
    
    function getScripts () {
        return array("videojs/video.min.js");
    }
    
    function getStyles () {
        return array("css/videoPlayer.css","videojs/video-js.min.css");
    }
    
    function getRoles () {
        return array("videoPlayer.edit","videoPlayer.upload","videoPlayer.view");
    }
    
    function printEditView () {
        ?>
        <div class="panel galleryPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"save")); ?>">
                <table class="formTable"><tr><td>
                    
                </td><td>
                    
                </td></tr></table>
                <hr/>
                <div class="alignRight">
                    <button type="submit"><?php echo parent::getTranslation("common.save"); ?></button>
                </div>
            </form>
        </div>
        <?php
    }
    
    function printListVideos () {
        
    }
    
    function printUploadVideos () {
        ?>
        <h1><?php echo parent::getTranslation("video.upload.title"); ?></h1>
        <p><?php echo parent::getTranslation("video.upload.description"); ?></p>
        <?php 
        InputFeilds::printMultiFileUpload("videos", parent::ajaxLink(array("action"=>"uploadImage","category"=>$_GET['category'])), "");
        ?>
        <hr/>
        <div class="alignRight">
            <a href="<?php echo parent::link(array("category"=>$category)); ?>" class="jquiButton">
                <?php echo parent::getTranslation("gallery.button.finnish"); ?>
            </a>
        </div>
        <?php
    }
    
    function printVideoPlayer () {
        
        $video = VideoModel::getVideo(parent::get("id"));
        $user = UsersModel::getUser($video->userid);
        
        ?>
        <div class="panel videoPlayerPanel">
            <div class="videoPlayerVideo">
                <video id="example_video_1" class="video-js" controls preload="none" width="640" height="264" poster="<?php echo $video->poster; ?>" data-setup="{}">
                    <source src="<?php echo $video->file; ?>.mp4" type="video/mp4" />
                    <source src="<?php echo $video->file; ?>.webm" type="video/webm" />
                </video>
            </div>
            <div class="videoPlayerTitel">
                <?php echo $video->titel; ?>
            </div>
            <div class="videoPlayerDescription">
                <?php echo $video->description; ?>
            </div>
            <div class="videoPlayerUser">
                <?php echo $user->username; ?>
            </div>
            <div class="videoPlayerUploadDate">
                <?php echo $video->uploaddate; ?>
            </div>
        </div>
        <?php    
    }
    
    
}

?>