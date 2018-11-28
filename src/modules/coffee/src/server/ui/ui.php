<?php

class UI {
    
    static $view_login = "login";
    static $view_deny = "deny";
    static $view_register = "register";
    
    static $view_buyOffer = "buyOffer";
    static $view_userOffers = "userOffers";
    
    static $view_orders = "orders";
    static $view_settings = "settings";
    static $view_configurations = "configurations";
    static $view_contactDetails = "contactDetails";
    
    static $view_payment = "payment";
    
    function handelView () {
        
        if (Config::load()) {
            Device::$view[Request::getView()]->view();
        } else {
            $installView = ViewFactory::get("install");
            $installView->view();
        }
    }
    
    function printTemplate () {
        
        ?><!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Send Some Emails</title>
            <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js" type="text/javascript"></script>
            <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
            <script src="?res=js" type="text/javascript"></script>
            <link href="?res=css" rel="stylesheet">
        </head>
        <body> 
            
            <div class="header blueGradient">
                <h1><?php echo Translations::get("template.title"); ?></h1>
                <p><?php echo Translations::get("template.slogan"); ?></p>
            </div>
            
            <div class="body silverGradient">
                <?php
                switch ($view) {
                    case "init":
                        printRunningPage();
                        break;
                    default:
                        printStartPage();
                }
                ?>
            </div>
        
        </body>
        </html>
        <?php
    }
    
    function printCss () {
        
        ?>
        <style>
        body {
            font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;
            background-color: rgb(200,200,200);
        }
        .frame {
            margin: 10px auto;
            max-width: 1000px;
            min-width: 500px;
        }
        .header {
            background-color: rgb(100,100,100);
            height: 100px;
            border-bottom: 1px solid silver;
            border-radius: 8px 8px 0px 0px;
            border: 1px solid silver;
        }
        .body {
            background-color: white;
            padding: 50px;
            border-radius: 0px 0px 8px 8px;
            border-width: 0px 1px 1px 1px;
            border-style: solid;
            border-color: silver;
        }
        label, input, textarea {
            display: block;
            width: 100%;
        }
        input, textarea, button {
            border: 1px solid silver;
        }
        textarea {
            height: 100px;
        }
        .alignRight {
            text-align: right;
        }
        label, hr {
            margin-top: 30px;
        }
        .silverGradient {
            background: #f5f6f6; /* Old browsers */
            background: -moz-linear-gradient(top,  #f5f6f6 0%, #dbdce2 21%, #b8bac6 49%, #dddfe3 80%, #f5f6f6 100%); /* FF3.6+ */
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f5f6f6), color-stop(21%,#dbdce2), color-stop(49%,#b8bac6), color-stop(80%,#dddfe3), color-stop(100%,#f5f6f6)); /* Chrome,Safari4+ */
            background: -webkit-linear-gradient(top,  #f5f6f6 0%,#dbdce2 21%,#b8bac6 49%,#dddfe3 80%,#f5f6f6 100%); /* Chrome10+,Safari5.1+ */
            background: -o-linear-gradient(top,  #f5f6f6 0%,#dbdce2 21%,#b8bac6 49%,#dddfe3 80%,#f5f6f6 100%); /* Opera 11.10+ */
            background: -ms-linear-gradient(top,  #f5f6f6 0%,#dbdce2 21%,#b8bac6 49%,#dddfe3 80%,#f5f6f6 100%); /* IE10+ */
            background: linear-gradient(to bottom,  #f5f6f6 0%,#dbdce2 21%,#b8bac6 49%,#dddfe3 80%,#f5f6f6 100%); /* W3C */
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f5f6f6', endColorstr='#f5f6f6',GradientType=0 ); /* IE6-9 */
        }
        .blueGradient {
            background: #cedbe9; /* Old browsers */
            background: -moz-linear-gradient(-45deg,  #cedbe9 0%, #aac5de 17%, #6199c7 50%, #3a84c3 51%, #419ad6 59%, #4bb8f0 71%, #3a8bc2 84%, #26558b 100%); /* FF3.6+ */
            background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#cedbe9), color-stop(17%,#aac5de), color-stop(50%,#6199c7), color-stop(51%,#3a84c3), color-stop(59%,#419ad6), color-stop(71%,#4bb8f0), color-stop(84%,#3a8bc2), color-stop(100%,#26558b)); /* Chrome,Safari4+ */
            background: -webkit-linear-gradient(-45deg,  #cedbe9 0%,#aac5de 17%,#6199c7 50%,#3a84c3 51%,#419ad6 59%,#4bb8f0 71%,#3a8bc2 84%,#26558b 100%); /* Chrome10+,Safari5.1+ */
            background: -o-linear-gradient(-45deg,  #cedbe9 0%,#aac5de 17%,#6199c7 50%,#3a84c3 51%,#419ad6 59%,#4bb8f0 71%,#3a8bc2 84%,#26558b 100%); /* Opera 11.10+ */
            background: -ms-linear-gradient(-45deg,  #cedbe9 0%,#aac5de 17%,#6199c7 50%,#3a84c3 51%,#419ad6 59%,#4bb8f0 71%,#3a8bc2 84%,#26558b 100%); /* IE10+ */
            background: linear-gradient(135deg,  #cedbe9 0%,#aac5de 17%,#6199c7 50%,#3a84c3 51%,#419ad6 59%,#4bb8f0 71%,#3a8bc2 84%,#26558b 100%); /* W3C */
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#cedbe9', endColorstr='#26558b',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
        }
        .header {
            text-align: right;
        }
        .header h1 {
            color: white;
            margin: 10px 10px 0px 0px;
        }
        .header p {
            color: rgb(200,200,200);
            margin: 0px 10px 0px 0px;
        }
        div.table {
            display: table;
        }
        div.table div, div.table form {
            display: table-row;
        }
        div.table div div, div.table div label {
            display: table-cell;
        }
        div.table > div.oddRow, div.table > form.oddRow {
            background-color: rgb(245,245,245);
        }
        </style>
        <?php
    }
    
    function printJs () {
        ?>
        <script>
        $("table div:odd").addClass("oddRow");
        function log (message) {
            $("body").append($("<div>").text(message));
        }
        $(window).on("error",function(e){
            log("error: "+JSON.stringify(e));
        });
        var websites = [];
        var googleSearcher = {
            googleUrl : "https://www.google.com/#q=",
        	interval : 5000, 
        	intervalId : null, 
        	name : "googleSearcher", 
        	timeout : 60000, 
        	nextTimeout : null, 
        	websitesWaiting : null, 
        	keywords : null, 
        	keywordPosition : 0, 
            start : function (keywords) {
                var that = this;
                this.keywords = keywords;
                this.intervalId = window.setInterval(function(){
                    if (websites.length > 100) {
                        return false;
                    }
                    keywords = that.getNextKeywordCombination();
                    that.searchQuery(keywords, function (content) {
                        log(content);
                        that.extractPages(content, function (pages) {
                            that.getUrlList(content);
                            for (var page in pages) {
                                $.get(page, function(content){
                                    that.getUrlList(content);
                                });
                            }
                        });
                    });
                }, this.interval, this);
            },
            searchQuery : function (keywords, handler) {
                $.get(this.googleUrl+keywords, function (data) {
                    handler(data);
                });
            },
            extractPages : function (resultsPageContent, handler) {
                var pages = [];
                $(resultsPageContent).find("a.f1").each(function(index, object){
                    pages.push(object.attr("href"));
                });
                handler(pages);
            },
            getUrlList : function (content) {
                var urls = [];
                $(content).find("h3.r a").each(function(index, object){
                    urls.push(object.attr("href"));
                });
                websites.concat(urls);
            }, 
            getNextKeywordCombination : function () {
                /*
                var word = null;
                var words = this.keywords.split(" ");
                if (this.keywordPosition < words.length) {
                    word = words[this.keywordPosition];
                } else {
                    var startPos = 0;
                    var pos = this.keywordPosition - words.length;
                    for (var stepSize = words.length - 1; stepSize > 0; stepSize--) {
                        if (pos > stepSize) {
                            pos -= stepSize;
                            startPos++;
                        } else {
                            word = words[startPos]+" "+words[pos];
                        }
                    }
                }
                this.keywordPosition++;
                return word;
                */
                return this.keywords.split(" ");
            }
        };
        
        var websiteCrawler = {
        	interval : 5000, 
        	intervalId : null, 
        	name : "crawlWebsite", 
        	timeout : 60000, 
        	nextTimeout : null, 
        	websitesWaiting : null, 
        	"start" : function () {
        	    this.intervalId = window.setInterval(function () {
                    this.websitesWaiting = websites.length;
                    if (this.websitesWaiting <= 0) {
                        return;
                    }
                    for (var website in websites) {
                    	var website = this.toAbsoluteUrl(website);
                    	if (website == null) {
                    		this.websitesWaiting--;
                    		continue;
                    	}
                    	$.get(website, function(data){
                      		$(data).find("a").each(function(index, object){
                      			var href = this.toAbsoluteUrl($(object).attr("href"), website);
                      			if (href) {
                      				$.get(href, function(data){
                      					var emailAddresses = data.match(/([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9._-]+)/gi);
                      					if (emailAddresses.length > 0) {
                      					    var websiteInfo = JSON.stringify({
                          						"website": website, 
                          						"emails": emailAddresses
                          					});
                                    		$.post("?action=sendEmail", {"emails": websiteInfo}, function(status) {
                                        		var status = jQuery.parseJSON(status);
                                    		}).always(function(){
                                    			this.websitesWaiting--;
                                    		});
                      					} else {
                      					    this.websitesWaiting--;
                      					}
                      				});
                      			}
                      		});
                      	}).fail(function(){
                      		this.websitesWaiting--;
                      	});
                    }
        	    }, this.interval);
        	}, 
        	"toAbsoluteUrl" : function (url, base) {
        		if (url.search(/^\/\//) != -1) {
        			if (base == undefined) {
        				return "http://" + url;
        			} else {
        				return base.substring(0, base.indexOf("://") + 2) + url;
        			}
        		}
        		if (url.search(/:\/\//) != -1) {
        			return url;
        		}
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
        			return base + url;
        		}
        		var base = base.substring(0, base.lastIndexOf("/"));
        		return base + url;
        	}
        };
        </script>
        <?php
    }
    
    function getSql () {
        
        $installSql = "
        
            CREATE TABLE IF NOT EXISTS '${tablePrefix}_user' (
              'id' int(20) NOT NULL AUTO_INCREMENT,
              'username' varchar(200) COLLATE utf8_bin NOT NULL,
              'firstname' varchar(200) NOT NULL,
              'lastname' varchar(200) NOT NULL,
              'birthdate' datetime NOT NULL,
              'gender' int(1) NOT NULL,
              PRIMARY KEY ('id'),
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;
            
            CREATE TABLE IF NOT EXISTS '${tablePrefix}_co' (
              'id' int(20) NOT NULL AUTO_INCREMENT,
              'username' varchar(200) COLLATE utf8_bin NOT NULL,
              'firstname' varchar(200) NOT NULL,
              'lastname' varchar(200) NOT NULL,
              'birthdate' datetime NOT NULL,
              'gender' int(1) NOT NULL,
              PRIMARY KEY ('id'),
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;
            
        ";
    }
}