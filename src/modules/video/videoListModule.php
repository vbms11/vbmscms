<?php

require_once('modules/video/videoModel.php');
require_once('modules/video/videoPlayerModule.php');
require_once('modules/video/videoController.php');

class VideoListModule extends VideoPlayerModule {
    
    function onProcess () {
        
        switch (parent::getAction()) {
            case "edit":
                if (Context::hasRole("video.edit")) {
                    parent::focus();
                }
                break;
            case "save":
                if (Context::hasRole("video.edit")) {
                    parent::param("album", parent::post("album"));
                }
                break;
            case "uploadVideo":
                if (Context::hasRole("video.upload")) {
                    VideoController::uploadVideo("video", parent::param("album"));
                    PagesModel::updateModifyDate();
                    Context::setReturnValue("");
                }
                break;
            case "deleteVideo":
                if (Context::hasRole("video.upload")) {
                    if (parent::get("id")) {
                        VideoController::deleteVideo(parent::get("id"));
                        PagesModel::updateModifyDate();
                    }
                    parent::redirect();
                }
                break;
            case "editAlbum":
                if (Context::hasRole("video.upload")) {
                    parent::focus();
                }
                break;
            case "saveAlbum":
                if (Context::hasRole("video.upload")) {
                    if (parent::get("id")) {
                        VideoModel::updateVideoAlbum(parent::get("id"), parent::post("name"), parent::post("description"));
                    } else {
                        VideoModel::createVideoAlbum(parent::post("name"), parent::post("description"));
                    }
                    PagesModel::updateModifyDate();
                    parent::redirect(array("action"=>"edit"));
                }
                break;
            case "deleteAlbum":
                if (Context::hasRole("video.upload")) {
                    if (parent::get("id")) {
                        VideoModel::deleteAlbum(parent::get("id"));
                        PagesModel::updateModifyDate();
                    }
                    parent::redirect(array("action"=>"edit"));
                }
                break;
            default:
                parent::blur();
        }
    }
    
    function onView () {
        
        switch ($this->getAction()) {
            case "edit":
                if (Context::hasRole("video.edit")) {
                    $this->printEditView();
                }
                break;
            case "newVideo":
                if (Context::hasRole("video.upload")) {
                    $this->printUploadVideo();
                }
                break;
            case "editAlbum":
                if (Context::hasRole("video.upload")) {
                    $this->printEditAlbum(parent::get("id") ? parent::get("id") : null);
                }
                break;
            case "playVideo":
                if (Context::hasRole("video.view")) {
                    $this->printPlayVideo(parent::get("id"));
                }
                break;
            default:
                if (Context::hasRole("video.view")) {
                    $this->printListVideoView();
                }
                break;
        }
    }
    
    function getScripts () {
        return parent::getScripts();
    }
    
    function getStyles () {
        return array_merge(array("css/videoList.css"),parent::getStyles());
    }
    
    function getRoles () {
        return array("video.edit","video.view","video.upload");
    }
    
    function printEditView () {
        $albums = Common::toMap(VideoModel::listVideoAlbum(),"id","name");
        ?>
        <div class="panel galleryPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"save")); ?>">
                <table class="formTable"><tr><td>
                    <?php echo parent::getTranslation("video.label.album"); ?>
                </td><td>
                    <?php InputFeilds::printSelect("album", parent::param("album"), $albums); ?>
                </td><td>
                    <button id="createAlbum">Create</button>
                </td><td>
                    <button id="editAlbum">Edit</button>
                </td><td>
                    <button id="deleteAlbum">Delete</button>
                </td></tr></table>
                <hr/>
                <div class="alignRight">
                    <button type="submit" class="jquiButton"><?php echo parent::getTranslation("common.save"); ?></button>
                </div>
            </form>
            
            <script>
            $("#createAlbum").button().click(function (e) {
                callUrl("<?php echo parent::link(array("action"=>"editAlbum")); ?>");
                e.preventDefault();
            });
            $("#editAlbum").button().click(function (e) {
                callUrl("<?php echo parent::link(array("action"=>"editAlbum")); ?>",{"id":$("#album").val()});
                e.preventDefault();
            });
            $("#deleteAlbum").button().click(function (e) {
                doIfConfirm("<?php echo parent::getTranslation("video.album.delete") ?>","<?php echo parent::link(array("action"=>"deleteAlbum")); ?>",{"id":$("#album").val()});
                e.preventDefault();
            });
            </script>
        </div>
        <?php
    }

    function printEditAlbum ($albumId=null) {
        $action = array("action"=>"saveAlbum");    
        $album = null;
        if ($albumId != null) {
            $album = VideoModel::getVideoAlbum($albumId);
            $action["id"] = $albumId;
        }
        ?>
        <div class="panel galleryPanel">
            <h1><?php echo parent::getTranslation("video.album.heading"); ?></h1>
            <p><?php echo parent::getTranslation("video.album.description"); ?></p>
            <form method="post" action="<?php echo parent::link($action); ?>">
                <table class="formTable"><tr><td>
                    <?php echo parent::getTranslation("video.album.label.name"); ?>
                </td><td>
                    <?php InputFeilds::printTextFeild("name", $albumId == null ? "" : $album->name); ?>
                </td><tr/><tr><td>
                    <?php echo parent::getTranslation("video.album.label.description"); ?>
                </td><td>
                    <?php InputFeilds::printTextArea("description", $albumId == null ? "" : $album->description); ?>
                </td></tr></table>
                <hr/>
                <div class="alignRight">
                    <button type="submit" class="jquiButton"><?php echo parent::getTranslation("common.save"); ?></button>
                    <button type="button" id="btnCancel" class="jquiButton"><?php echo parent::getTranslation("common.cancel"); ?></button>
                </div>
            </form>
            <script>
            $("#btnCancel").click(function (e) {
                callUrl("<?php echo parent::link(array("action"=>"edit")); ?>");
                e.preventDefault();
            });
            </script>
        </div>
        <?php
    }    
    
    function printListVideoView () {
        
        $videos = VideoModel::getVideoByAlbum(parent::param("album"));
        
        ?>
        <div class="panel videoPanel">
            
            
            <?php
            if (Context::hasRole("video.upload")) {
                ?>
                <div class="videoTools">
                    <a href="<?php echo parent::link(array("action"=>"newVideo")); ?>" class="jquiButton">
                        <?php echo parent::getTranslation("video.button.upload"); ?>
                    </a>
                </div>
                <?php
            }
            ?>
            <div class="videoGrid">
                <?php
                foreach ($videos as $video) {
                    $imageCss = "";
                    if (Context::hasRole("video.upload")) {
                        $imageCss = "videoTileAdmin";
                    }
                    ?>
                    <div align="center" class="videoTile <?php echo $imageCss; ?>">
                        <div class="videoGridTile shadow">
                            <a href="<?php echo parent::link(array("action"=>"playVideo","id"=>$video->id)); ?>">
                                <img class="imageLink" width="170" height="170" src="<?php echo ResourcesModel::createResourceLink("video/small",$video->file); ?>" alt=""/>
                            </a>
                        </div>
                        <?php
                        if (Context::hasRole("video.upload")) {
                            ?>
                            <a onclick="return confirm('<?php echo parent::getTranslation("video.dialog.deleteVideo"); ?>');" href="<?php echo parent::link(array("action"=>"deleteVideo","id"=>$video->id)); ?>"><img src="resource/img/delete.png" alt=""/></a>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
                <div class="clear"></div>
            </div>
        </div>
        <?php    
    }
    
    function printUploadVideo () {
        
        ?>
        <h1><?php echo parent::getTranslation("video.upload.title"); ?></h1>
        <p><?php echo parent::getTranslation("video.upload.description"); ?></p>
        <?php 
        InputFeilds::printMultiFileUpload("video", parent::ajaxLink(array("action"=>"uploadVideo")));
        ?>
        <hr/>
        <div class="alignRight">
            <a href="<?php echo parent::link(); ?>" class="jquiButton">
                <?php echo parent::getTranslation("video.button.finnish"); ?>
            </a>
        </div>
        <?php
    }
    
}

?>