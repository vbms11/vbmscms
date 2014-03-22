
function getPlaces (selectObj, gionameId, selectedId) {
    var serviceUrl = "http://www.geonames.org/childrenJSON?geonameId="+gionameId;
    $.getJSON(serviceUrl, function(data){
        selectObj.css({"color":"grey"});
        selectObj.append($("<option/>",{"value":""})
            .css({"display":"none"})
            .text("(Please Select)"));
        $.each(data.geonames,function(index,object) {
            var option = $("<option/>",{"value":object.geonameId})
                .css({"color":"black"})
                .text(object.name);
            if (object.geonameId === selectedId) {
                option.attr({"selected":"true"});
            }
            selectObj.append(option);
        });
    });
}
