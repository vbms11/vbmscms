
cms.addProcess({
	interval : 5000,
	intervalId : null,
	name : "crawlPlaces", 
	start : function () {
		this.intervalId = window.setInterval(this.interval, function () {
		   
		   $.getJSON("", function (data) {
		       
		       for (var address in data.addresses) {
		           
		           // query google
                    var geocoder = new google.maps.Geocoder();
                    geocoder.geocode({"address": address}, function(results, status){
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
		       
		   });
		});
		
	}
});
