// google geodata search

function startGeodataSearchTask () {
	
	// get places to query
	
	// query google
	var geocoder = new google.maps.Geocoder();
    geocoder.geocode({"address": query}, function(results, status){
        if (status == google.maps.GeocoderStatus.OK) {
			if (!results[0].geometry) {
      	    	return;
      	    }
			var placeInfo = JSON.stringify(results[0]);
			$.post("?static=process&action=reportGoogleGeodata&geonameId="+geonameId, {"placeInfo": placeInfo}, function(status) {
	    		var status = jQuery.parseJSON(status);
	    		
    		});
        }
    });
	
	
}