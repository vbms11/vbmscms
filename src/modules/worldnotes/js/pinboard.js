/**
 * 
 */




// pin board

$.widget( "custom.pinboard", {
    
    // default options
    options: {
	width : "500",
	height : "500",
	visible: true
	},
    
    // the constructor
    _create: function () {
        
        this.element
            .addClass("pinboard")
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
            .removeClass("pinboard")
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
    
    newPin : function () {
    	
    	
    }
 // new pin

    
});

var ivTranslationTexts = {
    "en" : {
        "iv.nextimage" : "show next image"
    },
    "de":{
        "iv.nextimage" : "show next image"
    }
};


$.widget( "custom.pinboardmap", {
    
    // default options
    options: {
    	visible: true
	},
    
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

    addPlaceholder : function (id) {
    	
    	map = new google.maps.Map(document.getElementById("map"),myMapOptions);
    	
    	var image = new google.maps.MarkerImage(
    	  'marker-images/image.png',
    		new google.maps.Size(40,35),
    		new google.maps.Point(0,0),
    		new google.maps.Point(0,35)
    	);

    	var shadow = new google.maps.MarkerImage(
    	  'marker-images/shadow.png',
    		new google.maps.Size(62,35),
    		new google.maps.Point(0, 0),
    		new google.maps.Point(0,35)
    	);

    	var shape = {
    		coord: [27,0,30,1,32,2,34,3,35,4,36,5,38,6,39,7,39,8,39,9,39,10,38,11,37,12,33,13,34,14,34,15,33,16,32,17,31,18,27,19,28,20,28,21,27,22,26,23,22,25,23,26,24,27,24,28,24,29,24,30,24,31,24,32,23,33,22,34,17,34,16,33,15,32,15,31,14,30,14,29,15,28,15,27,16,26,17,25,13,23,12,22,11,21,11,20,12,19,8,18,7,17,6,16,5,15,5,14,6,13,2,12,1,11,0,10,0,9,0,8,0,7,1,6,3,5,4,4,5,3,7,2,9,1,12,0,27,0],
    		type: 'poly'
    	};

    	marker = new google.maps.Marker({
    		draggable: true,
    		raiseOnDrag: false,
    		icon: image,
    		shadow: shadow,
    		shape: shape,
    		map: map,
    		position: markerPosition
    	});

    	myInfoWindowOptions = {
    		content: '<div class="info-window-content"><h4>Hello! I am a Google Map custom marker</h4><p>Drag me around the map and scroll down the page to see what I am made of.</p><p>Upload an image to make one of your own.</p></div>',
    		maxWidth: 275
    	};

    	infoWindow = new google.maps.InfoWindow(myInfoWindowOptions);

    	google.maps.event.addListener(marker, 'click', function() {
    		infoWindow.open(map,marker);
    	});

    	google.maps.event.addListener(marker, 'dragstart', function(){
    		infoWindow.close();
    	});

    	infoWindow.open(map,marker);
    	
    	
    	this.element.;
    },

    onMapDrag : function () {
    },
    
    openPinbord : function () {
    	
    	this.options.pinboardName
    },
    
 // new pin

    
});





// pin

// drag drop

// delete

// create view

// captcha




/*

var map;	
var marker;
var shape;
var myInfoWindowOptions;
var infoWindow;
var center = new google.maps.LatLng(50.915516, 0.346269);
var markerPosition = new google.maps.LatLng(50.875311, 0.351563);




	
function load() {
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
	map = new google.maps.Map(document.getElementById("map"),myMapOptions);
	
	var image = new google.maps.MarkerImage(
	  'marker-images/image.png',
		new google.maps.Size(40,35),
		new google.maps.Point(0,0),
		new google.maps.Point(0,35)
	);

	var shadow = new google.maps.MarkerImage(
	  'marker-images/shadow.png',
		new google.maps.Size(62,35),
		new google.maps.Point(0, 0),
		new google.maps.Point(0,35)
	);

	var shape = {
		coord: [27,0,30,1,32,2,34,3,35,4,36,5,38,6,39,7,39,8,39,9,39,10,38,11,37,12,33,13,34,14,34,15,33,16,32,17,31,18,27,19,28,20,28,21,27,22,26,23,22,25,23,26,24,27,24,28,24,29,24,30,24,31,24,32,23,33,22,34,17,34,16,33,15,32,15,31,14,30,14,29,15,28,15,27,16,26,17,25,13,23,12,22,11,21,11,20,12,19,8,18,7,17,6,16,5,15,5,14,6,13,2,12,1,11,0,10,0,9,0,8,0,7,1,6,3,5,4,4,5,3,7,2,9,1,12,0,27,0],
		type: 'poly'
	};

	marker = new google.maps.Marker({
		draggable: true,
		raiseOnDrag: false,
		icon: image,
		shadow: shadow,
		shape: shape,
		map: map,
		position: markerPosition
	});

	myInfoWindowOptions = {
		content: '<div class="info-window-content"><h4>Hello! I am a Google Map custom marker</h4><p>Drag me around the map and scroll down the page to see what I am made of.</p><p>Upload an image to make one of your own.</p></div>',
		maxWidth: 275
	};

	infoWindow = new google.maps.InfoWindow(myInfoWindowOptions);

	google.maps.event.addListener(marker, 'click', function() {
		infoWindow.open(map,marker);
	});

	google.maps.event.addListener(marker, 'dragstart', function(){
		infoWindow.close();
	});

	infoWindow.open(map,marker);
	
	
	
}

*/