
/*
$.each([
    "resource/js/jresize/resize.js",
    "resource/js/smefcms/smefcms.js"
],function (index,value) {
    $.getScript(value, function() {
    });
});
*/
//window.setTimeout("if(Math.random()*10000%30<1){smefCms.ajax('s321870024.online.de?static=system&action=track&href'+escape(document.location.href));}", 1000);

function jq_randomEffect () {
    var jq_effects = ["blind","bounce","clip","drop","explode","fade","fold",
        "highlight","puff","pulsate","scale","shake","size","slide","transfer"];
    return jq_effects[Math.floor((Math.random() * 100000) % jq_effects.length)];
}

function alert (text) {
    $("body").append("<div id=\"dialog-alert\" title=\"Alert\"><p>"+text+"</p></div>");
    $("#dialog-alert").dialog({
        autoOpen: true, height: 300, width: 350, modal: true,
        buttons: {
            "Ok": function() {
                $(this).dialog("close");
            }
        },
        close: function() {
            $("#dialog-alert").remove();
        }
    });
}

function doIfConfirm (text,action,replace) {
    $("body").append("<div id=\"dialog-confirm\" title=\"Confirm\"><p>"+text+"</p></div>");
    $("#dialog-confirm").dialog({
        autoOpen: true,
        height: 300,
        width: 350,
        modal: true,
        buttons: {
            "Ok": function() {
                callUrl(action,replace);
                $(this).dialog("close");
            },"Cancel": function() {
                $(this).dialog("close");
            }
        },
        close: function() {
            $("#dialog-confirm").remove();
        }
    });
}

function ajaxRequest (url,onCompleteHandler,replace) {
    if (typeof(replace) != "undefined") {
        for (var key in replace) {
            url += "&"+key+"="+replace[key];
        }
    }
    smefCms.ajax(url,onCompleteHandler);
}

function callUrl (url,replace,anchor) {
    if (typeof(replace) != "undefined") {
        for (var key in replace) {
            url += "&"+key+"="+replace[key];
        }
    }
    if (typeof(anchor) != "undefined") {
        url += "#"+anchor;
    }
    document.location.href = url;
}


/*
                var vcmsArea = $(".vcms_area")
                $.each(vcmsArea,function (index,object) {
                    $(object).sortable({
                        connectWith: ".vcms_area, .toolButtonDiv",
                        cancel: ".toolButtonDiv, form, input, textarea, button",
                        update: function(event, ui) {
                            var areaId = $(object).attr("id").substr(10);
                            var moduleId = ui.item.attr("id");
                            $("#vcms_area_"+areaId+" #"+moduleId).each(function (index,o) {
                                $(object).find(".vcms_module").each(function (i,child) {
                                    if (moduleId == $(child).attr("id")) {
                                         ajaxRequest('<?php echo NavigationModel::createPageLink(Context::getPageId(),array("action"=>"movemodule"),false); ?>',function(data){},{"id":moduleId.substr(12),"area":areaId,"pos":i});
                                    }
                                });
                            });
                            var toolbar = $("#vcms_area_"+areaId+", .toolButtonDiv");
                            if ($("#vcms_area_"+areaId+" .vcms_module").length > 0) {
                                if (toolbar.hasClass("show")) {
                                    toolbar.fadeOut("fast", function () {
                                        toolbar.addClass("hide");
                                        toolbar.removeClass("show");
                                    });
                                }
                            } else if (toolbar.hasClass("hide")) {
                                toolbar.fadeIn("fast", function () {
                                    toolbar.addClass("show");
                                    toolbar.removeClass("hide");
                                });
                            }
                        }
                    });
                });
                 *
                 */


/* datatable util */

function getSelectedRow (oTableLocal) {
    var aReturn = [];
    var aTrs = oTableLocal.fnGetNodes();     
    for (var i=0; i<aTrs.length; i++) {
        if ($(aTrs[i]).hasClass('row_selected')) {
            aReturn.push(aTrs[i]);
        }
    }
    return aReturn;
}

