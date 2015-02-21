<?php

require_once 'core/plugin.php';

class PinboardSearchBoxModule extends XModule {

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {
    	
    	switch (parent::getAction()) {
    		case "search":
    			// log the search
    			
    			// if the result is a pinboard, note go to it
    			// user
    			// 
    			
    			break;
    		case "autoComplete":
    			
    			/*
    			// search location
    			LocationModel::search();
    			
    			// note
    			pinboardModule::search();
    			
    			// user
    			UsersModel::search("");
    			*/
    			
    			
    			
    			
    			
    			break;
    		case "viewPinboard":
    			parent::redirect("pinboard",array("pinboardId"=>parent::get("pinboardId")));
    			break;
    		case "viewLocation":
    			parent::redirect("pinboardMap",array("pinboardId"=>parent::get("pinboardId")));
    			break;
    		case "viewUser":
    			break;
    	}
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {

        switch (parent::getAction()) {
        	case "edit":
        		break;
        	case "search":
        		break;
            default:
                $this->printSearchBoxView();
        }
    }
    
    function getStyles () {
        return array("css/pinboardSearchBox.css");
    }
    
    function getScripts () {
    	 return array("https://maps.googleapis.com/maps/api/js?libraries=map,places");
    	//return array("https://maps.googleapis.com/maps/api/js");
    }

    function printSearchBoxView () {
        ?>
        <div class="panel pinboardSearchBoxPanel">
            <form method="post" id="searchForm" name="searchForm" action="<?php echo parent::link("search"); ?>">
                <a href="" onclick="$('#searchForm').submit(); return false;" title="<?php echo parent::getTranslation("pinboardSearchBox.button.title"); ?>"></a>
                <div>
                	<input type="text" name="search" placeholder="<?php echo parent::getTranslation("pinboardSearchBox.placeholder"); ?>" />
                </div>
            </form>
        </div>
        <script>
		$(function(){
			// run after map is initialized
			var cmdUrl = "<?php echo parent::ajaxLink(); ?>";

	        var input = $(".pinboardSearchBoxPanel input[name=search]");

	        input.submit(function(){
				return false;
	        });
	        //var map = $(".gMapHolder").pinboardMap("getMap");
	        var autocomplete = new google.maps.places.Autocomplete(input[0]);
	       	// autocomplete.bindTo('bounds', map);

	          google.maps.event.addListener(autocomplete, 'place_changed', function() {

	  			//
	       		var place = autocomplete.getPlace();
	      	    if (!place.geometry) {
	      	    	return;
	      	    }
				
				var pinboardMap = $(".gMapHolder").pinboardMap("setPlace", place);
	          });
		});
        </script>
        <?php
    }
}

?>