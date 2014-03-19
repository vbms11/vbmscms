
function getPlaces (selectObj, gionameId) {
    var serviceUrl = "http://www.geonames.org/childrenJSON?geonameId="+gionameId;
    $.getJSON(serviceUrl, function(data){
        $.each(data.geonames,function(index,object) {
            selectObj.append($("<option/>",{"value":object.geonameId}).text(object.name));
        });
    });
}
