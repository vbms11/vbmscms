<?php

require_once 'core/plugin.php';

class SlideshowView extends XModule {
    
    function onProcess () {
        
        if (Context::hasRole("slideshow.edit")) {
            switch (parent::getAction()) {
                case "update":
                    parent::param("gallery", $_POST['gallery']);
                    parent::param("animation", $_POST['animation']);
                    parent::param("time", $_POST['time']);
                    parent::blur();
                    parent::redirect();
                    break;
                case "edit":
                    parent::focus();
                    break;
            }
        }
    }
    
    function onView () {
        
        switch (parent::getAction()) {
            case "edit":
                $this->renderEditView();
                break;
            default:
                $this->renderMainView();
        }
    }
    
    
    function getRoles () {
        return array("slideshow.edit");
    }
    
    function getScripts () {
        return array("js/gallery.js");
    }
    
    function getStyles () {
        return array("css/slideshow.css");
    }
    
    function renderEditView () {
        $categorys = GalleryModel::getCategorys();
        $categorysMap = Common::toMap($categorys,"id","title");
        ?>
        <div class="panel slideshowPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"update")); ?>">
                <table class="expand"><tr><td class="nowrap">
                    <b>Selected Gallery:</b>
                </td><td class="expand">
                    <?php
                    InputFeilds::printSelect("gallery", parent::param("gallery"), $categorysMap);
                    ?>
                </td></tr><tr><td class="nowrap">
                    <b>Animation:</b>
                </td><td>
                    <?php
                    InputFeilds::printSelect("animation", parent::param("animation"), array("0"=>"None", "1"=>"Fade", "2"=>"Slide Top", "3"=>"Slide Right", "4"=>"Slide Bottom", "5"=>"Slide Left", "6"=>"Carousel Right", "7"=>"Carousel Left"));
                    ?>
                </td></tr><tr><td class="nowrap">
                    <b>Animation Interval:</b>
                </td><td>
                    <?php
                    InputFeilds::printTextFeild("time", parent::param("time"));
                    ?>
                </td></tr>
                </table>
                <hr/>
                <div class="alignRight">
                    <button id="btnSave" type="submit">Save</button>
                </div>
            </form>
        </div>
        <script>
        $(".slideshowPanel button").button();
        </script>
        <?php
    }
    
    function renderMainView() {
        $images = GalleryModel::getImages(parent::param("gallery"));
        ?>
        <div class="panel slideshowPanel">
            <div id="<?php echo parent::alias("slideshow"); ?>" class="slideshow">
                <div class="slideshowNumbers">
                    <?php
                    for ($i=0; $i<count($images); $i++) {
                        echo "<div class='slideshowNumber'>".($i+1)."</div>";
                    }
                    ?>
                </div>
                <?php
                if (count($images) > 0) {
                    foreach ($images as $image) {
                        ?>
                        <img src="<?php echo Resource::createResourceLink("gallery",$image->image); ?>" alt=""/>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
        <script>
        initSlideshow("#<?php echo parent::alias("slideshow"); ?>","<?php echo parent::param("time")*1000; ?>");
        </script>
        <?php
    }
    
}

?>