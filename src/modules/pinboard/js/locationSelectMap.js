

$.widget("custom.locationSelectMap", {
    
    // default options
    options: {
    	visible: true,
    	lat : null,
    	lng : null,
    	inputName : null
	},
    
    map: null, 
    marker: null, 
    
    // the constructor
    _create: function () {
        
        this.element
            .addClass("locationSelectMap")
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
            .removeClass("locationSelectMap")
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
        
        // add map and inputs container to this element
        
        this.element
            .append("<div>", {"class": "locationSelectMapContainer"})
                .css({"height": this.element.height()})
            .end()
            .append("<div>", {"class": "locationSelectMapInputs"})
                .append("<input>", {"type": "hidden", "name": this.options.inputName + "_lng", "value": this.options.lng})
                .append("<input>", {"type": "hidden", "name": this.options.inputName + "_lat", "value": this.options.lat});
        
        // create the mape
        
        var center = new google.maps.LatLng(this.options.lat, this.options.lng);
	    
        var myMapOptions = {
          	zoom: this.options.zoom,
    		center: center,
    		streetViewControl: false,
    		scaleControl: false,
    		mapTypeId: google.maps.MapTypeId.TERRAIN,
		    mapTypeControl: true,
            mapTypeControlOptions: {
                style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
            }
    	};
    	
    	this.map = new google.maps.Map(thisObject.element.find(".locationSelectMapContainer")[0][0], myMapOptions);
    	
    	this.initMarker();
    	
        this.completeAttach();
    },
    
    completeAttach : function () {
        
        var thisObject = this;
        
        // this.show();
        
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
    
    initMarker : function () {
	    
	    var thisObject = this;
	    
	    // create the map marker
	    
	    var position = new google.maps.LatLng(this.options.lat, this.options.lng)
    	    
	    var markerOptions = {
    		map: this.map,
    		position: position,
    		draggable: true
    	}
        
    	this.marker = new google.maps.Marker(markerOptions);
	    
	    // add event listeners
	    
    	google.maps.event.addListener(this.marker, 'dragend', function (event) {
    		
            thisObject.setMarkerPosition(event.latLng.lat(), event.latLng.lng());
            thisObject.panToMarkerPosition();
    	});
    	
    	google.maps.event.addListener(this.map, 'click', function (event) {
            
            thisObject.setMarkerPosition(event.latLng.lat(), event.latLng.lng());
            thisObject.panToMarkerPosition();
        });
    },
    
    panToMarkerPosition : function () {
        
        this.map.panTo(this.marker.getPosition());
    },
    
    getMarkerPosition : function () {
        
        var position = this.marker.getPosition();
        return {"lng": position.lng(), "lat": position.lat()};
    },
    
    setMarkerPosition : function (lat, lng) {
        
        // save as option
        this.options.lat = lat;
        this.options.lng = lng;
        
        // set the markers position
        var position = new google.maps.LatLng(lat, lng);
        this.marker.setPosition(position);
        
        // set input feild values
        this.element.find(this.options.inputName + "_lat").val(lat);
        this.element.find(this.options.inputName + "_lng").val(lng);
    }
    
});
