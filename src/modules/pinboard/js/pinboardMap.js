

$.widget("custom.pinboardMap", {
    
    // default options
    options: {
    	visible: true,
    	dataUrl: null,
    	viewUrl: null,
    	cmdUrl: null,
    	lat : null,
    	lng : null
	},
    
    map: null,
    pinboards: [],
    
    // the constructor
    _create: function () {
        
        this.element
            .addClass("pinboardMap")
            .disableSelection();
        
        this.attach();
        
        this._refresh();
    },
    
    // called when created, and later when changing options
    _refresh : function () {
        
        this._trigger("refreshEvent");
    },

    // revert modifications here
    _destroy : function () {
        
        this.element
            .removeClass("pinboardMap")
            .empty()
            .enableSelection();
    },

    // _setOptions is called with a hash of all options that are changing
    _setOptions : function () {
        
        this._superApply(arguments);
        this._refresh();
    },

    // _setOption is called for each individual option that is changing
    _setOption : function (key, value) {
        
        switch (key) {
	        case "show":
	            this.show();
	            break;
	        case "hide":
	            this.hide();
	            break;
            case "width":
                this.options.width = width;
                this.resize(this.options.width,this.options.height);
                break;
            case "height":
                this.options.height = height;
                this.resize(this.options.width,this.options.height);
                break;
            default:
                this._super(key, value);
        }
    },
    
    /*
     * Pin board
     */
    
    // init
    attach : function () {
    	
        var thisObject = this;
        
        // add the map container
        this.element.append(
    		$("<div>",{"class": "gMapContainer"})
    			.css({
    				"position": "absolute",
    				"width": "100%",
    				"height": "100%"
    			})
        );
        
        // create the map centered on user location
        this.getUserLocation(function (lngLat) {
        	
        	thisObject.initMap(lngLat.lng, lngLat.lat, 10);
        });
        
    },
    
    initMap : function (lng, lat, zoom) {
    	
    	var center = new google.maps.LatLng(lat,lng);
    	
    	var myMapOptions = {
          	zoom: 10,
    		center: center,
    		streetViewControl: false,
    		scaleControl: false,
    		mapTypeId: google.maps.MapTypeId.TERRAIN,
    		disableDefaultUI: true, 
    		mapTypeControl: false,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
            },
            styles : [
                      {
                          "featureType": "road.highway",
                          "elementType": "geometry",
                          "stylers": [
                            { "saturation": -100 },
                            { "lightness": -8 },
                            { "gamma": 1.18 }
                          ]
                      }, {
                          "featureType": "road.arterial",
                          "elementType": "geometry",
                          "stylers": [
                            { "saturation": -100 },
                            { "gamma": 1 },
                            { "lightness": -24 }
                          ]
                      }, {
                          "featureType": "poi",
                          "elementType": "geometry",
                          "stylers": [
                            { "saturation": -100 }
                          ]
                      }, {
                          "featureType": "administrative",
                          "stylers": [
                            { "saturation": -100 }
                          ]
                      }, {
                          "featureType": "transit",
                          "stylers": [
                            { "saturation": -100 }
                          ]
                      }, {
                          "featureType": "water",
                          "elementType": "geometry.fill",
                          "stylers": [
                            { "saturation": -100 }
                          ]
                      }, {
                          "featureType": "road",
                          "stylers": [
                            { "saturation": -100 }
                          ]
                      }, {
                          "featureType": "administrative",
                          "stylers": [
                            { "saturation": -100 }
                          ]
                      }, {
                          "featureType": "landscape",
                          "stylers": [
                            { "saturation": -100 }
                          ]
                      }, {
                          "featureType": "poi",
                          "stylers": [
                            { "saturation": -100 }
                          ]
                      }, {
                  }
               ]
    	};
    	
    	this.map = new google.maps.Map(this.element.find(".gMapContainer")[0], myMapOptions);
    	/*
    	var roadAtlasStyles = [{
           "featureType": "road.highway", // "road.arterial", "poi", "water", "administrative"
           "elementType": "geometry", // "geometry.fill",
           "stylers": [
             { "saturation": -100 },
             { "lightness": -8 },
             { "gamma": 1.18 }
           ]
       }];
    	*/
    	    	
    	
    	
    	
    	
    	
    	
    	var thisObject = this;
    	google.maps.event.addListenerOnce(this.map, 'idle', function(){
        	thisObject.completeAttach();
    	});
    	
    	

    	
    	
    	
    	
    }, 
    
    completeAttach : function () {
        
        // var thisObject = this;
        
        //this.show();
        this.updatePinboards();
        
        if (this.attachCompleteListener) {
            this.attachCompleteListener();
        }
    },
    
    resize : function (width, height) {
    	
    	// this.element
    },

    show : function () {
    	
    	this.element.fadeIn();
    },

    hide : function () {
    	
    	this.element.fadeOut();
    },
    
    updatePinboards : function () {
        
        var thisObject = this;
        
        // get map view rect
        var bounds = this.map.getBounds();
        var params = "&minLng=" + bounds.getSouthWest().lng() +
            "&minLat=" + bounds.getSouthWest().lat() + 
            "&maxLng=" + bounds.getNorthEast().lng() + 
            "&maxLat=" + bounds.getNorthEast().lat();
        
        // get pinboards in view
        $.get(this.options.dataUrl + params, function(data,status){
            
        	var results = $.parseJSON(data);
            var newPinbords = {};
            var oldPinbords = thisObject.pinboards.slice();
            
            for (var key in results) {    
                var pinboard = results[key];
            	if (pinboard.id in thisObject.pinboards) {
                	delete oldPinbords[pinboard.id];
                    continue;
                }
                newPinbords[pinboard.id] = pinboard;
            }
            
            // add pinboards new in view
            for (var id in newPinbords) {
            	thisObject.addPinboard(newPinbords[id]);
            }
            
            // remove pinboards no longer in view
            for (var pinboard in oldPinbords) {
                thisObject.removePinboard(pinboard);
            }
            
        });
        
    },
    
    removePinboard : function (pinboard) {
        
        if (pinboard.id in this.pinboards) {
            var thePinboard = this.pinboards[pinboard.id];
            thePinboard.marker.setMap(null);
            thePinboard.info.close();
            delete this.pinboards[pinboard.id];
        }
    }, 
    
    addPinboard : function (pinboard) {
    	
    	var thisObject = this;
    	
    	if (!(pinboard.id in this.pinboards)) {
    		
    		// create the map marker
    	    var image = new google.maps.MarkerImage(
        	    pinboard.iconfile,
        		new google.maps.Size(60, 60),
        		new google.maps.Point(0, 0),
        		new google.maps.Point(10, 10)
        	);
    	    
    	    var shape = {
                coords: [0, 0, 0, 60, 60, 60, 60 , 0],
                type: 'poly'
            };
    	    
    	    var position = new google.maps.LatLng(pinboard.lat, pinboard.lng);
    	    
    	    var markerOptions = {
        		draggable: false,
        		icon: image,
        		shape: shape,
        		map: this.map,
        		position: position
        	};
        	
        	if (pinboard.editable) {
        		markerOptions["draggable"] = true;
        	}
        	
        	marker = new google.maps.Marker(markerOptions);
    	    
    	    // create info window
    	    
        	infoOptions = {
        		content: '<div class="info-window-content"><b>'+pinboard.name+'</b><p>'+pinboard.description+'</p></div>',
        		maxWidth: 275
        	};

    	    info = new google.maps.InfoWindow(infoOptions);

        	google.maps.event.addListener(marker, 'click', function() {
        		if (thisObject.options.viewUrl) {
        		    callUrl(thisObject.options.viewUrl+"&pinboardId="+pinboard.id);
        		}
        	});
            
        	google.maps.event.addListener(marker, 'mouseover', function(){
        		info.open(thisObject.map, marker);
        	});
        	
        	google.maps.event.addListener(marker, 'mouseout', function(){
        		info.close();
        	});

        	google.maps.event.addListener(marker, 'dragstart', function(){
        		info.close();
        	});
        	
        	google.maps.event.addListener(marker, 'dragend', function(){
        		// ask user if he would like to save the location
        		thisObject.saveMarkerLocation(pinboard.id, marker);
        	});
    	    
    	    // save the pinboard
    	    pinboard.info = info;
    	    pinboard.marker = marker;
    	    this.pinboards[pinboard.id] = pinboard;
    	}
    },
    
    saveMarkerLocation : function (pinboardId, marker) {
    	
    	// send the location of the marker
    	$.ajax(this.options.cmdUrl+"&action=setPinboardLocation&pinboardId="+pinboardId+"&lat="+marker.position.lat()+"&lng="+marker.position.lng(), function (data) {});
    },
    
    onMapDrag : function () {
    },
    
    openPinbord : function () {
    	
    	// this.options.pinboardName;
    	// load pinboard module into center area
    	// $("#vcms_area_center").load(...);
    },
    
    onPinboardMouseOver : function () {
        
    },
    
    getZoom : function () {
        
        return this.map.getZoom();
    },
    
    setPlace : function (place) {
    	
    	// pinboardMap.closeInfoWindow();
		
		// set map position
		if (place.geometry.viewport) {
			this.map.fitBounds(place.geometry.viewport);
		} else {
			this.map.setCenter(place.geometry.location);
			this.map.setZoom(17);
	    }
	    
		// dose the place have a pinboard?
		
		
		// go to places pinboard
		// else
		// place marker
		
	    // put a marker on the place
	    marker.setIcon(/** @type {google.maps.Icon} */({
	      url: place.icon,
	      size: new google.maps.Size(71, 71),
	      origin: new google.maps.Point(0, 0),
	      anchor: new google.maps.Point(17, 34),
	      scaledSize: new google.maps.Size(35, 35)
	    }));
	    marker.setPosition(place.geometry.location);
	    marker.setVisible(true);
	    
	    
	    
		var address = '';
		if (place.address_components) {
		  address = [
		    (place.address_components[0] && place.address_components[0].short_name || ''),
		    (place.address_components[1] && place.address_components[1].short_name || ''),
		    (place.address_components[2] && place.address_components[2].short_name || '')
		  ].join(' ');
		}

	    infowindow.setContent('<div><strong>' + place.name + '</strong><a>New Pinboard</a><br/>' + address);
	    infowindow.open(this.map, marker);
	  
    },
    
    setCenter : function (latLng) {
    	
    	this.map.panTo(new google.maps.LatLng(latLng.lat, latLng.lng));
    },
    
    getCenter : function () {
    	
    	if (this.map != null) {
    		var center = this.map.getCenter();
    		return {"lat": center.lat(), "lng": center.lng()};
    	}
    	
    	var center = this.mapCenter;
    	if (center != null) {
    		return center;
    	}
    	
    	var center = $.cookie("mapCenter");
    	if (center != null) {
    		return $.parseJSON(center);
    	}
    },
    
    getUserLocation : function (callback) {
    	
    	var latLng = $.cookie('userLocation');
    	if (typeof(latLng) == "undefined") {
    		
    		var thisObject = this;
    		
    		// get user location
    		var ip = null;
            var callbackCalled = false;
            
        	$.ajax({url: "http://www.telize.com/ip"})
        		.done(function (data) {
	        		
	        		ip = data;
	        		$.ajax({url: "https://freegeoip.net/json/"+ip}).done(function (data) {
	        			var info = $.parseJSON(data);
	        			if (info.longitude != "" && info.longitude == 0 && info.latitude != "" && info.latitude != 0) {
	        				callback({"lat": info.latitude, "lng": info.longitude});
	        				callbackCalled = true;
	        			}
	                }).always(function() {
	        			// check if map has been initialized
	        			if (!callbackCalled) {
	        				thisObject.askUserForLocation(callback);
	        			}
	        		});
            }).always(function() {
    			// check if map has been initialized
    			if (ip == null && !callbackCalled) {
    				thisObject.askUserForLocation(callback);
    			}
    		});
        	
    		this.setUserLocation(latLng);
    	
    	} else {
    		
    		callback($.parseJSON(latLng));
    	}
    	
    	return $.parseJSON(latLng);
    },
    
    setUserLocation : function (latLng) {
    	
    	$.cookie('userLocation', JSON.stringify(latLng), {
            expires : 10
        });
    },
    
    askUserForLocation : function (callback) {
    	
    	var thisObject = this;
    	navigator.geolocation.getCurrentPosition(function(position) {
    		var result = {"lat": position.coords.latitude, "lng": position.coords.longitude};
    		thisObject.setUserLocation(result);
    		if (typeof(callback) != "undefined") {
        		callback(result);
    		}
		});
    },
    
    getMap : function () {
    	
    	return this.map;
    }
    
});
