<?php

require_once 'core/plugin.php';

class SlideshowView extends XModule {
    
    function onProcess () {
        
        if (Context::hasRole("slideshow.edit")) {
            switch (parent::getAction()) {
                case "update":
                    parent::param("gallery", $_POST['gallery']);
                    parent::param("animation", $_POST['animation']);
                    parent::param("controlbar", (isset($_POST['controlbar']) && $_POST['controlbar'] == "1") ? "1" : "0");
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
        return array("js/jquery.easing.min.js","js/supersized.core.3.2.1.min.js","js/supersized.3.2.6.min.js","theme/supersized.shutter.min.js");
    }
    
    function getStyles () {
        return array("css/supersized.core.css","css/supersized.css","theme/supersized.shutter.css");
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
                    <b>Show Control Bar:</b>
                </td><td>
                    <?php
                    InputFeilds::printCheckbox("controlbar", parent::param("controlbar"));
                    ?>
                </td></tr></table>
                <br/><hr/><br/>
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
        $slideshowArgs = "";
        if (count($images) > 0) {
            $slides = array();
            foreach ($images as $image) {
                $slides[] = "{image : '".ResourcesModel::createResourceLink("gallery",$image->image)."', title : '".Common::htmlEscape($image->title)."', thumb : '".ResourcesModel::createResourceLink("gallery/small",$image->image)."', url : ''}";
            }
            $slideshowArgs = implode(",", $slides);
        }
        
        //}
        ?>
        <div class="panel">
            <!--Thumbnail Navigation-->
            <div id="prevthumb"></div>
            <div id="nextthumb"></div>
            <!--Arrow Navigation-->
            <a id="prevslide" class="load-item"></a>
            <a id="nextslide" class="load-item"></a>
            <div id="thumb-tray" class="load-item">
                <div id="thumb-back"></div>
                <div id="thumb-forward"></div>
            </div>
            <!--Control Bar-->
            <?php
            if (parent::param("controlbar") == "1") {
                ?>
                <div id="controls-wrapper" class="load-item">
                    <div id="controls">
                        <a id="play-button"><img id="pauseplay" src="modules/gallery/img/pause.png"/></a>
                        <!--Slide counter-->
                        <div id="slidecounter">
                            <span class="slidenumber"></span> / <span class="totalslides"></span>
                        </div>
                        <!--Slide captions displayed here-->
                        <div id="slidecaption"></div>
                        <!--Thumb Tray button-->
                        <a id="tray-button"><img id="tray-arrow" src="modules/gallery/img/button-tray-up.png"/></a>
                        <!--Navigation-->
                        <ul id="slide-list"></ul>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <script>
        jQuery(function($){
            
            $.supersized({
                slide_interval   : 10000,    // Length between transitions
                transition       : 1,       	
                transition_speed : 1000,     // Speed of transition
                slide_links	 : 'blank', // Individual links for each slide (Options: false, 'num', 'name', 'blank')
                slides           : [        // Slideshow Images
                    <?php echo $slideshowArgs; ?>
                ]
            });
        });
        </script>
        <?php
    }
    
}

?>