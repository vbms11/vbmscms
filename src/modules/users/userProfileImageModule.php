<?php

require_once('core/plugin.php');
require_once('core/model/usersModel.php');

class UserProfileImageModule extends XModule {
    
    const modeCurrentUser = 1;
    const modeSelectedUser = 2;

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {
        
        switch (parent::getAction()) {
            case "save":
                if (Context::hasRole("user.image.edit")) {
                    parent::param("mode",parent::post("mode"));
                }
                parent::blur();
                parent::redirect();
                break;
            case "edit":
                if (Context::hasRole("user.image.edit")) {
                    parent::focus();
                }
                break;
            case "uploadImage":
                if (Context::hasRole("user.image.view")) {
                    $user = $this->getUserBySelectedMode();
                    $gallery = GalleryModel::getUserGallery($user->id);
                    GalleryModel::uploadImage("fileData",$gallery->rootcategory);
                    Context::setReturnValue("");
                }
                break;
            case "cropImage":
                if (Context::hasRole("user.image.view")) {
                    $user = $this->getUserBySelectedMode();
                    UsersModel::setUserImageCrop($user->id, parent::post("imagex"), parent::post("imagey"), parent::post("imagew"), parent::post("imageh"));
                    NavigationModel::redirectStaticModule("userProfile",array("userId"=>$user->id));
                }
                break;
            case "selectImage":
                if (Context::hasRole("user.image.view")) {
                    $user = $this->getUserBySelectedMode();
                    UsersModel::setUserImage($user->id, parent::get("id"));
                    Context::setReturnValue("");
                }
                break;
            default:
                if (parent::param("mode") == self::modeSelectedUser && parent::get("userId")) {
                    Context::setSelectedUser(parent::get("userId"));
                } else if (parent::param("mode") == self::modeCurrentUser) {
                    Context::setSelectedUser(Context::getUserId());
                }
                parent::blur();
                break;
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {

        switch (parent::getAction()) {
            case "edit":
                if (Context::hasRole("user.image.edit")) {
                    $this->printEditView();
                }
                break;
            case "crop":
                if (Context::hasRole("user.image.view")) {
                    $this->printCropImageView();
                }
                break;
            case "upload":
                if (Context::hasRole("user.image.view")) {
                    $this->printUploadImage();
                }
                break;
            default:
                if (Context::hasRole("user.image.view")) {
                    $this->printSelectImageView();
                }
                break;
        }
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("user.image.edit","user.image.view");
    }
    
    function getStyles() {
        return array("css/userProfileImage.css");
    }
    
    function getUserBySelectedMode () {
        /*
        $userId = null;
        switch (parent::param("mode")) {
            case self::modeSelectedUser:
                $userId = Context::getSelectedUserId();
                break;
            case self::modeCurrentUser:
            default:
                if (Context::hasRole("user.profile.own")) {
                    $userId = Context::getUserId();
                }
                break;
        }
         * 
         */
        $userId = Context::getUserId();
        $user = null;
        if (!empty($userId)) {
            $user = UsersModel::getUser($userId);
        }
        return $user;
    }
    
    function printEditView () {
        ?>
        <div class="panel usersImagePanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"save")); ?>">
                <table><tr><td>
                    <?php echo parent::getTranslation("userProfileImage.edit.mode"); ?>
                </td><td>
                    <?php InputFeilds::printSelect("mode", parent::param("mode"), array(self::modeCurrentUser => parent::getTranslation("common.user.current"), self::modeSelectedUser => parent::getTranslation("common.user.selected"))); ?>
                </td></tr></table>
                <hr/>
                <button type="submit" class="jquiButton"><?php echo parent::getTranslation("common.save"); ?></button>
            </form>
        </div>
        <?php
    }
    
    function printSelectImageView () {
        
        $user = $this->getUserBySelectedMode();
        $gallery = GalleryModel::getUserGallery($user->id);
        $categorys = GalleryModel::getCategorys($gallery->rootcategory);
        //$categorys[] = GalleryModel::getCategory($gallery->rootcategory);
        
        ?>
        <div class="panel userImageSelectPanel">
            <h1><?php echo parent::getTranslation("userProfileImage.title"); ?></h1>
            <p><?php echo parent::getTranslation("userProfileImage.description"); ?></p>
            <div class="userImageSelectPanelItems">
                <?php
                $hasImages = false;
                if (!empty($categorys)) {
                    foreach ($categorys as $category) {
                        $images = GalleryModel::getImages($category->id);
                        foreach ($images as $image) {
                            $hasImages = true;
                            ?>
                            <div class="userImageSelectImage" id="profileImage_<?php echo $image->id; ?>">
                                <img width="170" height="170" src="<?php echo ResourcesModel::createResourceLink("gallery/small",$image->image); ?>" alt=""/>
                            </div>
                            <?php
                        }   
                    }
                }
                if (!$hasImages) {
                    ?>
                    <p><?php echo parent::getTranslation("userProfileImage.noImages"); ?></p>
                    <?php
                }
                ?>
            </div>
            <div class="clear"></div>
            <hr/>
            <div class="alignRight">
                <a class="jquiButton upload" href="<?php echo parent::link(array("action"=>"upload")); ?>"><?php echo parent::getTranslation("userProfileImage.upload"); ?></a>
                <a class="crop" href="<?php echo parent::link(array("action"=>"crop")); ?>"><?php echo parent::getTranslation("userProfileImage.crop"); ?></a>
                <a class="jquiButton finish" href="<?php echo parent::staticLink('userProfile',array('userId' => $user->id)); ?>"><?php echo parent::getTranslation("userProfileImage.finnish"); ?></a>
            </div>
        </div>
        <script>
        $(".userImageSelectPanel .crop").button({"disabled" : true});
        $(".userImageSelectPanelItems").selectable({ 
            filter: ".userImageSelectImage",
            start: function () {
                $(this).each(function (index, object) {
                    $(object).removeClass("ui-selected");
                });
            }, stop: function() {
                var id = $(".userImageSelectPanel .ui-selected").attr("id").substring(13);
                ajaxRequest("<?php echo parent::ajaxLink(array("action"=>"selectImage")); ?>", function () {
                    $(".userImageSelectPanel .crop").button("option", "disabled", false);
                }, {"id":id});
            }
        });
        </script>
        <?php
    }
    
    function printCropImageView () {
        
        Context::addRequiredScript("resource/js/jcrop/jquery.Jcrop.min.js");
        Context::addRequiredStyle("resource/js/jcrop/jquery.Jcrop.min.css");
        
        $user = $this->getUserBySelectedMode();
        $image = GalleryModel::getImage($user->image);
        $imageUrl = ResourcesModel::createResourceLink("gallery",$image->image);
        
        ?>
        <div class="panel profileImageCropPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"cropImage")); ?>">
                <input type="hidden" name="imagex" value="" />
                <input type="hidden" name="imagey" value="" />
                <input type="hidden" name="imagew" value="" />
                <input type="hidden" name="imageh" value="" />
                <img src="<?php echo $imageUrl; ?>" id="cropSrcImage" alt="" />
                <hr/>
                <div class="alignRight">
                    <button class="jquiButton" type="submit"><?php echo parent::getTranslation("userProfileImage.finnish"); ?></button>
                    <button class="jquiButton selectImage" type="button"><?php echo parent::getTranslation("userProfileImage.selectImage"); ?></button>
                </div>
            </form>
        </div>
        <script>
        $('#cropSrcImage').Jcrop({
            onChange: updatePreview,
            onSelect: updatePreview,
            aspectRatio: 1
        });
        function updatePreview(c) {
            if (parseInt(c.w) > 0) {
                $(".profileImageCropPanel")
                    .find("input[name=imagex]").val(c.x).end()
                    .find("input[name=imagey]").val(c.y).end()
                    .find("input[name=imagew]").val(c.w).end()
                    .find("input[name=imageh]").val(c.h);
            }
        }
        $(".profileImageCropPanel .selectImage").click(function(){
            callUrl("<?php echo parent::link(); ?>");
        })
        </script>
        <?php
    }
    	
    function printUploadImage () {
        
        ?>
        <div class="panel userImageSelectPanel">
            <h1><?php echo parent::getTranslation("userProfileImage.upload.title"); ?></h1>
            <p><?php echo parent::getTranslation("userProfileImage.upload.description"); ?></p>
            <?php 
            InputFeilds::printMultiFileUpload("images", parent::ajaxLink(array("action"=>"uploadImage")));
            ?>
            <hr/>
            <div class="alignRight">
                <a href="<?php echo parent::link(); ?>" class="jquiButton">
                    <?php echo parent::getTranslation("userProfileImage.upload.finnish"); ?>
                </a>
            </div>
        </div>
        <?php
    }
}

?>