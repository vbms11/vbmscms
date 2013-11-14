
function log (message) {
	$('#logOutput').append(message+"<br/>");
}
function dump(obj) {
    var out = obj + "\n";
    for (var i in obj) {
        out += i + ": " + obj[i] + "\n";
    }
    log(out);
alert(out);
}

// $.fn.formEditor = 

var FormEditor = $.fn.formEditor = function () {

 this.FormItemAbstract = {
	
	"options" : { 
		"id" 		: "",
		"domId"		: "",
		"name"		: "Form Item Abstract",
		"value"		: "",
		"label"		: "",
		"description" 	: "",
		"validator" 	: "", 
		"maxLength" 	: "",
		"minLength" 	: "", 
		"required" 	: "",
		"styleClass" 	: "",
		"typeName" 	: "FormItemAbstract"
	},
	"getInstance" : function (type) {

		log("getInstance");

		var object = $.extend({},FormEditor.FormItemAbstract,type);
                object["options"] = $.extend({},object["options"],type["default"]);
                object.generateAccessors();
		return object;
	},
  	"getHtml" : function () {
   		return "<div style='border: 1px solid silver;'>No Input Feild</div>";
  	},
  	"getPreviewTile" : function () {
   		return "<div style='border: 1px solid silver;'>No Preview</div>";
  	},
	"generateAccessors" : function () {
		
		log("generateAccessors");

		for (var option in this.options) {
			if(this.options.hasOwnProperty(option)) {

				var optionName = option.substring(0,1).toUpperCase() + option.substring(1);
				this["get"+optionName] = function () {
					return this.options[option];
				};
				this["set"+optionName] = function (value) {
					this.options[option] = value;
				};
			}
		}
	},
  	"getOptionsHtml" : function () {
		
		log("getOptionsHtml");
		
		var content = "<form><table class='formEditorAttribsTable'><tr>"+
			"<td>Label:</td>"+
			"<td><input name='label' type='textfeild' value='"+this.options.label+"'/></td></tr><tr>"+
			"<td>Value:</td>"+
			"<td><input name='value' type='textfeild' value='"+this.options.value+"'/></td></tr><tr>"+
			"<td>Description:</td>"+
			"<td><input name='description' type='textfeild' value='"+this.options.description+"'/></td></tr><tr>"+
			"<td>Required:</td>"+
			"<td><select name='required'>"+
			"	<option value='0'>No</option>"+
			"	<option value='1'>Yes</option>"+
			"</select></td></tr><tr>"+
			"<td>Min Length:</td>"+
			"<td><input name='minLength' type='textfeild' value='"+this.options.description+"'/></td></tr><tr>"+
			"<td>Max Length:</td>"+
			"<td><input name='maxLength' type='textfeild' value='"+this.options.description+"'/></td></tr><tr>"+
			"<td>Validator:</td>"+
			"<td><select name='validator'>"+
			"	<option value=''>(none)</option>"+
			"	<option value='text'>Yes</option>"+
			"	<option value='alpha'>Yes</option>"+
			"	<option value='numbers'>Yes</option>"+
			"	<option value='alphaNumbers'>Yes</option>"+
			"	<option value='email'>Yes</option>"+
			"</select></td></tr></table></form>";

		return content;
 	},
  	"getPreviewTile" : function () {
   		return "<div style='border: 1px solid silver; background: rgb(245,245,245); padding: 2px 5px;'>"+this.options['name']+"</div>";
  	}
};		

this.FormItemInput = $.extend({}, this.FormItemAbstract, {
  	"default" : {
		"typeName" 	: "FormItemInput",
		"name" 		: "Text Input"
	},
	"getHtml" : function () {
   		return "<input type='text' value='"+this.options['value']+"' name='feild_"+this.domId+"'/>";
  	}

});

this.FormItemTextArea = $.extend({}, this.FormItemAbstract, {
	"default" : {
		"typeName" 	: "FormItemTextArea",
		"name" 		: "Text Area"
	},	
  	"getHtml" : function () {
   		return "<textarea rows='4' cols='4' value='"+this.options['value']+"' name='feild_"+this.domId+"'></textarea>";
  	}
});


this.FormItemCheckbox = $.extend({}, this.FormItemAbstract, {
	"default" : {
		"typeName" 	: "FormItemCheckbox",
		"name" 		: "Checkbox"
	},	
  	"getHtml" : function () {
   		return "<input type='checkbox' value='"+this.options['value']+"' name='feild_"+this.domId+"'/>";
  	}
});

this.FormItemRadio = $.extend({}, this.FormItemAbstract, {
	"default" : {
		"typeName" 	: "FormItemRadio",
		"name" 		: "Radio"
	},	
  	"getHtml" : function () {
   		return "<input type='' value='"+this.options['value']+"' name='feild_"+this.domId+"'/>";
  	}
});

this.FormItemPassword = $.extend({}, this.FormItemAbstract, {
	"default" : {
		"typeName" 	: "FormItemPassword",
		"name" 		: "Password"
	},	
  	"getHtml" : function () {
   		return "<input type='password' value='"+this.options['value']+"' name='feild_"+this.domId+"'/>";
  	}
});

this.FormItemDate = $.extend({}, this.FormItemAbstract, {
	"default" : {
		"typeName" 	: "FormItemDate",
		"name" 		: "Date"
	},	
  	"getHtml" : function () {
   		return "<input type='date' value='"+this.options['value']+"' name='feild_"+this.domId+"'/>";
  	}
});

this.FormItemTime = $.extend({}, this.FormItemAbstract, {
	"default" : {
		"typeName" 	: "FormItemTime",
		"name" 		: "Time"
	},	
  	"getHtml" : function () {
   		return "<input type='time' value='"+this.options['value']+"' name='feild_"+this.domId+"'/>";
  	}
});

this.FormItemSelect = $.extend({}, this.FormItemAbstract, {
	"default" : {
		"typeName" 	: "FormItemSelect",
		"name" 		: "Select"
	},	
  	"getHtml" : function () {
   		return "<select name='feild_"+this.domId+"'><option value='"+this.options['value']+"'></option></select>";
  	}
});

this.FormItemMultiSelect = $.extend({}, this.FormItemAbstract, {
	"default" : {
		"typeName" 	: "FormItemMultiSelect",
		"name" 		: "Multi Select"
	},	
  	"getHtml" : function () {
   		return "<select name='feild_"+this.domId+"'><option value='"+this.options['value']+"'></option></select>";
  	}
});

this.FormItemFile = $.extend({}, this.FormItemAbstract, {
	"default" : {
		"typeName" 	: "FormItemFile",
		"name" 		: "File Upload"
	},	
  	"getHtml" : function () {
   		return "<input type='file' value='"+this.options['value']+"' name='feild_"+this.domId+"'/>";
  	}
});

this.FormItemMultiFile = $.extend({}, this.FormItemAbstract, {
	"default" : {
		"typeName" 	: "FormItemMultiFile",
		"name" 		: "Multi File Upload"
	},	
  	"getHtml" : function () {
   		return "<input type='file' value='"+this.options['value']+"' name='feild_"+this.domId+"'/>";
  	}
});


this.options = { 
	'formItemTypes' : {
   		"FormItemInput" 	: this.FormItemInput,
   		"FormItemTextArea" 	: this.FormItemTextArea,
		"FormItemCheckbox" 	: this.FormItemCheckbox,
		"FormItemRadio" 	: this.FormItemRadio,
		"FormItemPassword" 	: this.FormItemPassword,
		"FormItemDate" 		: this.FormItemDate,
		"FormItemTime" 		: this.FormItemTime,
		"FormItemSelect" 	: this.FormItemSelect,
		"FormItemMultiSelect" 	: this.FormItemMultiSelect,
		"FormItemFile" 		: this.FormItemFile,
		"FormItemMultiFile" 	: this.FormItemMultiFile
  	}
};
this.formItemNumber = 0;
this.formItems = [];
this.listOfMethods = {};
this.selectedItem = null;
 
this.init = function (object) {
  
	log('init');
  
  	this.setTemplate(object);

	log('init: ui');
  	$(object).find("div#formEdit_tabsLeft , div#formEdit_tabsCenter").tabs();
	$("div#formEdit_tabsLeft").tabs('disable', 1);
	this.refreshLeftDragTools();
	this.refreshCenterArea();

};

// set the options panel to display the form item
this.setOptionsPanel = function (formItem) {
	
	log("setOptionsPanel");
	
	var optionsPanel = $("#tab_options .tab_options_margin").html(formItem.getOptionsHtml());
	$(optionsPanel).find("select , input, textarea").change(function(){
		$("#".formItem.getDomId()).find()
		
		// set the values in the options panel
		$(".formEditorAttribsTable")
			.find("input[name=value]").val(formItem.getValue())
			.find("input[name=label]").val(formItem.getLabel()).end()
			.find("input[name=message]").val(formItem.getMessage()).end()
			.find("input[name=required]").val(formItem.getRequired()).end()
			.find("input[name=validator]").val(formItem.getValidator()).end()
			.find("input[name=minLength]").val(formItem.getMinLength()).end()
			.find("input[name=maxLength]").val(formItem.getMaxLength()).end()
			.find("input[name=description]").val(formItem.getDescription()).end()
			.find("input[name=description]").change(function(){
				formItem.setDescription($(this).val());
				$('#'+formItem.getDomId()).find(".formItemDescription").text($(this).val());
			}).end()
			.find("input[name=label]").change(function(){
				formItem.setLabel($(this).val());
				$('#'+formItem.getDomId()).find(".formItemLabel").text($(this).val());
			}).end()
			.find("input[name=label]").change(function(){
				formItem.setValue($(this).val());
				// formItem.setDomValue($(this).val());
			}).end();
	});
};

this.refreshCenterArea = function () {

	log("refreshLeftDragTools");

	var thisObject = this;
  	$("#formEdit_tabsCenter div.form_margin").sortable({
   		items: "div.formItemDrag",
   		connectWith: ".connectedSortable",
   		placeholder: "ui-state-highlight",
   		accept: "div.formItemDrag", 
   		sort: function(event,ui) {  
   		},
   		receive: function (event,ui) {
			thisObject.event_receive_center(event,ui)
		}
  	}).disableSelection();
};

this.event_receive_center = function (event,ui) {
	log("event_receive_center "+$(ui.item).attr("id"));
	if ($(ui.item).attr("id") != undefined && this.options['formItemTypes'][$(ui.item).attr("id")] != undefined) {
		this.addFormItem($(ui.item).attr("id"), $(ui.item));
		this.refreshLeftDragTools();
	}
}

this.refreshLeftDragTools = function () {

	log("init: tools");

	var formTypeArea = $("#formEdit_tabsLeft div.tabs_margin");
	$(formTypeArea).empty();
  	$.each(this.options['formItemTypes'],function(index,formItemTypeObject){
    		formItemTypeObject['options'] = $.extend({},formItemTypeObject['options'],formItemTypeObject['default'])
                var previewTile = $("<div>")
			.attr('id', formItemTypeObject['options']['typeName'])
			.addClass('formItemDrag')
			.append(formItemTypeObject.getPreviewTile());
    		formTypeArea.append(previewTile);
  	});
  	$("#formEdit_tabsLeft div.tabs_margin").sortable({
   		connectWith: ".connectedSortable",
   		placeholder: "ui-state-highlight",
		items: "div.formItemDrag",
		accept: false
  	});
};

    this.setTemplate = function (object) {
  
	log('setTemplate');

        $(object).html(''+
            '<table width="100%"><tr><td class="formEdit_left"><div class="formEdit_left">'+
            '<div id="formEdit_tabsLeft">'+
            '<ul>'+
            '<li><a href="#tab_feilds">Feilds</a></li>'+
            '<li><a href="#tab_options">Options</a></li>'+
            '</ul>'+
            '<div id="tab_feilds">'+
            '<div class="tabs_margin connectedSortable"></div>'+
            '</div>'+
            '<div id="tab_options">'+
            '<div class="tab_options_margin"></div>'+
            '</div>'+
            '</div>'+
            '</div>'+
            '</td><td class="formEdit_center">'+
            '<div class="formEdit_center">'+
            '<div id="formEdit_tabsCenter">'+
            '<ul>'+
            '<li><a href="#tab_form">Form Edit</a></li>'+
            '<li><a href="#tab_log">Log</a></li>'+
            '</ul>'+
            '<div id="tab_form">'+
            '<div class="form_margin connectedSortable"></div>'+
            '</div>'+
            '<div id="tab_log">'+
            '<div id="logOutput"></div>'+
            '</div>'+
            '</div>'+
            '</div>'+
            '</td></tr></table>');

	/*
	$('.splitter').draggable({    
		axis: 'x',
		containment: '#content',
		distance: 200,
		drag: function(event, ui) {
			var width = $(object).width();
			$('#content .leftpane').css({ width: ui.position.left + 'px' });
			$('#content .rightpane').css({ 
				margin-left: ui.position.left + 3 + 'px',
				width: (width - ui.position.left + 1) + 'px'
			});
		},
		refreshPositions: true,
		scroll: false
	});
	*/

 };


 this.addFormItem = function (type, object) {
	
	log('addFormItem');

	var formItem = this.options["formItemTypes"][type];
	if (formItem == undefined) {
		log("cheated");
	} else {
		// create and save new item
		formItem = this.FormItemAbstract.getInstance(formItem);
		do {
			this.formItemNumber++;
		} while (this.formItems[this.formItemNumber] != undefined);
		formItem.setId(this.formItemNumber);
		formItem.setDomId('formItem_'+formItem.getId());
		this.formItems[formItem.getDomId()] = formItem;
		
		// remove the preview markup and set id
		$(object).children().remove().end().attr('id',formItem.getDomId());
	
		// insert the form markup
		this.refreshFormItem(formItem);
		
 	}
};

this.refreshFormItem = function (formItem) {

	log("refreshFormItem");

	var thisObject = this;
	var itemObject = $('#'+formItem.getDomId());
	
	itemObject.css("display","none");
	itemObject.html(this.getFormItemHtml(formItem));
	itemObject.click(function() {		
		$(this).parent().find(".formItemSelected").removeClass("formItemSelected");
		$(this).find('.formItemPanel').addClass("formItemSelected");
		thisObject.setOptionsPanel(formItem);
		$("div#formEdit_tabsLeft").tabs('enable', 1);
		$("div#formEdit_tabsLeft").tabs('select', 1);
	}).mouseover(function(e) {
		$(this).find(".formItemTools").fadeIn();
		$(this).preventDefault();
		return false;
	}).mouseout(function(e) {
		$(this).find(".formItemTools").fadeOut();
		$(this).preventDefault();
		return false;
	}).find(".formItemTools").click(function(){
		thisObject.removeFormItem(formItem);
	}).end().slideDown();
};

this.getFormItemHtml = function (formItem) {

	log("getFormItemHtml");

	var content = '<div class="formItemPanel">'+
		'<div class="formItemTools" style="display:none;"><span class="ui-icon ui-icon-circle-close"></span></div>'+
      		'<div class="formItemDescription">'+formItem.getDescription()+'</div>'+
      		'<div class="formItemLabel">'+formItem.getLabel()+'</div>'+
      		'<div class="formItemInput">'+formItem.getHtml()+'</div>'+
      		'<div class="formItemMessage"></div>'+
		'</div>';
	return content;
};

this.removeFormItem = function (formItem) {

	log("removeFormItem");

	this.formItems[formItem.getDomId()];
	$("#"+formItem.getDomId()).remove();
};



};

