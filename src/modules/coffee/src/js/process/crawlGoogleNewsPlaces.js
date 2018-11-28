
cms.addProcess({
	interval : 5000,
	intervalId : null,
	name : "crawlWebsite", 
	timeout : 60000,
	nextTimeout : null, 
	websitesWaiting : null, 
	start : function () {
		this.intervalId = window.setInterval(this.interval, function () {
		   
		   var millis = new Date().getMilliseconds();
		   
		   if (this.websitesWaiting > 0 && this.nextTimeout > millis) {
		   		return;
		   }
		   
		   this.nextTimeout = millis + this.timeout;
		   
		   .getJSON("?static=process&action=getWebsitesForEmailCrawlingTasks", function (data) {
		       
		       this.websitesWaiting = data.websites.length;
		       
		       for (var website in data.websites) {
		           	
					var website = this.toAbsoluteUrl(website);
					
					if (website == null) {
						this.websitesWaiting--;
						continue;
					}

					$.get(website, function(data){
		      			
		      			$(data).find("a").each(function(index, object){
		      				$
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
		                        		
		                    		}).always(function(){
		                    			this.websitesWaiting--;
		                    		});
		      					});
		      				}
		      			});
		      				
		      		}).fail(function(){
		      			this.websitesWaiting--;
		      		});
		       }
		       
		   });
		});
		
	}
});
