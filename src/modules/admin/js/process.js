
var getPlacesIntervalId = null;

function startGetPlacesTask () {    
	
	getPlacesIntervalId = window.setInterval(5000, function(){
		
		$.getJSON("?static=process&action=getGeonameIds", function (data) {
			if (data.status == "continue" && data.geonameIds) {
				for (var geonameId in data.geonameIds) {
					var serviceUrl = "http://www.geonames.org/childrenJSON?geonameId="+geonameId;
				    $.getJSON(serviceUrl, function(data){
				    	// check data status
				    	var geodata = JSON.stringify(data);
				    	$.post("?static=process&action=reportGeodata&geonameId="+geonameId, {"geodata":geodata}, function(status) {
				    		var status = jQuery.parseJSON(status);
				    		
			    		});
				    });
				}
			}
			
		});
		
	}, this);
}

function stopGetPlacesTask () {
	if (getPlacesIntervalId != null) {
		window.clearInterval(getPlacesIntervalId);
	}
}





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










var cms = {
	
	
	
	processes : [],
	process : {
		start : function () {
			
		},
		stop : function () {
			
		}
	},
	
	addProcess : function (process) {
		this.processes[this.process.name] = extend({}, this.process, process);
	},
	
	
	
	updateProcesses : function () {
		
		// get list of processes
		$.getJSON("", function (data) {
			
			
			
		});
		
		// run if process not started
		
		switch (data.status) {
			
			case "":
				break;
			case "stop":
				break;
		}
		for (var process in data.processes) {
			if (this.processes[process.name] == undefined) {
				this.loadProcess(process.url);
			}
		}
		
		
	}
	
}

cms.addProcess({
	interval : 5000,
	intervalId : null,
	start : function () {
		
	}
});

 
var searchWikipediaInterval = null;

function startSearchWikipediaTask () {
	
	getPlacesIntervalId = window.setInterval(5, function(){
		
		$.getJSON("?static=process&action=getWikipediaSubjects", function (data) {
			if (data.status && data.status == "continue" && data.subjects) {
				for (var subject in data.subjects) {
					var serviceUrl = "http://en.wikipedia.org/w/index.php?search="+subject.name+"&title=&go=Artikel";
					$.ajax({
					    type: "GET",
					    url: serviceUrl,
					    success: function(data, status, xhr) {
					        var redirectUrl = xhr.getResponseHeader('Location');
					        if (redirectUrl) {
					        	

						    	// check data status
						    	var data = $(data);
						    	
						    	// check if it was found
						    	var found = true;
						    	if (data.find(".searchresults")) {
						    		found = false;
						    	}
						    	
						    	if (found) {
						    		
						    		// extract the first paragraph
							    	var description = data.find(".mw-content-text p").first().html();
						    		
						    		// create wiki post
						    		$.post("?static=pinboard&action=wikinote&url="+redirectUrl+"&pinboardId="+subject.pinboardId, {"message":description}, function(status) {
							    		var status = jQuery.parseJSON(status);
						    		});
						    	}
						    }
					    }
					});
				}
			}
			
		});
		
	}, this);
}


function startSearchGoogleNewsTask () {
	
	// https://ajax.googleapis.com/ajax/services/search/news?v=1.0&q=munich
	
	// create news notes for places
}

function startSearchGoogleImagesTask () {
	// http://ajax.googleapis.com/ajax/services/search/images?v=1.0&q=munich
}



