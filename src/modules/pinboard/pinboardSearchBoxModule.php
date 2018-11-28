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
            <form method="post" class="searchForm" name="searchForm" action="<?php echo parent::link(array("search")); ?>">
                <a href="#" title="<?php echo parent::getTranslation("pinboardSearchBox.button.title"); ?>"></a>
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

	          $(".pinboardSearchBoxPanel .searchForm").submit(function(){

					return false;
	          });

	          function panToSearchBoxLocation () {
      	    	var query = $(".pinboardSearchBoxPanel input[name=search]").val();
				if (query.trim() == "") {
					// if empty view globe
				} else {
					// search for the place
					var geocoder = new google.maps.Geocoder();
	        	    geocoder.geocode({"address": query}, function(results, status){
	        	        if (status == google.maps.GeocoderStatus.OK) {
							if (!results[0].geometry) {
	        	      	    	return;
	        	      	    }

							if (results[0].address_components) {
								var address = results[0].address_components[0].long_name;
								$(".pinboardSearchBoxPanel input[name=search]").val(address);
							}
							$(".gMapHolder").pinboardMap("setPlace", results[0]);
							$(".pac-container").css({"display": "none"});
	        	        }
	        	    });
				}
	          }
	          
			$(".pinboardSearchBoxPanel a").click(function(){
				panToSearchBoxLocation();
				return false;
			});
				
	          $('.pinboardSearchBoxPanel input[name=search]').keypress(function(event){
	        	    var keycode = (event.keyCode ? event.keyCode : event.which);
	        	    if(keycode == '13'){
		        	    panToSearchBoxLocation();
	        	    }
	        	});

	       // var firstResult = $(".pinboardSearchBoxPanel").find(".pac-container .pac-item:first").text();
				
		});
        </script>
        <?php
    }
}

?>