
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

(function($) {

var FormEditor = function (element) {

    this.FormItemAbstract = {
	
        "options" : { 
            "id"            : "",
            "domId"         : "",
            "name"          : "Form Item Abstract",
            "value"         : "",
            "label"         : "Label",
            "description"   : "Description",
            "validator"     : "", 
            "maxLength"     : "",
            "minLength"     : "", 
            "required"      : "",
            "styleClass"    : "",
            "typeName"      : "FormItemAbstract",
            "inputName"     : ""
        },
        "getInstance" : function (type) {

            log("getInstance");

            var object = $.extend({},this.FormItemAbstract,type);
            object["options"] = $.extend({},object["options"],type["default"]);
            return object;
        },
      	"getHtml" : function () {
       		return "<div style='border: 1px solid silver;'>No Input Feild</div>";
      	},
        "getOptionsHtml" : function () {

            log("getOptionsHtml");

            var content = "<form><table class='formEditorAttribsTable'><tr>"+
                "<td>Name:</td>"+
                "<td><input name='inputName' type='textfeild' value='"+this.options.inputName+"'/></td></tr><tr>"+
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
                "<td><input name='minLength' type='textfeild' value='"+this.options.minLength+"'/></td></tr><tr>"+
                "<td>Max Length:</td>"+
                "<td><input name='maxLength' type='textfeild' value='"+this.options.maxLength+"'/></td></tr><tr>"+
                "<td>Validator:</td>"+
                "<td><select name='validator'>"+
                "	<option value='none'>(none)</option>"+
                "	<option value='text'>Text</option>"+
                "	<option value='alpha'>Alphabetical</option>"+
                "	<option value='numbers'>Numerical</option>"+
                "	<option value='email'>Email</option>"+
                "</select></td></tr></table></form>";

            return content;
     	},
      	"getPreviewTile" : function () {
            return "<div style='border: 1px solid silver; background: rgb(245,245,245); padding: 2px 5px;'>"+this.options['name']+"</div>";
      	},
        "getItemHtml" : function () {
            return this.getHtml(this.options);
        }
    };

    this.FormItemInput = $.extend({}, this.FormItemAbstract, {
        "default" : {
            "typeName" 	: "FormItemInput",
            "name" 	: "Text Input",
            "cssClass"  : "formItemTypeInput"
        },
        "getHtml" : function (options) {
            return "<input type='text' value='"+options.value+"' name='feild_"+options.domId+"'/>";
        }
    });

    this.FormItemTextArea = $.extend({}, this.FormItemAbstract, {
        "default" : {
            "typeName" 	: "FormItemTextArea",
            "name" 	: "Text Area",
            "cssClass"  : "formItemTypeTextArea"
        },	
        "getHtml" : function (options) {
            return $("<textarea>")
                .attr({'rows':'4', 'cols':'4', 'name':'feild_'+options.domId})
                .text(options.value);
        }
    });
    
    this.FormItemCheckbox = $.extend({}, this.FormItemAbstract, {
        "default" : {
            "typeName"  : "FormItemCheckbox",
            "name"      : "Checkbox",
            "cssClass"  : "formItemTypeCheckbox"
        },	
        "getHtml" : function (options) {
            return "<input type='checkbox' value='"+options.value+"' name='feild_"+options.domId+"'/>";
        }
    });

    this.FormItemDate = $.extend({}, this.FormItemAbstract, {
        "default" : {
            "typeName"  : "FormItemDate",
            "name"      : "Date",
            "cssClass"  : "formItemTypeDate"
        },	
        "getHtml" : function (options) {
            return "<input type='date' value='"+options.value+"' name='feild_"+options.domId+"'/>";
        }
    });

    this.FormItemTime = $.extend({}, this.FormItemAbstract, {
        "default" : {
            "typeName" 	: "FormItemTime",
            "name"      : "Time",
            "cssClass"  : "formItemTypeTime"
        },	
        "getHtml" : function (options) {
            return "<input type='time' value='"+options.value+"' name='feild_"+options.domId+"'/>";
        }
    });

    this.FormItemSelect = $.extend({}, this.FormItemAbstract, {
        "default" : {
            "typeName" 	: "FormItemSelect",
            "name"      : "Select",
            "cssClass"  : "formItemTypeSelect"
        },	
        "getHtml" : function (options) {
            var selectObject = $("<select>").attr({"name":"feild_"+this.domId});
            $(options.value.split(",")).each(function (index,object) {
                var option = $("<option>").attr({"value":object}).text(object);
                if (options.value === object) {
                    option.attr("selected","true");
                }
                selectObject.append(option);
            });
            return selectObject;
        }
    });

    this.FormItemMultiSelect = $.extend({}, this.FormItemAbstract, {
        "default" : {
            "typeName"  : "FormItemMultiSelect",
            "name"      : "Multi Select",
            "cssClass"  : "formItemTypeMultiSelect"
        },	
        "getHtml" : function (options) {
            return "<select name='feild_"+options.domId+"'><option value='"+options.value+"'></option></select>";
        }
    });

    this.options = { 
        'optionsLocation'           : 'left',
        'formItemTypes' : {
            "FormItemInput"         : this.FormItemInput,
            "FormItemTextArea"      : this.FormItemTextArea,
            "FormItemCheckbox"      : this.FormItemCheckbox,
            "FormItemDate"          : this.FormItemDate,
            "FormItemSelect"        : this.FormItemSelect
        }
    };
    
    this.element = $(element);
    this.formItemNumber = 0;
    this.formItems = {};
    this.listOfMethods = {};
    this.selectedItem = null;
    this.hoveredItem = null;
    
    this.init = function (settings) {

        log('init');
        
        this.options = $.extend(this.options,settings);
        
        this.setTemplate();

        log('init: ui');
        this.element.find("div#formEdit_tabsLeft , div#formEdit_tabsCenter").tabs();
        this.element.find("div#formEdit_tabsLeft").tabs('disable', 1);
        this.refreshLeftDragTools();
        this.refreshCenterArea();
        
        if (this.options.json) {
            this.fromJson(this.options.json);
        }
    };

    // set the options panel to display the form item
    this.setOptionsPanel = function (formItem) {
	
	log("setOptionsPanel");
	
        // set options panel html
	var optionsPanel = $("#tab_options .tab_options_margin").html(formItem.getOptionsHtml());
	
        // set value and add change listener
        var itemObject = $('#'+formItem.options.domId);
        $(".formEditorAttribsTable")
            .find("input[name=inputName]").val(formItem.options.inputName)
            .keyup(function () {
                formItem.options.inputName = $(this).val();
            }).end()
            .find("input[name=label]").val(formItem.options.label)
            .keyup(function () {
                formItem.options.label = $(this).val();
                itemObject.find(".formItemLabel").text($(this).val());
            }).end()
            .find("input[name=description]").val(formItem.options.description)
            .keyup(function () {
                formItem.options.description = $(this).val();
                itemObject.find(".formItemDescription").text($(this).val());
            }).end()
            .find("input[name=value]").val(formItem.options.value)
            .keyup(function () {
                formItem.options.value = $(this).val();
                itemObject.find(".formItemInput").empty().append(formItem.getItemHtml());
            })
            .end()
            .find("select[name=validator]")
            .find("option[value="+formItem.options.validator+"]").attr("selected","true").end()
            .change(function () {
                formItem.options.validator = $(this).find("option:selected").val();
            }).end()
            .find("select[name=required]")
            .find("option[value="+formItem.options.required+"]").attr("selected","true").end()
            .change(function () {
                formItem.options.required = $(this).find("option:selected").val();
            }).end()
            .find("input[name=minLength]").val(formItem.options.minLength)
            .keyup(function(){
                formItem.options.minLength = $(this).val();
            }).end()
            .find("input[name=maxLength]").val(formItem.options.maxLength)
            .keyup(function(){
                formItem.options.maxLength = $(this).val();
            }).end();
          
    };

    this.refreshCenterArea = function () {

	log("refreshLeftDragTools");

	var thisObject = this;
        $("div.formPanel").sortable({
            items: "div.formItemDrag",
            connectWith: ".connectedSortable",
            placeholder: "ui-state-highlight",
            accept: "div.formItemDrag",
            axis: 'y',
            sort: function(event,ui) {  
            },
            receive: function (event,ui) {
                thisObject.event_receive_center(event,ui);
            }
  	}).disableSelection();
        
    };
    
    this.event_receive_center = function (event,ui) {
    
        log("event_receive_center "+$(ui.item).attr("id"));

        if ($(ui.item).attr("id") !== undefined && this.options['formItemTypes'][$(ui.item).attr("id")] !== undefined) {
            this.addFormItem($(ui.item).attr("id"), $(ui.item));
            this.refreshLeftDragTools();
        }
    };
    
    this.refreshLeftDragTools = function () {

        log("init: tools");

        var formTypeArea = $("#formEdit_tabsLeft div.tabs_margin");
        $(formTypeArea).empty();
        $.each(this.options['formItemTypes'],function(index,formItemTypeObject){
            formItemTypeObject['options'] = $.extend({},formItemTypeObject['options'],formItemTypeObject['default']);
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
    
    this.getEditorHtml = function () {
        return '<div class="formEdit_center">'+
            '<div id="formEdit_tabsCenter">'+
                '<ul>'+
                '<li><a href="#tab_form">Form Edit</a></li>'+
                '<li><a href="#tab_log">Log</a></li>'+
                '</ul>'+
                '<div id="tab_form">'+
                    '<div class="formPanel connectedSortable"></div>'+
                '</div>'+
                '<div id="tab_log">'+
                    '<div id="logOutput"></div>'+
                '</div>'+
            '</div>'+
        '</div>';
    };

    this.getOptionsHtml = function () {
        return '<div class="formEditOptions">'+
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
        '</div>';
    };

    this.setTemplate = function () {
      
        log('setTemplate');
        
        $template = '<table width="100%"><tr>';
        if (this.options.optionsLocation === 'left') {
            $template += '<td class="formEditOptions">'+
                this.getOptionsHtml()+
                '</td>';
        }
        
        $template += '<td class="formEdit_center">'+
            this.getEditorHtml()+
            '</td>';
    
        if (this.options.optionsLocation === 'right') {
            $template += '<td class="formEditOptions">'+
                this.getOptionsHtml()+
                '</td>';
        }
        
        $template += '</tr></table>';
        this.element.html($template);
     };

     this.addFormItem = function (type, object, options) {

        log('addFormItem');
        
        // get form item instance
        var formItem;
            formItem = this.options["formItemTypes"][type];
            if (formItem === undefined) {
                log("cheated");
                return;
            }
            formItem = this.FormItemAbstract.getInstance(formItem);
        if (options !== undefined) {
            formItem.options = $.extend(formItem.options,options);
        }
        
        // save in formItems array
        if (formItem.options.id === "") {
            do {
                this.formItemNumber++;
            } while (this.formItems[this.formItemNumber] !== undefined);
            formItem.options.id = this.formItemNumber;
        } else if (formItem.options.id > this.formItemNumber) {
            this.formItemNumber = formItem.options.id;
        }
        formItem.options.domId = 'formItem_'+formItem.options.id;
        if (formItem.options.inputName === "") {
            formItem.options.inputName = formItem.options.typeName + formItem.options.id;
        }
        this.formItems[formItem.options.domId] = formItem;

        // remove the preview markup and set id
        $(object).empty().attr('id',formItem.options.domId);

        // insert the form markup
        this.refreshFormItem(formItem);
    };
    
    this.emptyFormItems = function () {
        $(".formPanel").empty();
        this.formItems = Array();
        this.formItemNumber = 0;
    };

    this.refreshFormItem = function (formItem) {

        log("refreshFormItem");

        var thisObject = this;
        $('#'+formItem.options.domId)
            .css("display","none")
            .empty().append(this.getFormItemHtml(formItem))
            .click(function() {		
                $(this).parent().find(".formItemSelected").removeClass("formItemSelected");
                $(this).find('.formItemPanel').addClass("formItemSelected");
                $("div#formEdit_tabsLeft")
                    .tabs('enable', 1)
                    .tabs("option", "active", 1);
                thisObject.selectedItem = $(this).attr("id");
                thisObject.setOptionsPanel(formItem);
            }).mouseover(function(e) {
                if ($(this).attr("id") !== thisObject.hoveredItem && $(this).parent(".formItemDrag").attr("id") !== thisObject.hoveredItem) {
                    if (thisObject.hoveredItem !== null) {
                        $("#"+thisObject.hoveredItem).find(".formItemTools").hide();
                    }
                    if ($(this).hasClass("formItemDrag")) {
                        thisObject.hoveredItem = $(this).attr("id");
                    } else {
                        thisObject.hoveredItem = $(this).parent(".formItemDrag").attr("id");
                    }
                    $("#"+thisObject.hoveredItem).find(".formItemTools").show();
                }
            }).find(".formItemTools").click(function(){
                thisObject.removeFormItem(formItem);
            }).end().slideDown();
    };

    this.getFormItemHtml = function (formItem) {

        log("getFormItemHtml");
        
        var content = $("<div>")
            .attr("class","formItemPanel "+formItem.options.cssClass)
            .html('<div class="formItemTools" style="display:none;"><span class="ui-icon ui-icon-circle-close"></span></div>'+
            '<div class="formItemDescription"></div>'+
            '<div class="formItemLabel"></div>'+
            '<div class="formItemInput"></div>'+
            '<div class="formItemMessage"></div>');
        
        $(content)
            .find(".formItemInput").append(formItem.getItemHtml()).end()
            .find(".formItemDescription").text(formItem.options.description).end()
            .find(".formItemLabel").text(formItem.options.label);
        
        return content;
    };

    this.removeFormItem = function (formItem) {

        log("removeFormItem");
        
        delete this.formItems[formItem.options.domId];
        $("#"+formItem.options.domId).remove();
        
        if (this.selectedItem === formItem.options.domId) {
            $("div#formEdit_tabsLeft")
                .tabs('disable', 1)
                .tabs("option", "active", 0);
            this.selectedItem = null;
        }
    };
    
    this.toJson = function () {
        
        var thisObject = this;
        var formItemsSorted = Array();
        $(".formPanel .formItemDrag").each(function (index,object) {
            formItemsSorted.push(thisObject.formItems[$(object).attr("id")].options);
        });
        
        return JSON.stringify(formItemsSorted);
    };
    
    this.fromJson = function (json) {
        
        var thisObject = this;
        this.emptyFormItems();
        $(JSON.parse(json)).each(function (index,object) {
            var formItem = $("<div>",{"class":"formItemDrag"});
            $(".formPanel").append(formItem);
            thisObject.addFormItem(object.typeName, formItem, object);
        });
    };
    
};

$.fn.formEditor = function (arg1) {
    
    var formEditor;
    this.each(function (index,object) {
        
        // get the object
        if ($.data(this, 'formEditor')) {
            // get the object and call methods
            formEditor = $.data(this, 'formEditor');
            if (formEditor[arg1]) {
                var params = Array.prototype.slice.call(arguments, 1);
                return formEditor[arg1].apply(this, params);
            }
        } else {
            // init the object and return it
            formEditor = new FormEditor(object);
            formEditor.init(arg1);
            $.data(this, 'formEditor', formEditor);
        }
    });
    return formEditor;
};

}(jQuery));