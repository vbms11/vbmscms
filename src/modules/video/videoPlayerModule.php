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
            default:
                if (Context::hasRole("videoPlayer.view")) {
                    $this->printPlayVideo(parent::param("videoId"));
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
        return array("videoPlayer.edit","videoPlayer.view");
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
    
    function printPlayVideo ($videoId, $width=800, $height=500) {
        
        $video = VideoModel::getVideo($videoId);
        $user = UsersModel::getUser($video->userid);
        
        ?>
        <div class="panel videoPlayerPanel">
            <div class="videoPlayerVideo">
                <video id="example_video_1" class="video-js" controls preload="none" width="<?php echo $width; ?>" height="<?php echo $height; ?>" poster="<?php echo ResourcesModel::createResourceLink("video/big",$video->file.".jpg"); ?>" data-setup="{}">
                    <source src="<?php echo ResourcesModel::createResourceLink("video/mp4",$video->file); ?>.mp4" type="video/mp4" />
                    <?php /* <source src="<?php echo $video->file; ?>.webm" type="video/webm" /> */ ?>
                </video>
            </div>
            <h1 class="videoPlayerTitel">
                <?php echo $video->title; ?>
            </h1>
            <p class="videoPlayerDescription">
                <?php echo $video->description; ?>
            </p>
            <div class="videoPlayerUser">
                <?php echo parent::getTranslation("videoPlayer.username")." ".$user->username; ?>
            </div>
            <div class="videoPlayerUploadDate">
                <?php echo parent::getTranslation("videoPlayer.uploadDate")." ".$video->uploaddate; ?>
            </div>
        </div>
        <?php    
    }
    
    
}

?>