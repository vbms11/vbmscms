/*


 
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





*/




cms.addProcess({
	interval : 5000,
	intervalId : null,
	name : "crawlWebsite", 
	timeout : 30000, 
	nextTimeout : null, 
	tasksWaiting : null, 
	start : function () {
		
		this.intervalId = window.setInterval(this.interval, function () {
		
		var millis = new Date().getMilliseconds();
		
		if (this.tasksWaiting > 0 && this.nextTimeout > millis) {
		   	return;
		}
		
		this.nextTimeout = millis + this.timeout;
		
		$.getJSON("?static=process&action=getPlaceWikiTasks", function (data) {
			if (data.status && data.status == "continue" && data.subjects) {
				
				this.tasksWaiting = data.subjects.length;
				
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
						    		$.post("?static=process&action=reportPlaceWiki&url="+redirectUrl+"&pinboardId="+subject.pinboardId, {"message":description}, function(status) {
							    		var status = jQuery.parseJSON(status);
						    		});
						    	}
						    }
						}
					}).always(function(){
						this.tasksWaiting--;
					});
				}
				
			});
			
		}, this);
	}
});
