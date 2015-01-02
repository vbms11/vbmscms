

$.widget( "custom.pinboardmap", {
    
    // default options
    options: {
    	visible: true,
    	dataUrl: null,
    	viewUrl: null,
    	lat : null,
    	lng : null
	},
    
    map: null,
    
    // the constructor
    _create: function () {
        
        this.element
            .addClass("pinboardmap")
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
            .removeClass("pinboardmap")
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
        
	    var center = new google.maps.LatLng(this.options.lat, this.options.lng);
	    
    	var myMapOptions = {
          	zoom: 10,
    		center: center,
    		streetViewControl: false,
    		scaleControl: false,
    		mapTypeId: google.maps.MapTypeId.TERRAIN,
		    mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
            }
    	};
    	
    	this.map = new google.maps.Map(this.element,myMapOptions);
    	
        this.completeAttach();
    },
    
    completeAttach : function () {
        
        var thisObject = this;
        
        this.show();
        
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
            "&minLat=" + bounds.getNorthEast().lat() + 
            "&maxLng=" + bounds.getNorthEast().lng() + 
            "&maxLat=" + bounds.getSouthWest().lat()
        
        // get pinboards in view
        $.ajax(this.options.dataUrl + params)
            .done(function(data) {
                
                var results = $.parseJSON(data);
                var newPinbords = {};
                var oldPinbords = thisObject.pinboards.slice();
                
                for (var pinboard in results) {    
                    if (pinboard["id"] in thisObject.pinboards) {
                        delete oldPinbords[pinboard["id"]];
                        continue;
                    }
                    newPinbords[pinboard["id"]] = pinboard;
                }
                
                // add pinboards new in view
                for (var pinboard in newPinbords) {
                    thisObject.addPinboard(pinboard);
                }
                
                // remove pinboards no longer in view
                for (var pinboard in oldPinbords) {
                    thisObject.removePinboard(pinboard);
                }
                
            })
            .fail(function() {
                alert("error");
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
    	
    	if (!(pinboard.id in this.pinboards)) {
    	    
    	    // create the map marker
    	    var image = new google.maps.MarkerImage(
        	    pinboard.iconfile,
        		new google.maps.Size(20, 20),
        		new google.maps.Point(0, 0),
        		new google.maps.Point(10, 10)
        	);
    	    
    	    var shape = {
                coords: [0, 0, 0, 20, 20, 20, 20 , 0],
                type: 'poly'
            };
    	    
    	    var position = new google.maps.LatLng(pinboard.lat, pinboard.lng)
    	    
    	    var markerOptions = {
        		draggable: false,
        		icon: image,
        		shape: shape,
        		map: this.map,
        		position: position
        	}
        	
        	if (pinboard.canedit) {
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
        		if (this.options.viewUrl) {
        		    callUrl(this.options.viewUrl+pinboard.id);
        		}
        	});
            
        	google.maps.event.addListener(marker, 'mouseover', function(){
        		info.open(this.map, marker);
        	});
        	
        	google.maps.event.addListener(marker, 'mouseout', function(){
        		info.close();
        	});
        	
        	google.maps.event.addListener(marker, 'dragstart', function(){
        		info.close();
        	});
    	    
    	    // save the pinboard
    	    pinboard.info = info;
    	    pinboard.marker = marker;
    	    this.pinboards[pinboard.id] = pinboard;
    	}
    },

    onMapDrag : function () {
    },
    
    openPinbord : function () {
    	
    	this.options.pinboardName
    },
    
    onPinboardMouseOver : function () {
        
    }
    
});




/*

var map;	
var marker;
var shape;
var myInfoWindowOptions;
var infoWindow;
var center = new google.maps.LatLng(50.915516, 0.346269);
var markerPosition = new google.maps.LatLng(50.875311, 0.351563);
*/