<?php

require_once('core/plugin.php');
require_once('modules/users/userWallModel.php');

class UserGalleryModule extends XModule {
    
    const modeModuleGallery = 1;
    const modeCurrentUserGallery = 2;
    const modeSelectedUserGallery = 3;
    
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
            case "uploadImage":
                if ($this->getAllowUserEdit()) {
                    $imageId = GalleryModel::uploadImage("fileData",parent::get("category"));
                    UserWallModel::createUserWallEventImageUpload(Context::getUserId(), $imageId);
                    PagesModel::updateModifyDate();
                    Context::setReturnValue("");
                }
                break;
            case "newCategory":
                if ($this->getAllowUserEdit()) {
                    parent::focus();
                }
                break;
            case "saveCategory":
                if ($this->getAllowUserEdit()) {
                    if (parent::get("id")) {
                        GalleryModel::updateCategory(parent::get("id"), parent::post("title"), parent::post("imageId"), parent::post("description"));
                    } else {
                        GalleryModel::createCategory(parent::post("title"), parent::post("description"), null, parent::get("category"));
                    }
                    PagesModel::updateModifyDate();
                    parent::blur();
                    parent::redirect(array("category"=>parent::get("category")));
                }
                break;
            case "deleteImage":
                if ($this->getAllowUserEdit()) {
                    if (parent::get("id")) {
                        GalleryModel::deleteImage(parent::get("id"));
                        UserWallModel::deleteWallEventImageUploadByImageId(parent::get("id"));
                        PagesModel::updateModifyDate();
                    }
                    parent::redirect(array("category"=>parent::get("category")));
                }
                break;
            case "deleteCategory":
                if ($this->getAllowUserEdit()) {
                    if (parent::get("id")) {
                        GalleryModel::deleteCategory(parent::get("id"));
                        PagesModel::updateModifyDate();
                    }
                    parent::redirect(array("category"=>parent::get("category")));
                }
                break;
            case "moveImageUp":
                if ($this->getAllowUserEdit()) {
                    if (parent::get("id")) {
                        GalleryModel::moveImageUp(parent::get("id"));
                    }
                    parent::redirect(array("category"=>parent::get("category")));
                }
                break;
            case "moveImageDown":
                if ($this->getAllowUserEdit()) {
                    if (parent::get("id")) {
                        GalleryModel::moveImageDown(parent::get("id"));
                    }
                    parent::redirect(array("category"=>parent::get("category")));
                }
                break;
            case "moveCategoryUp":
                if ($this->getAllowUserEdit()) {
                    if (parent::get("id")) {
                        GalleryModel::moveCategoryUp(parent::get("id"));
                    }
                    parent::redirect(array("category"=>parent::get("category")));
                }
                break;
            case "moveCategoryDown":
                if ($this->getAllowUserEdit()) {
                    if (parent::get("id")) {
                        GalleryModel::moveCategoryDown(parent::get("id"));
                    }
                    parent::redirect(array("category"=>parent::get("category")));
                }
                break;
            case "viewImage":
                parent::focus();
                break;
            case "comment":
                if (parent::post("submitButton")) {
                    $userId = $this->getModeUserId();
                    if (UserWallModel::canUserPost($userId)) {
                        $validationMessages = UserWallModel::validateWallPost($userId, Context::getUserId(), parent::post("comment"));
                        if (count($validationMessages) > 0) {
                            parent::setMessages($validationMessages);
                        } else {
                            $eventId = UserWallModel::getUserWallImageEventByImageId(parent::get("imageId"));
                            UserWallModel::createUserWallEventImageComment(Context::getUserId(), parent::post("comment"), $eventId);
                            parent::clearMessages();
                            parent::redirect(array("action"=>"viewImage","id"=>parent::get("imageId"),"category"=>parent::get("category")));
                        }
                    }
                }
                break;
            case "deleteComment":
                $userId = $this->getModeUserId();
                $comment = UserWallModel::getUserWallPostById(parent::get("id"));
                if ($userId == Context::getUserId() || $comment->srcuserid == Context::getUserId()) {
                    UserWallmodel::deleteUserPostById(parent::get("id"));
                }
                if (Context::isAjaxRequest()) {
                    Context::setReturnValue("");
                } else {
                    parent::redirect(array("action"=>"viewImage","id"=>parent::get("image"),"category"=>parent::get("category")));
                }
                break;
            case "saveComment":
                if (parent::post("submitButton")) {
                    $post = UserWallModel::getUserWallPostById(parent::get("id"));
                    if (UserWallModel::canUserPost($post->srcuserid) && $post->srcuserid == Context::getUserId()) {
                        $validationMessages = UserWallModel::validateWallPost($post->srcuserid, Context::getUserId(), parent::post("comment"));
                        if (count($validationMessages) > 0) {
                            parent::setMessages($validationMessages);
                        } else {
                            UserWallModel::updateUserPost(parent::get("id"), parent::post("comment"));
                            parent::clearMessages();
                            parent::redirect(array("action"=>"viewImage","id"=>parent::get("image"),"category"=>parent::get("category")));
                        }
                    }
                }
                break;
            default:
                if (parent::param("mode") == self::modeSelectedUserGallery && parent::get("userId")) {
                    Context::setSelectedUser(parent::get("userId"));
                } else if (parent::param("mode") == self::modeCurrentUserGallery) {
                    Context::setSelectedUser(Context::getUserId());
                }
                parent::clearMessages();
                parent::blur();
        }
    }
    
    function onView () {
        
        switch (parent::getAction()) {
            case "edit":
                if (Context::hasRole("gallery.edit")) {
                    $this->printEditView();
                }
                break;
            case "uploadImage":
                break;
            case "newCategory":
                if ($this->getAllowUserEdit()) {
                    $this->printEditCategory();
                }
                break;
            case "editCategory":
                if ($this->getAllowUserEdit()) {
                    $this->printEditCategory(parent::get("id"));
                }
                break;
            case "newImage":
                if ($this->getAllowUserEdit()) {
                    $this->printUploadImage();
                }
                break;
            case "editComment":
            case "saveComment":
                $this->printEditComment(parent::get("id"),parent::get("image"),parent::get("category"));
                break;
            case "comment":
            case "viewImage":
                $this->printViewImage(parent::get("id"),parent::get("category"));
                break;
            default:
                if (Context::hasRole("gallery.view")) {
                    $this->printGallery();
                }
                break;
        }
    }
    
    function getScripts () {
        return array();
    }
    
    function getStyles () {
        return array("css/userGallery.css","css/userWall.css");
    }
    
    function getRoles () {
        return array("gallery.edit","gallery.view","gallery.owner");
    }
    
    function printEditView () {
        ?>
        <div class="panel galleryPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"save")); ?>">
                <table class="formTable"><tr><td>
                    <?php echo parent::getTranslation("gallery.mode"); ?>
                </td><td>
                    <?php InputFeilds::printSelect("mode", parent::param("mode"), array(
                        self::modeModuleGallery => "Module Gallery",
                        self::modeCurrentUserGallery => "Current User Gallery",
                        self::modeSelectedUserGallery => "Selected User Gallery")); ?>
                </td></tr></table>
                <hr/>
                <div class="alignRight">
                    <button type="submit" class="jquiButton"><?php echo parent::getTranslation("common.save"); ?></button>
                </div>
            </form>
        </div>
        <?php
    }
    
    function getAllowUserEdit () {
        $allowUserEdit = false;
        switch (parent::param("mode")) {
            case self::modeSelectedUserGallery:
                if (Context::getUserId() == Context::getSelectedUserId() && Context::hasRole("gallery.owner")) {
                    $allowUserEdit = true;
                }
                break;
            case self::modeCurrentUserGallery:
            default:
                if (Context::hasRole("gallery.owner")) {
                    $allowUserEdit = true;
                }
                break;
        }
        return $allowUserEdit;
    }
    
    function getGalleryPage () {
        $galleryPage = null;
        switch (parent::param("mode")) {
            case self::modeSelectedUserGallery:
                $galleryPage = GalleryModel::getUserGallery(Context::getSelectedUserId());
            case self::modeCurrentUserGallery:
            default:
                if (Context::hasRole("gallery.owner")) {
                    $galleryPage = GalleryModel::getUserGallery(Context::getUserId());
                }
                break;
        }
        return $galleryPage;
    }
    
    function getModeUserId () {
        
        $userId = null;
        switch (parent::param("mode")) {
            case self::modeSelectedUserGallery:
                $userId = Context::getSelectedUserId();
                break;
            default:
            case self::modeCurrentUserGallery:
                if (Context::hasRole("user.profile.owner")) {
                    $userId = Context::getUserId();
                }
                break;
        }
        return $userId;
    }
    
    function printGallery () {
        
        Context::addRequiredStyle("resource/js/lightbox/css/jquery.lightbox-0.5.css");
        Context::addRequiredScript("resource/js/lightbox/js/jquery.lightbox-0.5.pack.js");
        
        $galleryPage = $this->getGalleryPage();
        if (empty($galleryPage)) {
            return;
        }
        
        $galleryEdit = $this->getAllowUserEdit();
        $galleryButtons = false;
        if ($galleryEdit) {
            $galleryButtons = true;
        }
        
        $galleryButtonsBack = false;
        if (parent::get('category')) {
            $selectedCategoryId = parent::get('category');
            if ($selectedCategoryId != $galleryPage->rootcategory) {
                $galleryButtonsBack = true;
                $galleryButtons = true;
            }
        } else {
            $selectedCategoryId = $galleryPage->rootcategory;
        }
        
        $selectedCategory = GalleryModel::getCategory($selectedCategoryId);
        $categorys = GalleryModel::getCategorys($selectedCategoryId);
        $images = GalleryModel::getImages($selectedCategoryId);
        
        ?>
        <div class="panel galleryPanel">
            <?php
            
            if ($galleryButtons) {
                
                ?>
                <div class="galleryButtons">
                    <?php
                    if ($galleryButtonsBack) {
                        ?>
                        <a href="<?php echo parent::link(array("category"=>$selectedCategory->parent)); ?>');" class="jquiButton">
                            <?php echo parent::getTranslation("gallery.button.back"); ?>
                        </a>
                        <?php
                    } 
                    if ($galleryEdit) {
                        ?>
                        <a href="<?php echo parent::link(array("action"=>"newCategory","category"=>$selectedCategoryId)); ?>" class="jquiButton">
                            <?php echo parent::getTranslation("gallery.button.newCategory"); ?>
                        </a>
                        <a href="<?php echo parent::link(array("action"=>"newImage","category"=>$selectedCategoryId)); ?>" class="jquiButton">
                            <?php echo parent::getTranslation("gallery.button.uploadImage"); ?>
                        </a>
                        <?php
                    }
                    ?>
                    <hr/>
                </div>
                <?php
            }
            
            ?>
            <div class="galleryImages">
                <?php
                foreach ($categorys as $category) {
                    ?>
                    <div class="galleryGrid">
                        <div class="galleryGridImage shadow">
                            <a href="<?php echo parent::link(array("category"=>$category->id)); ?>">
                                <img class="imageLink" width="170" height="170" src="<?php 
                                    if (empty($category->filename)) {
                                        echo "resource/img/icons/Clipboard.png";
                                    } else {
                                        echo ResourcesModel::createResourceLink("gallery/small",$category->filename);
                                    }
                                ?>" alt=""/>
                            </a>
                        </div>
                        <div class="galleryGridTitle">
                            <?php echo $category->title; ?>
                        </div>    
                        <?php
                        if ($galleryEdit) {
                            ?>
                            <div class="galleryGridTools">
                                <a href="<?php echo parent::link(array("action"=>"editCategory","category"=>$selectedCategoryId,"id"=>$category->id)); ?>"><img src="resource/img/edit.png" alt="" /></a>
                                <a href="<?php echo parent::link(array("action"=>"moveCategoryDown","category"=>$selectedCategoryId,"id"=>$category->id)); ?>"><img src="resource/img/movedown.png" alt="" /></a>
                                <a href="<?php echo parent::link(array("action"=>"moveCategoryUp","category"=>$selectedCategoryId,"id"=>$category->id)); ?>"><img src="resource/img/moveup.png" alt="" /></a>
                                <a onclick="return confirm('<?php echo parent::getTranslation("gallery.dialog.deleteCategory"); ?>')" href="<?php echo parent::link(array("action"=>"deleteCategory","category"=>$selectedCategoryId,"id"=>$category->id)); ?>"><img src="resource/img/delete.png" alt=""/></a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
                <?php
                foreach ($images as $image) {
                    $imageCss = "";
                    if ($galleryEdit) 
                        $imageCss = "galleryGridAdmin";
                    ?>
                    <div class="galleryGrid <?php echo $imageCss; ?>">
                        <div class="galleryGridImage galleryImages shadow">
                            <a href="<?php echo parent::link(array("action"=>"viewImage","category"=>$selectedCategoryId,"id"=>$image->id)); ?>">
                                <img class="imageLink" width="170" height="170" src="<?php echo ResourcesModel::createResourceLink("gallery/small",$image->image); ?>" alt=""/>
                            </a>
                        </div>
                        <?php
                        if ($galleryEdit) {
                            ?>
                            <a href="<?php echo parent::link(array("action"=>"moveImageDown","category"=>$selectedCategoryId,"id"=>$image->id)); ?>"><img src="resource/img/movedown.png" alt="" /></a>
                            <a href="<?php echo parent::link(array("action"=>"moveImageUp","category"=>$selectedCategoryId,"id"=>$image->id)); ?>"><img src="resource/img/moveup.png" alt="" /></a>
                            <a onclick="return confirm('<?php echo parent::getTranslation("gallery.dialog.deleteImage"); ?>');" href="<?php echo parent::link(array("action"=>"deleteImage","category"=>$selectedCategoryId,"id"=>$image->id)); ?>"><img src="resource/img/delete.png" alt=""/></a>
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
    
    function printViewImage ($imageId, $categoryId) {
        
        $image = GalleryModel::getImage($imageId);
        $category = GalleryModel::getCategory($categoryId);
        $event = UserWallModel::getUserWallImageEventByImageId($imageId);
        
        $userId = $this->getModeUserId();
        $imagePosts = UserWallModel::getUserWallPostsByEventId($event->id);
        
        ?>
        <div class="panel galleryPanel viewImage">
            <a href="<?php echo parent::link(array("category"=>$categoryId)); ?>" class="jquiButton">
                <?php echo parent::getTranslation("gallery.button.back"); ?>
            </a>
            <a href="<?php echo parent::link(array("category"=>$categoryId)); ?>" class="jquiButton">
                <?php echo parent::getTranslation("gallery.button.prev"); ?>
            </a>
            <a href="<?php echo parent::link(array("category"=>$categoryId)); ?>" class="jquiButton">
                <?php echo parent::getTranslation("gallery.button.next"); ?>
            </a>
            <hr/>
            <div class="imageContainer">
                <img src="<?php echo ResourcesModel::createResourceLink("gallery",$image->image); ?>" alt="">
            </div>
            <div class="imageComments">
                
                <?php

                if (!empty($imagePosts)) {
                    foreach ($imagePosts as $wallPost) {
                        
                        $srcUser = UsersModel::getUser($wallPost->srcuserid);
                        $srcUserName = $srcUser->firstname." ".$srcUser->lastname;
                        $userProfileImage = UsersModel::getUserImageSmallUrl($srcUser->id);
                        
                        ?>
                        <div class="userWallPostThread">
                            <div class="userWallPost">
                                <div class="userWallPostImage">
                                    <a href="<?php echo parent::staticLink("userProfile",array("userId"=>$srcUser->id)) ?>">
                                        <img src="<?php echo $userProfileImage; ?>" alt="" title="" />
                                    </a>
                                </div>
                                <div class="userWallPostBody">
                                    <div class="userWallPostTitle">
                                        <?php
                                        $allowDelete = false;
                                        $allowEdit = false;
                                        if (Context::getUserId() == $wallPost->srcuserid) {
                                            $allowDelete = true;
                                            $allowEdit = true;
                                        }
                                        if ($userId == Context::getUserId()) {
                                            $allowDelete = true;
                                        }
                                        if ($allowDelete || $allowEdit) {
                                            ?>
                                            <div class="userWallPostTitleTools">
                                            <?php
                                        }
                                        if ($allowDelete) {
                                            ?>
                                            <img src="resource/img/delete.png" alt="" onclick="doIfConfirm('<?php echo parent::getTranslation("userWall.dialog.confirmDelete"); ?>','<?php echo parent::link(array("action"=>"deleteComment","id"=>$wallPost->id,"image"=>$imageId,"category"=>$categoryId),false); ?>');" />
                                            <?php
                                        }
                                        if ($allowEdit) {
                                            ?>
                                            <a href="<?php echo parent::link(array("action"=>"editComment","id"=>$wallPost->id,"image"=>$imageId,"category"=>$categoryId)); ?>">
                                                <img src="resource/img/preferences.png" alt="" />
                                            </a>
                                            <?php
                                        }
                                        if ($allowDelete || $allowEdit) {
                                            ?>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        <div class="userWallPostTitleDate">
                                            <?php echo $wallPost->date; ?>
                                        </div>
                                        <a href="<?php echo parent::staticLink("userProfile",array("userId"=>$srcUser->id)) ?>">
                                            <?php echo $srcUserName; ?>
                                        </a>
                                    </div>
                                    <div class="userWallPostComment">
                                        <?php echo htmlentities($wallPost->comment); ?>
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <?php
                    }
                }
                
                if (UserWallModel::canUserPost($userId)) {
                    $userProfileImage = UsersModel::getUserImageSmallUrl(Context::getUserId());
                    ?>
                    <div class="userWallPostCommentBox">
                        <div class="userWallPostImage">
                            <img src="<?php echo $userProfileImage; ?>" alt="" title="" />
                        </div>
                        <div class="userWallPostBody">
                            <form method="post" action="<?php echo parent::link(array("action"=>"comment","imageId"=>$imageId,"category"=>$categoryId)); ?>">
                                <div class="userWallPostTextarea">
                                    <textarea name="<?php echo parent::alias("comment") ?>"><?php echo htmlentities(parent::post("comment")); ?></textarea>
                                    <?php
                                    $message = parent::getMessage("comment");
                                    if (!empty($message)) {
                                        echo '<span class="validateTips">'.$message.'</span>';
                                    }
                                    ?>
                                </div>
                                <hr/>
                                <div class="alignRight">
                                    <button class="jquiButton" type="submit" name="<?php echo parent::alias("submitButton"); ?>" value="1">
                                        <?php echo parent::getTranslation("userWall.button.comment"); ?>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <?php
                }
                ?>
                
            </div>
        </div>
        <?php
        
    }
	
    function printUploadImage () {
        
        $category = parent::get('category');
        if (!empty($category)) {
            ?>
            <h1><?php echo parent::getTranslation("gallery.upload.title"); ?></h1>
            <p><?php echo parent::getTranslation("gallery.upload.description"); ?></p>
            <?php 
            InputFeilds::printMultiFileUpload("images", parent::ajaxLink(array("action"=>"uploadImage","category"=>$_GET['category'])), "");
            ?>
            <hr/>
            <div class="alignRight">
                <a href="<?php echo parent::link(array("category"=>$category)); ?>" class="jquiButton">
                    <?php echo parent::getTranslation("gallery.button.finnish"); ?>
                </a>
            </div>
            <?php
        }
    }
    
    function printEditCategory ($categoryId = null) {
        
        $parentCategory = parent::get("category");
        
        if ($categoryId == null) {
            $title = ""; 
            $description = ""; 
            $imageId = "";
            $images = array();
        } else {
            $categoryObject = GalleryModel::getCategory($categoryId);
            $title = $categoryObject->title;
            $description = $categoryObject->description;
            $imageId = $categoryObject->image;
            $images = Common::toMap(GalleryModel::getImages($categoryId), "id", "image");
        }
        
        ?>
        <h1><?php echo parent::getTranslation("gallery.category.header"); ?></h1>
        <p><?php echo parent::getTranslation("gallery.category.description"); ?></p>
        <form id="editCategoryForm" action="<?php echo parent::link(array("action"=>"saveCategory","category"=>$parentCategory,"id"=>$categoryId)); ?>" method="post" />
            <table class="formTable"><tr><td>
                <?php echo parent::getTranslation("gallery.category.title"); ?>
            </td><td>
                <?php InputFeilds::printTextFeild("title",$title); ?>
            </td></tr><tr><td>
                <?php echo parent::getTranslation("gallery.category.description"); ?>
            </td><td>
                <?php InputFeilds::printTextArea("description",$description); ?>
            </td></tr><?php
            if ($categoryId != null) {
                ?>
                <tr><td>
                    <?php echo parent::getTranslation("gallery.category.image"); ?>
                </td><td>
                    <?php InputFeilds::printSelect("imageId",$imageId,$images); ?>
                </td></tr>
                <?php
            }
            ?></table>
            <hr/>
            <div class="alignRight">
                <button type="submit" class="jquiButton">
                    <?php echo parent::getTranslation("gallery.category.save"); ?>
                </button>
                <button type="button" class="jquiButton" onclick="callUrl('<?php echo parent::link(array("category"=>$parentCategory)); ?>');"/>
                    <?php echo parent::getTranslation("gallery.category.cancel"); ?>
                </button>
            </div>
        </form>
        <?php
    }
    
    function printEditComment ($commentId, $imageId, $categoryId) {
        
        $comment = UserWallModel::getUserWallPostById($commentId);
        $userProfileImage = UsersModel::getUserImageSmallUrl(Context::getUserId());
        ?>
        <div class="userWallPostCommentBox">
            <div class="userWallPostImage">
                <img src="<?php echo $userProfileImage; ?>" alt="" title="" />
            </div>
            <div class="userWallPostBody">
                <form method="post" action="<?php echo parent::link(array("action"=>"saveComment","id"=>$commentId,"image"=>$imageId,"category"=>$categoryId)); ?>">
                    <div class="userWallPostTextarea">
                        <textarea name="<?php echo parent::alias("comment") ?>"><?php echo htmlentities($comment->comment); ?></textarea>
                        <?php
                        $message = parent::getMessage("comment");
                        if (!empty($message)) {
                            echo '<span class="validateTips">'.$message.'</span>';
                        }
                        ?>
                    </div>
                    <hr/>
                    <div class="alignRight">
                        <button class="jquiButton" type="submit" name="<?php echo parent::alias("submitButton"); ?>" value="1">
                            <?php echo parent::getTranslation("userWall.button.comment"); ?>
                        </button>
                    </div>
                </form>
            </div>
            <div class="clear"></div>
        </div>
        <?php
    }
}

?>
