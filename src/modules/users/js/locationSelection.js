
function getPlaces (selectObj, gionameId, selectedId) {
    var serviceUrl = "http://www.geonames.org/childrenJSON?geonameId="+gionameId;
    selectObj.empty();
    $.getJSON(serviceUrl, function(data){
        selectObj.css({"color":"grey"});
        selectObj.append($("<option/>",{"value":""})
            .css({"display":"none"})
            .text("(Please Select)"));
        $.each(data.geonames,function(index,object) {
            var option = $("<option/>",{"value":object.geonameId})
                .text(object.name);
            if (object.geonameId == selectedId) {
                option.attr({"selected":"true"});
            }
            selectObj.css({"color":"black"}).append(option);
        });
    });
}

function setupPlaceFeilds(parent,continentId,countryId,stateId,regionId,cityId) {
    
    // add change listener
    parent.find("select[name=continentId]").change(function(){
        $(this).css({"color":"black"});
        parent.find("input[name=continent]").val($(this).find("option:selected").html());
        getPlaces(parent.find("select[name=countryId]"),$(this).val());
    }).end().find("select[name=countryId]").change(function(){
        $(this).css({"color":"black"});
        parent.find("input[name=country]").val($(this).find("option:selected").html());
        getPlaces(parent.find("select[name=stateId]"),$(this).val());
    }).end().find("select[name=stateId]").change(function(){
        $(this).css({"color":"black"});
        parent.find("input[name=state]").val($(this).find("option:selected").html());
        getPlaces(parent.find("select[name=regionId]"),$(this).val());
    }).end().find("select[name=regionId]").change(function(){
        $(this).css({"color":"black"});
        parent.find("input[name=region]").val($(this).find("option:selected").html());
        getPlaces(parent.find("select[name=cityId]"),$(this).val());
    }).end().find("select[name=cityId]").change(function(){
        $(this).css({"color":"black"});
        parent.find("input[name=city]").val($(this).find("option:selected").html());
    });
    
    // set default values
    if (continentId === "") {
        getPlaces(parent.find("select[name=continentId]"),6295630);
        return;
    }
    getPlaces(parent.find("select[name=continentId]"),6295630,continentId);
    if (countryId === "")
        return;
    getPlaces(parent.find("select[name=countryId]"),continentId,countryId);
    if (stateId === "")
        return;
    getPlaces(parent.find("select[name=stateId]"),countryId,stateId);
    if (regionId === "")
        return;
    getPlaces(parent.find("select[name=regionId]"),stateId,regionId);
    if (cityId === "") {
        return;
    }
    getPlaces(parent.find("select[name=cityId]"),regionId,cityId);
}
