<?php

include_once 'core/plugin.php';
include_once 'modules/pinboard/pinboardModel.php';

class PinboardMapModule extends XModule {

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {
        
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
                
                }
                break;
            case "newPinboard":
                parent::focus();
                break;
            case "createPinboard":
                if (Context::hasRole("pinboardMap.create")) {
                    if (parent::post("createPinboard") && Captcha::validateInput('security')) {
                        $messages = PinboardModel::validatePinboard(parent::post("name"), parent::post("description"), parent::post("icon"));
                        if (empty($messages)) {
                            $pinboardId = PinboardModel::createPinboard(parent::post("name"), parent::post("description"), parent::post("icon"), parent::post("locationSelect_lat"), parent::post("locationSelect_lng"), Context::getUserId());
							NavigationModel::redirectStaticModule("pinboard", array("pinboardId"=>$pinboardId));
                        } else {
                            parent::setMessages($messages);
                        }
                    } else {
                    	parent::setMessages(array("security"=>"Your answer was wrong, try this code!"));
                    }
                }
                break;
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
            case "createPinboard":
            case "newPinboard":
            	if (Context::hasRole("pinboardMap.create")) {
            		$this->printNewPinboardView();
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
    	// https://maps.googleapis.com/maps/api/js
    	//return array("https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=map,places", "js/pinboardMap.js", "js/locationSelectMap.js");
    	return array("https://maps.googleapis.com/maps/api/js?libraries=map,places", "js/pinboardMap.js", "js/locationSelectMap.js");
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
                    var center = $(".gMapHolder").pinboardMap("getCenter");
                    var zoom = $(".gMapHolder").pinboardMap("getZoom");
                    callUrl("<?php echo parent::link(array("action"=>"newPinboard")); ?>", {"lat": center.lat, "lng": center.lng, "zoom": zoom});
                    return false;
                });
                $(".gMapHolder").pinboardMap({
                    dataUrl: "<?php echo parent::ajaxLink(array("action"=>"getPinboards")); ?>",
                    viewUrl: "<?php echo parent::staticLink("pinboard", array(), false); ?>"
                });
            });
            </script>
        
        </div>
        <?php
    }
    
    function printNewPinboardView () {
        
        $icons = IconModel::getIcons();
        
        ?>
        <div class="panel pinboardMapNewPanel">
            
            <form method="post" action="<?php echo parent::link(array("action"=>"createPinboard")); ?>">
                
                <input name="lat" type="hidden" value="" />
                <input name="lng" type="hidden" value="" />
                
                <h1><?php echo parent::getTranslation("pinboardMap.new.title"); ?></h1>
                <p><?php echo parent::getTranslation("pinboardMap.new.description"); ?></p>
                
                <table class="formTable"><tr><td>
                    <?php echo parent::getTranslation("pinboardMap.new.name"); ?>
                </td><td>
                    <input name="name" type="text" value="<?php echo htmlentities(parent::post("name"), ENT_QUOTES); ?>" placeholder="<?php echo parent::getTranslation("pinboardMap.new.name.placeholder"); ?>" />
                    <?php
                    $message = parent::getMessage("name");
                    if (!empty($message)) {
                        echo '<span class="validateTips">'.$message.'</span>';
                    }
                    ?>
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("pinboardMap.new.description"); ?>
                </td><td>
                    <textarea name="description" placeholder="<?php echo parent::getTranslation("pinboardMap.new.description.placeholder"); ?>"><?php 
                    	echo htmlentities(parent::post("description"));
                    ?></textarea>
                    <?php
                    $message = parent::getMessage("description");
                    if (!empty($message)) {
                        echo '<span class="validateTips">'.$message.'</span>';
                    }
                    ?>
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("pinboardMap.new.location"); ?>
                </td><td>
                    <div class="locationSelect"></div>
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("pinboardMap.new.icon"); ?>
                </td><td>
                	<input type="hidden" name="icon" value="<?php 
                	if (parent::post("icon")) {
                		echo parent::post("icon");
                	} else {
                		echo current($icons)->id;
                	}
                	?>" />
                    <ol class="icons">
                        <?php
                        $first = true;
                        foreach ($icons as $icon) {
                            $class = "";
	                        if (parent::post("icon")) {
	                        	if (parent::post("icon") == $icon->id) {
		                			$class = "ui-selected";
	                        	}
		                	} else if ($first) {
		                		$class = "ui-selected";
		                		$first = false;
		                	}
                        	?>
                            <li class="icon icon_<?php echo $icon->id." ".$class; ?>">
                            	<img src="<?php echo $icon->iconfile; ?>" alt="" />
                            </li>
                            <?php
                        }
                        ?>
                    </ol>
                    <div class="clear"></div>
                    <script type="text/javascript">
					$(".pinboardMapNewPanel .icons").selectable({
						"filter": ".icon",
			            "selected": function( event, ui ) {
							$(".pinboardMapNewPanel input[name=icon]").val($.grep(ui.selected.className.split(" "), function(v, i){
						       return v.indexOf('icon_') === 0;
						   	}).join().substr(5));
						}
					});
                    </script>
                    <?php
                    $message = parent::getMessage("icon");
                    if (!empty($message)) {
                        echo '<span class="validateTips">'.$message.'</span>';
                    }
                    ?>
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("pinboardMap.new.security"); ?>
                </td><td>
                    <?php
                    InputFeilds::printCaptcha("security");
                    $message = parent::getMessage("security");
                    if (!empty($message)) {
                        echo '<span class="validateTips">'.$message.'</span>';
                    }
                    ?>
                </td></tr></table>
                
                <hr/>
                <div class="alignRight">
                    <button type="submit" name="createPinboard" value="1"><?php echo parent::getTranslation("pinboardMap.new.submit"); ?></button>
                    <button type="submit" name="cancel"><?php echo parent::getTranslation("pinboardMap.new.cancel"); ?></button>
                </div>
                
            </form>
            
        </div>
        <script type="text/javascript">
        $(".pinboardMapNewPanel .locationSelect").locationSelectMap({
            "lat": <?php echo parent::get("lat"); ?>, 
            "lng": <?php echo parent::get("lng"); ?>,
            "zoom": <?php echo parent::get("zoom"); ?>,
            "inputName": "locationSelect"
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
