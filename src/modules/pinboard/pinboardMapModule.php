<?php

include_once 'core/plugin.php';

class PinboardMapModule extends XModule {

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {
        
        if (Context::hasRole("wysiwyg.edit")) {
            
            switch (parent::getAction()) {
                case "save":
                    if (Context::hasRole("pinboardMap.edit")) {
                        parent::param("mapContainer", parent::post("mapContainer"));
                        parent::blur();
                        parent::redirect();
                    }
                    break;
                case "edit":
                    if (Context::hasRole("pinboardMap.edit")) {
                        parent::focus();
                    }
                    break;
                case "cancel":
                    parent::blur();
                    break;
                case "getPinboards":
                    $pinboards = PinboardModel::getPinbords(parent::get("minLng"), parent::get("minLat"), parent::get("maxLng"), parent::get("maxLat"));
                    Context::setReturnValue(json_encode($pinboards));
                    break;
                case "setPinboardLocation":
                    if (Context::hasRole("pinboardMap.create")) {
                        NavigationModel::redirectStaticModule("pinboard", array("action"=>"createPinboard", "lng"=>parent::get("lng"), "lat"=>parent::get("lat")));
                    }
                    break;
                case "newPinboard":
                    parent::focus();
                    break;
                case "createPinboard":
                    if (Context::hasRole("pinboardMap.create")) {
                        if (parent::post("createPinboard")) {
                            
                            $messages = PinboardModel::validatePinboard(parent::post("name"), parent::post("description"), parent::post("icon"));
                            if (empty($messages)) {
                                PinboardModel::createPinboard(parent::post("name"), parent::post("description"), parent::post("icon"), parent::post("lat"), parent::post("lng"), Context::getUserId());
                            } else {
                                parent::setMessages($messages);
                                break;
                            }
                            
                        }
                    }
                    parent::blur();
                    break;
            }
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {

        switch (parent::getAction()) {
            case "edit":
                if (Context::hasRole("pinboardMap.edit")) {
                    $this->printEditView();
                }
                break;
            case "newPinboard":
                $this->printNewPinboardView();
                break;
            case "createPinboard":
                break;
            default:
                $this->printMainView();
        }
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("pinboardMap.edit", "pinboardMap.create");
    }

    function getStyles () {
    	return array("css/pinboardMap.css");
    }
    
    function getScripts () {
    	return array("https://maps.googleapis.com/maps/api/js", "js/pinboardMap.js");
    }

    function printMainView () {

        ?>
        <div class="panel pinboardMapPanel">
            
            <div class="buttonsHolder">
                <a href="<?php echo parent::link(array("action"=>"newPinboard")); ?>" class="newPinboardButton">
                    <img src="modules/pinboard/img/newPinboard.png" alt="" />
                </a>
            </div>
            
            <script type="text/javascript">
            $(function(){
                $(".pinboardMapPanel .newPinboardButton").click(function () {
                    
                });
                $(".gMapHolder").pinboardMap({
                    dataUrl: "<?php echo parent::ajaxLink(array("action"=>"getPinboards")); ?>"
                });
            });
            </script>
        
        </div>
        <?php
    }
    
    function printNewPinboardView () {
        
        $icons = IconModel::getIcons();
        
        ?>
        <div class="panel pinboardMapPanel">
            
            <form method="post" action="<?php echo parent::link(array("action"=>"createPinboard")); ?>">
                
                <input name="lat" type="hidden" value="" />
                <input name="lng" type="hidden" value="" />
                
                <h1><?php echo parent::getTranslation("pinboardMap.new.title"); ?></h1>
                <p><?php echo parent::getTranslation("pinboardMap.new.description"); ?></p>
                
                <table><tr><td>
                    <?php echo parent::getTranslation("pinboardMap.new.name"); ?>
                </td><td>
                    <input name="name" type="text" value="" placeholder="<?php echo parent::getTranslation("pinboardMap.new.name.placeholder"); ?>" />
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("pinboardMap.new.description"); ?>
                </td><td>
                    <textarea name="description" placeholder="<?php echo parent::getTranslation("pinboardMap.new.description.placeholder"); ?>"></textarea>
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("pinboardMap.new.icon"); ?>
                </td><td>
                    <input type="hidden" value="" />
                    <?php
                    foreach ($icons as $icon) {
                        ?>
                        <div class="iconOption"></div>
                        <?php
                    }
                    ?>
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("pinboardMap.new.security"); ?>
                </td><td>
                    <?php
                    InputFeilds::printCaptcha("security");
                    ?>
                </td></tr></table>
                
                <hr/>
                <div class="alignRight">
                    <button type="submit" name="createPinboard" value="1"><?php echo parent::getTranslation("pinboardMap.new.submit"); ?></button>
                    <button type="submit" name="cancel"><?php echo parent::getTranslation("pinboardMap.new.cancel"); ?></button>
                </div>
                
            </form>
            
        </div>
        <?php
    }
    
    function printEditView () {
	
        ?>
        <div class="panel pinboardMapEditPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"save")); ?>">
                <table class="formTable"><tr><td>
			        <?php echo parent::getTranslation("pinboardMap.edit.label.mapContainer"); ?>
        		</td><td>
			        <input type="text" value="<?php echo parent::param("mapContainer");  ?>"  />
        		</td></tr></table>
                <hr/>
                <div class="alignRight">
                    <button type="submit" class="jquiButton btnSave"><?php echo parent::getTranslation("common.save"); ?></button>
                    <button type="button" class="jquiButton btnCancel"><?php echo parent::getTranslation("editor.label.cancel"); ?></button>
                </div>
            </form>
        </div>
    	<script>
        $(".btnCancel").click(function () {
        	callUrl("<?php echo parent::link(array("action"=>"cancel")); ?>");
    	});
    	</script>
        <?php
    }
}

?>
