/**
 * 
 */

$.widget( "custom.pinboardNote", {
    
    // default options
    options: {
		width : "500",
		height : "500",
		visible: true, 
		cmdUrl: null,
		x: null,
		y: null
	},
    
	noteMenuOpen: false, 
	
    // the constructor
    _create: function () {
        
        this.element
            .addClass("pinboardNoteInstance")
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
            .removeClass("pinboardNoteInstance")
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
        
        // make the note draggable
        this.element.draggable({ 
        	containment: this.options.pinboard, 
        	scroll: false, 
			stop: function() {
				thisObject.notifyPositionChanged();
			}
		});
        
        // focus the note when clicked
        this.element.mousedown(function(){
        	thisObject.focus();
        });
        
        this.element.find(".noteOptionsButton")
        	.mouseover(function () {
	        	if (!thisObject.noteMenuOpen) {
	        		thisObject.openMenu();
	        	}
	        }).mouseout(function () {
	        	// thisObject.notifyCloseMenu();
	        }).end()
        .find(".noteButtons")
        	.mouseout(function () {
	        	if (thisObject.noteMenuOpen) {
	        		thisObject.closeMenu();
	        	}
        	});
        
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
    	
    	this.element.css({"width": width, "height": height});
    },
    
    getId : function () {
    	
    	return this.element.attr("id").substr(5);
    },
    
    notifyPositionChanged : function () {
    	
    	var position = this.element.position();
    	var params = "&noteId="+this.getId()+
    				"&cmd=move"+
					"&xpos="+position.left+
					"&ypos="+position.top;
    	
		$.get(this.options.cmdUrl + params, function(data,status){
    		
    	}); 
    },
    
    // put on top of all notes
    focus : function () {
    	
    	var maxZIndex = -1;
    	$(this.element.parent.find(".pinboarNoteInstance")).each(function(index, object){
    		var noteZIndex = $(object).css("z-index");
    		if (noteZIndex > maxZIndex) {
    			maxZIndex = noteZIndex;
    		}
    	});
    	this.element.css({"z-index": maxZIndex + 1});
    },

    show : function () {
    	
    	this.element.fadeIn();
    },
    

    hide : function () {
    	
    	this.element.fadeOut();
    },
    
	openMenu : function () {
		var thisObject = this;
		this.element.find(".noteButtons").slideDown(function(){
    		thisObject.pinboardMenuOpen = true;
		});
    },
    
	closeMenu : function () {
		var thisObject = this;
		this.element.find(".noteButtons").slideUp(function(){
    		thisObject.pinboardMenuOpen = false;
		});
    },

    
});





$.widget( "custom.pinboard", {
    
    // default options
    options: {
		width : "500",
		height : "500",
		visible: true,
		cmdUrl: null
	},
    
	pinboardMenuOpen: false,
	
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
        
        this.element.find(".pinboardNewButton")
        	.mouseover(function () {
	        	if (!thisObject.pinboardMenuOpen) {
	        		thisObject.openMenu();
	        	}
	        }).mouseout(function () {
	        	// thisObject.notifyCloseMenu();
	        }).end()
        .find(".pinboardNewButtons")
        	.mouseout(function () {
	        	if (thisObject.pinboardMenuOpen) {
	        		thisObject.closeMenu();
	        	}
        	});
        
        this.completeAttach();
    },
    
    completeAttach : function () {
        
        var thisObject = this;
        
        this.updateNotes();
        
        this.show();
        
        if (this.attachCompleteListener) {
            this.attachCompleteListener();
        }
    },
    
    resize : function (width, height) {
    	
    	this.element.css({"width": width, "height": height});
    },
    

    show : function () {
    	
    	this.element.fadeIn();
    },
    

    hide : function () {
    	
    	this.element.fadeOut();
    },
    
	openMenu : function () {
		var thisObject = this;
		this.element.find(".pinboardNewButtons").slideDown(function(){
    		thisObject.pinboardMenuOpen = true;
		});
    },
    
	closeMenu : function () {
		var thisObject = this;
		this.element.find(".pinboardNewButtons").slideUp(function(){
    		thisObject.pinboardMenuOpen = false;
		});
    },
    
    updateNotes : function () {
    	
    	// if notes already in dom, make them pinboardNote instances
    	this.element.find(".pinboarNote").each(function(index, object){
    		if ($(object).hasClass(".pinboarNoteInstance")) {
    			// add note to list
	    	} else {
	    		// make it a note
	    		$(object).pinboarNote(thisObject);
	    	}
    	});
    	
    	// add timer to update pinboard notes
    	
    	/*
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
            	thisObject.addNote(newPinbords[id]);
            }
            
            // remove pinboards no longer in view
            for (var pinboard in oldPinbords) {
                thisObject.removeNote(pinboard);
            }
            
        });
        */
    },
    
    addNote : function () {
    	
    }
 // new pin

    
});
