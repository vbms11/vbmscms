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
        <script type="text/javascript">
        $(".mapHolder").pinboardMap({
            dataUrl: "<?php echo parent::ajaxLink(array("action"=>"getPinboards")); ?>"
        });
        </script>
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
