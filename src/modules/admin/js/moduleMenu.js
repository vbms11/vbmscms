
function showModuleMenu () {
    $(".moduleMenuPanel").slideDown();
}

var EditPanel = {
    
    element : null,
    onComplete : null,
    
    className_editPanel = "vcmsEditPanel",
    
    showContent : function (name,html) {
        this.attach({
            content : html,
            onComplete : onComplete
        });
    },
    
    /**
     * 
     * @param {type} args
     * @returns {undefined}
     */
    attach : function (args) {
        
        if (this.element === null) {
            this.element = document.createElement("div");
            this.element.className = this.className_editPanel;
            var el_margin = document.createElement("div");
            el_margin.className = this.className_editPanelMargin;
            this.element.appendChild(el_margin);
            document.body.appendChild(this.element);
        }
        if (args.content) {
            this.element.innerHTML = args.content;
        }
        if (args.onComplete) {
            this.onComplete = args.onComplete;
            var forms = this.element.getElementsByTagName("form");
            if (forms.length > 0) {
                var thisObject = this;
                forms.addEventListener("submit", function (e) {
                    var inputs = e.target.getElementsByTagName("input");
                    ajaxRequest(e.target.getAttribute("action"),thisObject.onComplete,{},inputs);
                    thisObject.hide();
                    e.preventDefault();
                });
            }
        }
        this.show();
    },
    
    show : function () {
        $(this.element).slideDown();
    },
    
    hide : function () {
        $(this.element).slideUp();
    }
};

var ModuleMenu = {
    
    openModuleMenu : null,
    openCloseTimer : null,
    
    attach : function () {
        
        $(".moduleMenuCategory").each(function(index,object){
            $(object).mouseover(function () {
                $(".moduleMenuGroup").hide();
                ModuleMenu.openModuleMenu = $(this).next().css({
                    "left" : $(".moduleMenuPanel").width()+"px"
                }).show().mouseout(function(){
                    ModuleMenu.onMouseOut();
                }).find("div").mouseover(function(){
                    ModuleMenu.onMouseOver();
                }).end();
            });
        });
        sddwdu.attach({
            items : "moduleName",
            areas : "vcms_area",
            objects : "vcms_module",
            drop : function (object,area,position) {
                ajaxRequest(sortLink,{"id":moduleId,"area":area,position},function(data){
                    // show the edit panel on the side
                    EditPanel.attach({
                        content : data,
                        onComplete : function (data) {
                            sddwdu.createObjectInArea(object,area,data,position);
                        }
                    });
                });
            },
            sort : function (object,area,position) {
                ajaxRequest(sortLink,function(data){},{"id":moduleId,"area":areaId,"pos":i});
            }
        });
    },
    
    onMouseOut : function () {
        var that = this;
        this.openCloseTimer = window.setTimeout(function(){
            that.openModuleMenu.hide();
            that.openModuleMenu = that.openCloseTimer = null;
        },2000);
    },
    
    onMouseOver : function () {
        window.clearTimeout(this.openCloseTimer);
    }
};

$(document).ready(function(){
    ModuleMenu.attach();
});

var vcmsArea = $(".vcms_area");

$.each(vcmsArea,function (index,object) {
    $(".menuModule").sortable({
        connectWith: ".vcms_area",
        cancel: ".toolButtonDiv, vcms_module:not(#vcms_module_"+moduleId+")",
        update: function(event, ui) {
            var areaId = $(object).attr("id").substr(10);
            var moduleId = ui.item.attr("id").substr(12);
            alert("dropped area:"+areaId+" module: "+moduleId);
            $("#vcms_area_"+areaId+" #vcms_module_"+moduleId).each(function (index,o) {
                $(object).find(".vcms_module").each(function (i,child) {
                    if (moduleId === $(child).attr("id").substr(12)) {
                         ajaxRequest(sortLink,function(data){},{"id":moduleId,"area":areaId,"pos":i});
                    }
                });
            });
        }
    });
});

