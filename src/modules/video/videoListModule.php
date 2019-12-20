<?php

require_once('core/plugin.php');

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
    
    function printListView () {
        
        $category = CategoryModel::getSelectedCategory();
        $videoIds = CategoryModel::getAssigned($category, CategoryModel::type_video);
        $videos = VideoModel::getVideoByIds($videoIds);
        
        ?>
        <div class="panel videoPanel">
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
        <?php    
    }

    
}

?>