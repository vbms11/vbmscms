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




// pin

// drag drop

// delete

// create view

// captcha

