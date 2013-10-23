<?php

require_once('core/plugin.php');
require_once('modules/gallery/galleryModel.php');

class GalleryView extends XModule {
    
    const modePageGallery = 1;
    const modeUserGallery = 2;
    const modeCurrentUserGallery = 3;
    const modeSelectedUserGallery = 4;
    
    function onProcess () {
        
        if (Context::hasRole("gallery.edit")) {
            switch (parent::getAction()) {
                case "imageDetail":
                    // add images to database with details
                    $images = GalleryModel::getUploadedImages();
                    foreach ($images as $image) {
                        GalleryModel::nameUploadedImages($_GET['category'], $image, $_POST['titel_'.$image], $_POST['description_'.$image]);
                    }
                    GalleryModel::clearUploadedImages();
                    parent::blur();
                    parent::redirect(array("category"=>$_GET['category']));
                    break;
                case "uploadImage":
                    // uploads the image and create preview image
                    GalleryModel::uploadImage("fileData",$_GET['category']);
                    Context::returnValue("");
                    break;
                case "update":
                    // updates the details of an image or category
                    if (isset($_GET['image'])) {
                        // update image
                    } else if (isset($_GET['id'])) {
                        GalleryModel::updateCategory($_GET['id'], $_POST['title'], $_POST['imageId'], $_POST['description']);
                    }
                    parent::blur();
                    parent::link(array("category"=>$_GET['category']));
                    break;
                case "create":
                    // craetes a category
                    GalleryModel::createCategory($_POST['title'], $_POST['description'], null, $_GET['parent']);
                    parent::blur();
                    parent::redirect();
                    break;
                case "delete":
                    if (isset($_GET['image'])) {
                        GalleryModel::deleteImage($_GET['image']);
                    } else if (isset($_GET['id'])) {
                        GalleryModel::deleteCategory($_GET['id']);
                    }
                    parent::blur();
                    parent::redirect(array("category"=>$_GET['category']));
                    break;
                case "new":
                    GalleryModel::clearUploadedImages();
                    parent::focus();
                    break;
                case "back":
                    parent::blur();
                    parent::redirect(array("category"=>$_GET['category']));
                    break;
                case "moveup":
                    if (isset($_GET['image'])) {
                        DataModel::swapPhysical("t_galleryimage", "orderkey", $_GET['image'], $_GET['dstId']);
                    } else {
                        DataModel::swapPhysical("t_gallerycategory", "orderkey", $_GET['id'], $_GET['dstId']);
                    }
                    parent::redirect(array("category"=>$_GET['category']));
                    break;
                case "movedown":
                    if (isset($_GET['image'])) {
                        DataModel::swapPhysical("t_galleryimage", "orderkey", $_GET['image'], $_GET['dstId']);
                    } else {
                        DataModel::swapPhysical("t_gallerycategory", "orderkey", $_GET['id'], $_GET['dstId']);
                    }
                    parent::redirect(array("category"=>$_GET['category']));
                    break;
                case "describeImage":
                    parent::focus();
                    break;
            }
        }
    }
    
    function onView () {
        
        switch ($this->getAction()) {
            case "uploadImage":
                
                break;
            case "new":
                if (Context::hasRole("gallery.edit")) {
                    if (isset($_GET['category'])) {
                        $this->printUploadImage();
                    } else {
                        $this->printEditCategory();
                    }
                }
                break;
            case "describeImage":
                if (Context::hasRole("gallery.edit")) {
                    $this->printDescribeImage();
                }
                break;
            case "edit":
                if (Context::hasRole("gallery.edit")) {
                    if (isset($_GET['image'])) {
                        $this->printUploadImage();
                    } else {
                        $this->printEditCategory();
                    }
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
        return array(); // array("resource/js/prototype.js","resource/js/scriptaculous.js?load=effects","resource/js/lightbox.1.2.js");
    }
    
    function getStyles () {
        return array("css/gallery.css");
    }
    
    function getRoles () {
        return array("gallery.edit","gallery.view");
    }
    
    static function getTranslations() {
        return array(
            "en" => array(
                "gallery.category.description" => "Edit information about this image category.",
                "gallery.category.header" => "Image Category",
                "gallery.category.title" => "Title of the image:",
                "gallery.category.category" => "Description of the category:",
                "gallery.category.image" => "Preview Image:",
                "gallery.category.save" => "Save",
                "gallery.category.cancel" => "Cancel"
            ),
            "de" => array(
                "gallery.category.description" => "Information uber deise bild categorie editeiren.",
                "gallery.category.header" => "Bild Categorie",
                "gallery.category.title" => "Title von die categorie:",
                "gallery.category.category" => "Beshreibung von die categorie:",
                "gallery.category.image" => "Vorshau bild:",
                "gallery.category.save" => "Absenden",
                "gallery.category.cancel" => "Abbrechen"
            ));
    }
    
    function printGallery () {
        
        Context::addRequiredStyle("resource/js/lightbox/css/jquery.lightbox-0.5.css");
        Context::addRequiredScript("resource/js/lightbox/js/jquery.lightbox-0.5.pack.js");
        
        ?>
        <div class="galleryContainer">
            <?php
            switch (parent::param("mode")) {
                case self::modePageGallery:
                    $galleryPage = GalleryModel::getGallery(parent::getId());
                    break;
                case self::modeUserGallery:
                    // $galleryPage = UsersModel::getUserGallery($_GET['userid']);
                    break;
                case self::modeCurrentUserGallery:
                    $galleryPage = UsersModel::getUserGallery(Context::getUserId());
                    break;
                case self::modeSelectedUserGallery:
                    $galleryPage = UsersModel::getUserGallery(Context::getSelectedUserId());
                    break;
            }
            $galleryPage = GalleryModel::getGallery(parent::getId());
            $selCategory = isset($_GET['category']) ? $_GET['category'] : $galleryPage->rootcategory;
            $gallerypage = isset($_GET['gallerypage']) ? $_GET['gallerypage'] : 0;
            $images = GalleryModel::getImages($selCategory);
            $categorys = GalleryModel::getCategorys($selCategory);
            ?>

            <?php /*
             | <a href="<?php echo NavigationModel::createModuleLink($this->moduleId,array("action"=>"active","active"=>$active)); ?>">
                <?php if ($active) { echo 'Deaktivieren'; } else { echo 'Aktivieren'; } ?>
            </a>
             */
            ?>
            <table cellpadding="0" cellspacing="0" border="0"><tr><td>
            <div class="galleryButtons">
                <?php
                if (isset($_GET['category'])) {
                    ?>
                    <a href="<?php echo NavigationModel::createModuleLink($this->getId(),array()); ?>">Back</a>
                    <?php
                } 
                if (Context::hasRole("gallery.edit")) {
                    ?>
                    <a href="<?php echo parent::link(array("action"=>"new","parent"=>$selCategory)); ?>">New Category</a>
                    <a href="<?php echo parent::link(array("action"=>"new","category"=>$selCategory)); ?>">Bild hochladen</a>
                    <?php
                }
                ?>
                <?php
                /*
                if ($pageCount > 1) {
                    echo " | Seite: ";
                    for ($i=0; $i<$imageCount; $i++) {
                        $href = NavigationModel::createModuleLink($this->moduleId,array("category"=>$selCategory,"gallerypage"=>$i));
                        echo "<a href='$href'>".($i+1)."</a>";
                        if ($i+1 < $imageCount)
                            echo " | ";
                    }
                }
                */
                ?>
            </div>
            <br/>
            </td></tr><tr><td>
                <div align="center">
                    <?php
                    $countCategorys = count($categorys);
                    for ($i=0; $i<count($categorys); $i++) {
                        $prevId = $i == 0 ? -1 : $categorys[$i-1]->id;
                        $nextId = $i == $countCategorys - 1 ? -1 : $categorys[$i+1]->id;
                        $category = $categorys[$i];
                        ?>
                        <div align="center" class="galleryGrid">
                            <div class="galleryGridImage shadow">
                                <a href="<?php echo NavigationModel::createModuleLink($this->getId(),array("category"=>$category->id)); ?>">
                                    <img class="imageLink" width="170" height="170" src="<?php echo Common::isEmpty($category->filename) ? "resource/img/icons/Clipboard.png" : ResourcesModel::createResourceLink("gallery/small",$category->filename); ?>" alt=""/>
                                </a>
                            </div>
                            <div class="galleryGridTitle">
                                <?php echo $category->title; ?>
                            </div>    
                            <?php
                            if (Context::hasRole("gallery.edit")) {
                                ?>
                                <div class="galleryGridTools">
                                    <a href="<?php echo NavigationModel::createModuleLink($this->getId(),array("action"=>"edit","category"=>$selCategory,"id"=>$category->id)); ?>"><img src="resource/img/edit.png" class="imageLink" alt="" title="edit" /></a>
                                    <a href="<?php echo NavigationModel::createModuleLink($this->getId(),array("action"=>"movedown","id"=>$category->id,"category"=>$selCategory,"dstId"=>$prevId)); ?>"><img src="resource/img/movedown.png" class="imageLink" alt="" /></a>
                                    <a href="<?php echo NavigationModel::createModuleLink($this->getId(),array("action"=>"moveup","id"=>$category->id,"category"=>$selCategory,"dstId"=>$nextId)); ?>"><img src="resource/img/moveup.png" class="imageLink" alt="" /></a>
                                    <a onclick="return confirm('Wollen Sie wirklich diese Seite l&�umlschen?')" href="<?php echo NavigationModel::createModuleLink($this->getId(),array("action"=>"delete","category"=>$selCategory,"id"=>$category->id)); ?>"><img src="resource/img/delete.png" class="imageLink" alt=""/></a>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                    $countImages = count($images);
                    for ($i=0; $i<$countImages; $i++) {
                        $prevId = $i == 0 ? -1 : $images[$i-1]->id;
                        $nextId = $i == $countImages - 1 ? -1 : $images[$i+1]->id;
                        $image = $images[$i];
			$imageCss = "";
                        if (Context::hasRole("gallery.edit")) 
                            $imageCss = "galleryGridAdmin";
                        ?>
                        <div align="center" class="galleryGrid <?php echo $imageCss; ?>">
                            <div class="galleryGridImage galleryImages shadow">
                                <a href="<?php echo ResourcesModel::createResourceLink("gallery",$image->image); ?>">
                                    <img class="imageLink" width="170" height="170" src="<?php echo ResourcesModel::createResourceLink("gallery/small",$image->image); ?>" alt=""/>
                                </a>
                            </div>
                            <?php
                            if (Context::hasRole("gallery.edit")) {
                                ?>
                                <a href="<?php echo parent::link(array("action"=>"edit","image"=>$image->id,"category"=>$selCategory,"gallerypage"=>$gallerypage)); ?>"><img src="resource/img/edit.png" class="imageLink" alt="" title="edit" /></a>
                                <a href="<?php echo parent::link(array("action"=>"movedown","image"=>$image->id,"category"=>$selCategory,"gallerypage"=>$gallerypage,"dstId"=>$prevId)); ?>"><img src="resource/img/movedown.png" class="imageLink" alt="" /></a>
                                <a href="<?php echo parent::link(array("action"=>"moveup","image"=>$image->id,"category"=>$selCategory,"gallerypage"=>$gallerypage,"dstId"=>$nextId)); ?>"><img src="resource/img/moveup.png" class="imageLink" alt="" /></a>
                                <a onclick="return confirm('Wollen Sie wirklich dieses Bild l&�umlschen?')" href="<?php echo parent::link(array("action"=>"delete","image"=>$image->id,"category"=>$selCategory,"gallerypage"=>$gallerypage)); ?>">
                                    <img src="resource/img/delete.png" class="imageLink" alt=""/>
                                </a>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </td></tr><tr><td>
                <div>
                    <?php
                    /*
                    if ($pageCount > 1) {
                        echo "Seite: ";
                        for ($i=0; $i<$imageCount; $i++) {
                            $href = NavigationModel::createModuleLink($this->moduleId,array("category"=>$selCategory,"gallerypage"=>$i));
                            echo "<a href='$href'>".($i+1)."</a>";
                            if ($i+1 < $imageCount)
                                echo " | ";
                        }
                    }
                    */
                    ?>
                </div>
            </td></tr></table>
            <script type="text/javascript">
            $(function() {
                $('.galleryImages a').lightBox();
                $('.galleryButtons a').each(function(index,object) {
                    $(object).button();
                });
            });
            </script>
            <?php
            ?>
            <br clear="left"/>
        </div>
        <?php    
    }
    
    function printDescribeImage () {
        InfoMessages::printInfoMessage("gallery.describeimage");
        ?>
        <br/>
        <form method="post" action="<?php echo parent::link(array("action"=>"imageDetail","category"=>$_GET['category'])); ?>">
            
            <div class="panel galleryDescribePanel">   
            <?php
            $images = GalleryModel::getUploadedImages();
            foreach ($images as $image) {
                ?>
                <div>
                    <img src="<?php echo ResourcesModel::createResourceLink("gallery/small", $image) ?>" alt="" />
                    <div>
                        Titel of the image:<br/>
                        <?php InputFeilds::printTextFeild("titel_".$image, ""); ?>
                        <br/><br/>
                        Description of the image:<br/>
                        <?php InputFeilds::printTextArea("description_".$image, ""); ?>
                    </div>
                </div>
                <?php
            }
            ?>
            </div>
            <br/>
            <hr/>
            <div class="toolButtonDiv">
                <button type="submit">Next</button>
            </div>
        </form>
        <?php
    }
	
    function printUploadImage () {
        $title = ""; $description = ""; $imageFile = ""; $category = $_GET['category'];
        if (isset($_GET['image'])) {
            $image = GalleryModel::getImage($_GET['image']);
            $title = $image->title;
            $description = $image->description;
            $imageFile = $image->image;
            
        }
        InfoMessages::printInfoMessage("Here you can create and edit an image in the gallery.");
        ?>
        
        <br/><h3>Upload gallery images:</h3><br/>
        
        <?php InputFeilds::printMultiFileUpload("images", parent::ajaxLink(array("action"=>"uploadImage","category"=>$_GET['category'])), "") ?>
        



       <?php
        /*
        $link = parent::ajaxLink(array("action"=>"uploadImage","category"=>$_GET['category']));
        $params = NavigationModel::getLinkParams($link);
        $paramMap = array();
        $postParams = "";
        foreach ($params as $key => $param) {
            $paramMap[] = "'$key':'$param'";
        }
        $postParams = "{".implode(",", $paramMap)."}";
                    
        var swfu;
        var settings = {   
            flash_url : "resource/js/swfupload/swfupload.swf",
            upload_url: "<?php echo $link; ?>",
            post_params: <?php echo $postParams ?>,
            file_size_limit : "5 MB",
            file_types : "*.*",
            file_types_description : "All Files",
            file_upload_limit : 100,
            file_queue_limit : 0,
            custom_settings : {
                progressTarget : "fsUploadProgress",
                cancelButtonId : "btnCancel"
            },
            debug: false,

            // Button settings
            // button_image_url : "resource/js/swfupload/img/SmallSpyGlassWithTransperancy_17x18.png",
            button_placeholder_id : "spanButtonPlaceHolder",
            button_width: 180,
            button_height: 20,
            button_text : '<span class="button">Select Images <span class="buttonSmall">(5MB Max)</span></span>',
            button_text_style : '.button { font-family: Arial; font-size: 12pt; } .buttonSmall { font-size: 10pt; }',
            button_text_top_padding: 0,
            button_text_left_padding: 18,
            button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
            button_cursor: SWFUpload.CURSOR.HAND,

            // The event handler functions are defined in handlers.js
            file_queued_handler : fileQueued,
            file_queue_error_handler : fileQueueError,
            file_dialog_complete_handler : fileDialogComplete,
            upload_start_handler : uploadStart,
            upload_progress_handler : uploadProgress,
            upload_error_handler : uploadError,
            upload_success_handler : uploadSuccess,
            upload_complete_handler : uploadComplete,
            queue_complete_handler : queueComplete	// Queue plugin event
        };
        swfu = new SWFUpload(settings);
        * *
         */
         
    }
    
    
    
    function printEditCategory () {
        
        $category = null; 
        $categoryId = ""; 
        $description = ""; 
        $imageFile = ""; 
        $images = array();
        $title = ""; 
        $parent = null;
        
        if (isset($_GET['parent'])) {
            $parent = $_GET['parent'];
        } 
        if (isset($_GET['id'])) {
            $categoryId = $_GET['id'];
            $category = GalleryModel::getCategory($categoryId);
            $title = $category->title;
            $description = $category->description;
            $imageFile = $category->image;
            $imagesArray = GalleryModel::getImages($_GET['id']);
            $images = Common::toMap($imagesArray, "id", "image");
        }
        InfoMessages::printInfoMessage(parent::getTranslation("gallery.category.description"));
        ?>
        <form id="editCategoryForm" action="<?php echo parent::link(array("action"=>$category==null?"create":"update","id"=>isset($_GET['id']) ? $_GET['id'] : "","category"=>isset($_GET['category']) ? $_GET['category'] : "","parent"=>isset($_GET['parent']) ? $_GET['parent'] : "")); ?>" method="post" />
            <h3><?php echo parent::getTranslation("gallery.category.header"); ?></h3>
            <label for="title"><?php echo parent::getTranslation("gallery.category.title"); ?></label>
            <div><input type="textbox" class="expand" name="title" value="<?php echo htmlspecialchars($title,ENT_QUOTES); ?>"/></div>
            <label for="description"><?php echo parent::getTranslation("gallery.category.description"); ?></label>
            <div><textarea name="description" class="expand" cols="4" rows="3"><?php echo htmlspecialchars($description,ENT_QUOTES); ?></textarea></div>
            <label for="imageId"><?php echo parent::getTranslation("gallery.category.image"); ?></label>
            <div><?php InputFeilds::printSelect("imageId", $imageFile, $images); ?></div>
            <hr/>
            <div class="alignRight">
                <button type="submit"><?php echo parent::getTranslation("gallery.category.save"); ?></button>
                <button type="button" onclick="callUrl('<?php echo NavigationModel::createModuleLink($this->getId(),array("action"=>"back","category"=>$parent)); ?>');"/>
                    <?php echo parent::getTranslation("gallery.category.cancel"); ?>
                </button>
            </div>
        </form>
        <script>
        $("#editCategoryForm button").button();
        </script>
        <?php
    }
    
    
}

?>