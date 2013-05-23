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
                    parent::param("mode",$_POST["mode"]);
                    parent::param("linkProfile",parent::post("linkProfile") == "1" ? true : false);
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
                // uploads the image and create preview image
                GalleryModel::uploadImage("fileData",$user->gallery);
                Context::returnValue("");
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
            case "configure":
                $this->printConfigureView();
                break;
            default:
                echo "asdf";
                if (Context::hasRole("user.image.view")) {
                    $this->printMainView();
                }
                break;
        }
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("user.image.edit","user.image.view","user.image.own");
    }
    
    function getScripts() {
        return array("js/usersProfileImage.css");
    }
    
    static function getTranslations() {
        return array(
            "en"=>array(
                "users.image.edit.mode" => "Display Mode:"
            ),
            "de"=>array(
                "users.image.edit.mode" => "Anzige Modus:"
            ));
    }
    
    function printEditView () {
        ?>
        <div class="panel usersImagePanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"save")); ?>">
                <table><tr><td>
                    <?php echo parent::getTranslation("users.image.edit.mode"); ?>
                </td><td>
                    <?php InputFeilds::printSelect("mode", parent::param("mode"), array(parent::getTranslation("common.user.current") => self::modeCurrentUser, parent::getTranslation("common.user.selected") => self::modeSelectedUser)); ?>
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("users.image.edit.linkProfile"); ?>
                </td><td>
                    <?php InputFeilds::printCheckbox("linkProfile", parent::param("linkProfile")); ?>
                </td></tr></table>
                <hr/>
                <button type="submit"><?php echo parent::getTranslation("common.save"); ?></button>
            </form>
        </div>
        <?php
    }
    
    function getUserBySelectedMode () {
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
        $user = null;
        if (empty($userId)) {
            $user = UsersModel::getUser($userId);
        }
        return $user;
    }
    
    function printConfigureView () {
        $user = $this->getUserBySelectedMode();
        $categoryId = Common::isEmpty(parent::get("category")) ? parent::get("category") : $user->gallery;
        $category = GalleryModel::getCategory($categoryId);
        $images = GalleryModel::getImages($categoryId);
        $categorys = GalleryModel::getCategorys($categoryId);
        ?>
        <div class="panel userImageConfigPanel">
            <table><tr>
            <td><?php echo parent::getTranslation("user.profile.image"); ?></td>
            <td><?php InputFeilds::printMultiFileUpload("profileImage", parent::link(array("action"=>"uploadImage"))); ?></td>
            </tr></table>
            <div class="galleryContainer">
                <?php
                if ($category->parent != null) {
                    ?>
                    <div class="galleryButtons">
                        <a href="<?php echo parent::link(); ?>">Back</a> 
                    </div>
                    <?php
                }
                ?>
                <div align="center">
                    <?php
                    foreach ($categorys as $category) {
                        ?>
                        <div align="center" class="galleryGrid">
                            <div class="galleryGridImage shadow">
                                <a href="<?php echo parent::link(array("action"=>"configure","category"=>$category->id)); ?>">
                                    <img class="imageLink" width="170" height="170" src="<?php echo Common::isEmpty($category->filename) ? "resource/img/icons/Clipboard.png" : ResourcesModel::createResourceLink("gallery/small",$category->filename); ?>" alt=""/>
                                </a>
                            </div>
                            <div class="galleryGridTitle">
                                <?php echo $category->title; ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                    foreach ($images as $image) {
                        ?>
                        <div align="center" class="galleryGrid">
                            <div class="galleryGridImage galleryImages shadow">
                                <img onclick="callUrl('<?php echo parent::link(array("action"=>"setImage","id"=>$image->id)); ?>');" class="imageLink" width="170" height="170" src="<?php echo ResourcesModel::createResourceLink("gallery/small",$image->image); ?>" alt=""/>
                            </div>
                            <a onclick="return confirm('<?php echo parent::getTranslation("user.profile.image.delete"); ?>')" href="<?php echo parent::link(array("action"=>"delete","image"=>$image->id,"category"=>$categoryId)); ?>">
                                <img src="resource/img/delete.png" class="imageLink" alt=""/>
                            </a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
    
    function printMainView () {
        ?>
        <div class="panel usersImagePanel">
            <?php
            if (Context::hasRole("user.image.view")) {
                $user = $this->getUserBySelectedMode();
                if (empty($user)) {
                    echo '<a href="'.parent::staticLink("register").'"><img src="resouce/img/icons/User.png" alt="" /></a>';
                } else {
                    if (parent::param("linkProfile")) {
                        echo '<a href="'.Context::getUserHome($user->id).'">';
                    }
                    echo '<img src="'.ResourcesModel::createResourceLink("gallery/small", $user->image).'" alt="" />';
                    if (parent::param("linkProfile")) {
                        echo '</a>';
                    }
                    if (Context::hasRole("user.image.edit")) {
                        echo '<div class="userImageConfigure">'.parent::getTranslation("user.image.configure").'</div>';
                    }
                }
            }
            ?>
        </div>
        <?php
    }
}

?>