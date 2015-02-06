/**
 * 
 */

$.widget( "custom.pinboardNote", {
    
    // default options
    options: {
		width : "250", 
		height : "250", 
		visible: true, 
		x: null, 
		y: null, 
		pinboard: null
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
        
        var pinboardRectSteps = [
            (this.options.pinboard.element.width() - this.element.width()) / 1000, 
            (this.options.pinboard.element.height() - this.element.height()) / 1000
        ];
        
        // get position
        var position = {};
        $(this.element.attr('class').split(' ')).each(function(index, object) { 
            if (object.indexOf("notex_") === 0) {
            	position.x = (object.substr(6) * pinboardRectSteps[0]);
            } else if (object.indexOf("notey_") === 0) {
            	position.y = (object.substr(6) * pinboardRectSteps[1]);
            }
        });
        
        // if no position generate posistion
        if (position.length != 2) {
        	position = this.options.pinboard.generateNotePosition();
        	this.notifyPositionChanged(position);
        }
        
        // set position
        this.element.css({
    		"left": position.x + "px",
    		"top": position.y + "px"
    	});
        
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
        
        // blur when mouse out
        this.element.mouseout(function(){
        	thisObject.blur();
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
    
    notifyPositionChanged : function (position) {
    	
    	var params = "&action=setNotePosition&noteId="+this.getId()+"&x="+position.x+"&y="+position.y;
    	
		$.get(this.options.pinboard.options.cmdUrl + params, function(data,status){}); 
    },
    
    // put on top of all notes
    focus : function () {
    	
    	var maxZIndex = -1;
    	$(this.element.parent().find(".pinboarNoteInstance")).each(function(index, object){
    		var noteZIndex = $(object).css("z-index");
    		if (noteZIndex > maxZIndex) {
    			maxZIndex = noteZIndex;
    		}
    	});
    	this.element.css({"z-index": maxZIndex + 1});
    },
    
    blur : function () {
    	// hide scrollbars
    },

    show : function () {
    	
    	this.element.fadeIn();
    },
    

    hide : function () {
    	
    	this.element.fadeOut();
    },
    
    highlight : function () {
    	
    	this.element.effect("pulsate", {times:5}, 1000 );
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
	        	if (thisObject.pinboardMenuOpen) {
	        		thisObject.closeMenu();
	        	}
	        }).find(".newNoteButton").click(function () {
	        	thisObject.showCreateNotePanel();
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
    	
    	var thisObject = this;
    	
    	// if notes already in dom, make them pinboardNote instances
    	this.element.find(".pinboardNote").each(function(index, object){
    		if ($(object).hasClass("pinboardNoteInstance")) {
    			// add note to list
	    	} else {
	    		// make it a note
	    		$(object).pinboardNote({
	    			pinboard: thisObject
	    		});
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
    
    showCreateNotePanel : function () {
    	
    	var thisObject = this;
    	
    	this.element.find(".coverPanel").fadeIn("slow",function(){
    		thisObject.elemenet.find(".formPanel").load(thisObject.options.cmdUrl+"&action=createNote",function(){
    			thisObject.elemenet.find(".formPanel form").submit(function (e) {
    				$.post(thisObject.options.cmdUrl+"&action=createNote", $(thisObject.elemenet.find(".formPanel form")).serialize(), function (data) {
    					thisObject.addNote(data);
    					thisObject.element.find(".coverPanel").fadeOut("fast");
    				});
    				e.preventDefault();
    			});
    			thisObject.elemenet.find(".formPanel").slideDown();
    		});
    	});
    },
    
    addNote : function (data) {
    	if (data != undefined) {
    		$(data).appendTo(this.element).pinboardNote({
				pinboard: this
			}).highlight();
    	}
    },
    
    generateNotePosition : function () {
    	
    	// try 5 * 5 positions
    	
    	var noteSize = 250;
    	var resolution = 1000;
    	var pinboardRectSteps = [
			(this.element.width() - noteSize) / resolution, 
			(this.element.height() - noteSize) / resolution
     	];
    	position = {};
    	position.x = (Math.random() * resolution) * pinboardRectSteps[0];
    	position.y = (Math.random() * resolution) * pinboardRectSteps[1];
    	return position;
    	
    	//TODO make better version
    	/*
    	var steps = 5;
    	
    	var bestScore = -1;
    	var bestPosition = {};
    	
    	// get all notes that have a position
    	$notes = this.element.find(".pinboardNote");
    	
    	
    	for (var xi=0; xi<steps; xi++) {
    		for (var xy=0; xy<steps; xy++) {
    			
    			// generate a random position
    			var x = ((pinboardRectSteps[0] / steps) % Math.rand(10000)) + (xi * (pinboardRectSteps[0] / steps));
    			var y = ((pinboardRectSteps[1] / steps) % Math.rand(10000)) + (yi * (pinboardRectSteps[1] / steps));
    			
    			// check score
    			var score = 0;
    			
    			// check for collision with other notes
    			
    			if (bestScore == -1 || bestScore > score) {
    				bestScore == score;
    				bestPosition.x = x;
    				bestPosition.y = y;
    			}
    		}
    	}
    	*/ 
    }
    
});
