<?php

require_once('core/plugin.php');
require_once('modules/company/companySearchBaseModule.php');

class CompanyImport extends CompanySearchBaseModule {
    
    function onProcess () {
        
        switch (parent::getAction()) {
            case "save":
                parent::blur();
                parent::redirect();
                break;
            case "search":
                parent::redirect("companySearchResult", array("name"=>parent::get("name"),"country"=>parent::get("country")));
                break;
            
            case "searchResults":
                break;
            default:
                break;
        }
    }
    
    function onView () {
	
        switch (parent::getAction()) {
            case "edit":
                if (Context::hasRole("company.search.edit")) {
                    $this->printEditView();
                }
                break;
            default:
                if (Context::hasRole("company.search.view")) {
                    $this->printSearchView();
                }
                break;
        }
    }
    
    function getScripts () {
        return array();
    }
    
    function getStyles () {
        return array("css/companySearch.css");
    }
    
    function getRoles () {
        return array("company.search.edit","company.search.view");
    }
    
    function printEditView () {
        ?>
        <form method="post" action="<?php echo parent::link(array("action"=>"save")); ?>">
            <hr/>
            <button><?php echo parent::getTranslation("common.save"); ?></button>
        </form>
        <?php
    }
    
    function printSearchView () {
        
        /*
        $countryOptions = array();
        $countires = CountryModel::getCountries();
        foreach ($countires as $country) {
            $countryOptions[$country->geonameid] = htmlentities($country->name,ENT_QUOTES);
        }
        */
        
        ?>
        <div class="panel comapnySearchPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"search")); ?>" name="companySearchForm">
		<div>
                    <table><tr>
                        <td><?php echo parent::getTranslation('company.search.name'); ?></td>
                    </tr><tr>
                        <td><?php InputFeilds::printTextFeild("name", parent::get('name')); ?></td>
                    </tr>
                    <?php /*
                    <tr>
                        <td><?php echo parent::getTranslation('company.search.country'); ?></td>
                    </tr><tr>
                        <td><?php 
                        $countryId = parent::get('country');
                        echo "<select name='country'>";
                        if (empty($countryId)) {
                            echo "<option style='display:none;' selected='selected' value=''>(Please Select)</option>";
                        }
                        foreach ($countryOptions as $key => $valueNames) {
                            if (!empty($countryId) && $key == $countryId) {
                                echo "<option value='".Common::htmlEscape($key)."' selected='selected'>".Common::htmlEscape($valueNames)."</option>";
                            } else {
                                echo "<option value='".Common::htmlEscape($key)."'>".Common::htmlEscape($valueNames)."</option>";
                            }

                        }
                        echo "</select>";
                        ?></td>
                    </tr>
                    */ ?>
                    </table>
                </div>
                <hr/>
                <div class="alignRight">
                    <button class="jquiButton companySearchSearchButton" value="simpleSearchButton" type="submit">
                        <?php echo parent::getTranslation('company.search.button.search'); ?>
                    </button>
                </div>
            </form>
        </div>
        <?php    
    }
    
    function printGeoSearchView ($cityName) {
        
        ?>
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
		    
      function initAutocomplete() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -33.8688, lng: 151.2195},
          zoom: 13,
          mapTypeId: 'roadmap'
        });

        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
          var places = searchBox.getPlaces();

          if (places.length == 0) {
            return;
          }

          // Clear out the old markers.
          markers.forEach(function(marker) {
            marker.setMap(null);
          });
          markers = [];

          // For each place, get the icon, name and location.
          var bounds = new google.maps.LatLngBounds();
          places.forEach(function(place) {
            if (!place.geometry) {
              console.log("Returned place contains no geometry");
              return;
            }
            var icon = {
              url: place.icon,
              size: new google.maps.Size(71, 71),
              origin: new google.maps.Point(0, 0),
              anchor: new google.maps.Point(17, 34),
              scaledSize: new google.maps.Size(25, 25)
            };

            // Create a marker for each place.
            markers.push(new google.maps.Marker({
              map: map,
              icon: icon,
              title: place.name,
              position: place.geometry.location
            }));

            if (place.geometry.viewport) {
              // Only geocodes have viewport.
              bounds.union(place.geometry.viewport);
            } else {
              bounds.extend(place.geometry.location);
            }
          });
          map.fitBounds(bounds);
        });
      }
    
		});
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places&callback=initAutocomplete"
         async defer></script>
        <?php 
    }
    
}

?>