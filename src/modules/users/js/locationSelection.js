
function updateCoordinatesByPlace (elX, elY, place, onComplete) {
	var serviceUrl = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=";
	place = encodeURIComponent(place);
	$.getJSON(serviceUrl+place, function(data){
		if (data["status"] == "OK" && data["results"][0] != undefined) {
			var location = data["results"][0]["geometry"]["location"];
			elX.val(location["lat"]);
			elY.val(location["lng"]);
			if (onComplete != undefined) {
				onComplete();
			}
		}
	});
}

function updateCoordinatesByAddress (elX, elY, countryName, cityName, postcode, street, enableButtonOnComplete) {
	updateCoordinatesByPlace(elX, elY, countryName+" "+cityName+" "+postcode+" "+street, enableButtonOnComplete);
}

function setupSearchFeilds (parent) {
	parent.find("button.userSearchSearchButton").click(function(e){
		var place = parent.find("select[name=country]").val()+" "+parent.find("input[name=place]").val()
		updateCoordinatesByPlace(parent.find("input[name=x]"), parent.find("input[name=y]"), place, function(){
			parent.submit();
		});
		return false;
	});
}

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

function setupPlaceFeilds(parent,continentId,countryId,stateId,regionId,cityId,submitButton) {
    
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
    
	// trigger update location when address changes
	parent.find("input[name=address]").blur(function(e){
		updateCoordinatesByAddress(parent.find("input[name=x]"), parent.find("input[name=y]"), parent.find("input[name=country]").val(), parent.find("input[name=city]").val(), parent.find("input[name=postcode]").val(), parent.find("input[name=address]").val(), function(){
			submitButton.button("enable");
		});
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
