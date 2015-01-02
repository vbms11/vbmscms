<?php

include_once 'core/plugin.php';
include_once 'modules/editor/wysiwygPageModel.php';

class WysiwygPageView extends XModule {

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {
        
        if (Context::hasRole("wysiwyg.edit")) {
            
            switch (parent::getAction()) {
                case "update":
			
                    parent::redirect();
                    parent::blur();
                    break;
                case "edit":
                    parent::focus();
                    break;
                case "cancel":
                    parent::blur();
            }
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {
        
        switch (parent::getAction()) {
            case "edit":
                if (Context::hasRole("wysiwyg.edit")) {
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
        return array("wysiwyg.edit");
    }

function getStyles () {
	return array("css/mapStyles");
}

function getScripts () {
	return array("https://maps.googleapis.com/maps/api/js");
}



    /**
     * returns search results for given text
     */
    function search ($searchText, $lang) {
        return WysiwygPageModel::search($searchText,$lang);
    }

    function printMainView () {

        ?>
        <div class="panel addressMapPanel <?php echo parent::alias("mapContainer"); ?>">
	
	<style>
      #map_canvas {
        width: 500px;
        height: 400px;
      }
    </style>
<script type="text/javascript">	


// find coordinate from address
	var map_<?php echo parent::alias("jsmap"); ?> = null;
	var place = $(".<?php echo parent::alias("mapContainer"); ?>").find(".address").val()
	if (place != "") {
		updateCoordinatesByPlace(elX, elY, place, function () {
			
			// when address has been changed
			// move map to new position
	 	});
	}
	



	// make map with center on coordinates

	
	function initialize() {

        var mapCanvas = document.getElementById('map_canvas');
        var mapOptions = {
          center: new google.maps.LatLng(<?php echo parent::param("addressLat"); ?>, <?php echo parent::param("addressLng"); ?>),
          zoom: 8,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(mapCanvas, mapOptions)
      }
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    
	<div id="map_canvas"></div>
       
        <?php
    }

    function printEditView () {
	
        ?>
        <div class="panel wysiwygPanel <?php echo parent::alias("addressForm"); ?>">
            <form method="post" action="<?php echo parent::link(array("action"=>"update")); ?>">
                <table class="formTable"><tr><td>
			<?php echo htmlspecialchars(parent::getTranslation("addressMap.address")); ?>			
			<textarea name="address">
				<?php echo htmlspecialchars(parent::param("address")); ?>
			</textarea>
		</td>
                <hr/>
                <div class="alignRight">
                    <button type="submit" class="jquiButton btnSave"><?php echo parent::getTranslation("common.save"); ?></button>
                    <button type="button" class="jquiButton btnCancel"><?php echo parent::getTranslation("editor.label.cancel"); ?></button>
                </div>
            </form>
        </div>
	<script>
        $(".<?php echo parent::alias("addressForm") ?> .btnCancel").click(function () {
        	callUrl("<?php echo parent::link(array("action"=>"cancel")); ?>");
	});
	</script>
        <?php
    }
}

?>
