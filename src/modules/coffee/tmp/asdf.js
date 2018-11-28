
var maleNames = null, femaleNames = null, cityName = null;

var result = {
    "city" : {
        "amsterdam" : {
            "road" : {
                "address" : {
                    "site" : {
                        "email"
                    },
                    "lock" : false
                },
                "lock" : false
            }
        }
    }
};

function loadNameLists () {
    maleNames = [], femaleNames = [];
    $.get(femaleNames, function(data){
        femaleNames = data.split("\n");
    });
    $.get(maleNames, function(data){
        maleNames = data.split("\n");
    });
}
function getRoadList (cityName, radius) {
    
}
function searchForRoadAddresses () {
    $.each(raods,function(index,object){
        for (var hauseNumber=1; hauseNumber<=maxHauseNumber; hauseNumber++) {
            var gquery = city+" "+road+" "+hauseNumber;
            $.get()
        }
    });
}



function checkForTasks () {
    if (maleNames == null || femaleNames == null){
        loadNameLists();
    }
}

var searchResults = {};
function collectResultPageUrls (query, resultPage) {
    $(resultPage).find("h3.r a").each(function(urlIndex,url){
        var url = url.attr("href");
        searchResults[query][url] = [];
        getEmailAddressesFromSite(url,searchResults[query][url]);
    });
}
function getAllWebsitesInSearchResult (query, firstPage) {
    if (searchResults[query] == undefined) {
        searchResults[query] = {};
    }
    collectResultPageUrls(query, firstPage);
    $(firstPage).find("a.f1").each(function(index,page){
        $.get($(page).attr("href"),function(pageIndex,resultPage){
            collectResultPageUrls(query,resultPage);
        });
    });
}
function parsePage (url, result) {
    $.get(url,function(data){
  		$.each(data.match(/([a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z0-9._-]+)/gi),function(index,email){
  		    result.emails[email] = false;
  		});
    });
}
function getEmailAddressesFromSite (googleUrl, result) {
    result = {
        "urls" : {},
        "emails" : {}
    };
    var urls = $.get(googleUrl,function(content){
        $(content).find("a").each(function(index,object){
            result.urls[object.attr("href")] = false;
        });
        $.each(result.urls,function(index,url){
            parsePage(url,result);
        });
    });
}
function startFindGirlInterval (cityName, radius) {
    var intervalId = window.setInterval(function(){
        checkForTasks();
    },100,this);
}


