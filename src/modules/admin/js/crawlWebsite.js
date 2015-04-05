
cms.addProcess({
	interval : 5000,
	intervalId : null,
	name : "crawlWebsite", 
	start : function () {
		this.intervalId = window.setInterval(this.interval, function () {
		   
		   $.getJSON("?static=process&action=getWebsitesForEmailCrawling", function (data) {
		       
		       for (var website in data.websites) {
		           	
					var website = this.toAbsoluteUrl(website);
					
					if (website == null) {
						continue;
					}

					$.get(website, function(data){
		      			
		      			$(data).find("a").each(function(index, object){
		      				
		      				var href = this.toAbsoluteUrl($(object).attr("href"), website);
		      				
		      				if (href) {
		      					
		      					$.get(href, function(data){
		      						
		      						var emailAddresses = data.match(/([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9._-]+)/gi);
		      						var websiteInfo = JSON.stringify({
		      							"website": website, 
		      							"emails": emailAddresses
		      						});
		      						
		                    		$.post("?static=process&action=reportWebsiteEmails", {"websiteInfo": websiteInfo}, function(status) {
		                        		var status = jQuery.parseJSON(status);
		                        		
		                    		});
		      					});
		      				}
		      			});
		      				
		      		});
		       }
		       
		   });
		});
		
	}, 
	"toAbsoluteUrl" : function (url, base) {
		
		
		
		// Handle absolute URLs (with protocol-relative prefix)
		// Example: //domain.com/file.png
		if (url.search(/^\/\//) != -1) {
			
			if (base == undefined) {
				
				return "http://" + url;
				
			} else {
				
				return base.substring(0, base.indexOf("://") + 2) + url;
				
			}
		}
		
		// Handle absolute URLs (with explicit origin)
		// Example: http://domain.com/file.png
		if (url.search(/:\/\//) != -1) {
			return url
		}
		
		// Handle absolute URLs (without explicit origin)
		// Example: /file.png
		if (url.search(/^\//) != -1) {
			var pos = base.indexOf("/", 7)
			if (pos < 0) {
				pos = base.length;
				if (base.lastIndexOf("?") > -1) {
					pos = base.lastIndexOf("?");
				}
				if (base.lastIndexOf("#") > -1 && base.lastIndexOf("#") < pos) {
					pos = base.lastIndexOf("#");
				}
			}
			base.substring(0, pos - 1);
			return base + url
		}
		
		// Handle relative URLs
		// Example: file.png
		var base = base.substring(0, base.lastIndexOf("/"));
		return base + url
	}
});
