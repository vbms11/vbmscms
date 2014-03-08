<?php

require_once('core/plugin.php');
require_once('modules/gallery/galleryModel.php');

class GalleryView extends XModule {
    
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
                    GalleryModel::uploadImage("fileData",parent::get("category"));
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
                        GalleryModel::deleteImage(parent::get("image"));
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
            default:
                parent::blur();
        }
    }
    
    function onView () {
        
        switch ($this->getAction()) {
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
        return array("css/gallery.css");
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
                    <button type="submit"><?php echo parent::getTranslation("common.save"); ?></button>
                </div>
            </form>
        </div>
        <?php
    }
    
    function getAllowUserEdit () {
        $allowUserEdit = false;
        switch (parent::param("mode")) {
            case self::modeCurrentUserGallery:
                if (Context::hasRole("gallery.owner")) {
                    $allowUserEdit = true;
                }
                break;
            case self::modeSelectedUserGallery:
                if (Context::getUserId() == Context::getSelectedUserId() && Context::hasRole("gallery.owner")) {
                    $allowUserEdit = true;
                }
            case self::modeModuleGallery:
            default:
                if (Context::hasRole("gallery.edit")) {
                    $allowUserEdit = true;
                }
        }
        return $allowUserEdit;
    }
    
    function getGalleryPage () {
        $galleryPage = null;
        switch (parent::param("mode")) {
            case self::modeCurrentUserGallery:
                if (Context::hasRole("gallery.owner")) {
                    $galleryPage = GalleryModel::getUserGallery(Context::getUserId());
                }
                break;
            case self::modeSelectedUserGallery:
                $galleryPage = GalleryModel::getUserGallery(Context::getSelectedUserId());
            case self::modeModuleGallery:
            default:
                $galleryPage = GalleryModel::getPageGallery(parent::getId());
        }
        return $galleryPage;
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
                    <div align="center" class="galleryGrid">
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
                    <div align="center" class="galleryGrid <?php echo $imageCss; ?>">
                        <div class="galleryGridImage galleryImages shadow">
                            <a href="<?php echo ResourcesModel::createResourceLink("gallery",$image->image); ?>">
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
        <script type="text/javascript">
        $(function() {
            $('.galleryImages a').lightBox();
        });
        </script>
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
                <?php InputFeilds::printTextArea("description",$title); ?>
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
    
    
}

?>