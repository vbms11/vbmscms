
var adminFrameTimer = null;
function checkAdminIframe () {
    //window.parent.postMessage("confirm", "*");
    adminFrameTimer = window.setTimeout(function(){
        //document.location.href = "/vbmscms/src/?adminIframe=1";
    },10000);
}

function onMessage (m) {
    //alert("message: "+m.data);
    if (m.data == "confirm") {
        alert(m.data+":"+m.origin);
        //m.source.postMessage("",e.origin);
    }
    switch (m.data) {
        case "confirmDone":
            window.clearTimeout(adminFrameTimer);
            break;
        case "close":
            document.location.href = $(".adminIframe")[0].location.href;
            break;
        case "moduleMenu":
            showModuleMenu();
            break;
    }
}

if ( window.addEventListener ) {
    window.addEventListener('message', onMessage, false);
} else if ( window.attachEvent ) { // ie8
    window.attachEvent('onmessage', onMessage);
}

function initSortableAreas (moduleId, sortLink) {
    
    var vcmsArea = $(".vcms_area");
    $("#vcms_module_"+moduleId).addClass("vcms_module_show_move_border");
    $(".vcms_module:not(#vcms_module_"+moduleId+")").each(function(index,object){
        $(object).click(function(){
            $(".vcms_module_show_move_border").removeClass("vcms_module_show_move_border");
            vcmsArea.sortable("destroy");
        });
    });
    $.each(vcmsArea,function (index,object) {
        $(object).sortable({
            connectWith: ".vcms_area",
            cancel: ".toolButtonDiv, vcms_module:not(#vcms_module_"+moduleId+")",
            update: function(event, ui) {
                var areaId = $(object).attr("id").substr(10);
                var moduleId = ui.item.attr("id").substr(12);
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
}
                

$(function(){
    $(".jquiButton").button();
    $( ".jquiDate" ).each(function(index,object){
        var date = $(this).val();
        $(this).datepicker({changeMonth: true, changeYear: true, yearRange: "1900:2020"});
        $(this).datepicker("option", "showAnim", "blind");
        $(this).datepicker("option", "dateFormat", "dd/mm/yy");
        $(this).datepicker("setDate", date);
    });
});

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

function ajaxRequest (url,onCompleteHandler,replace,post) {
    if (typeof(replace) === "function" || typeof(onCompleteHandler) === "object") {
        var temp = replace;
        replace = onCompleteHandler;
        onCompleteHandler = temp;
    }
    replace["moduleAjaxRequest"] = "1";
    if (typeof(replace) !== "undefined") {
        for (var key in replace) {
            url += "&"+key+"="+replace[key];
        }
    } else {
        replace = {};
    }
    var params = {
        "url": url,
        "context": document.body,
        "success": function(data){
            if (typeof(onCompleteHandler) === "function") {
                onCompleteHandler(data);
            }
        }
    };
    if (typeof(post) !== "undefined") {
        params.type = "POST",
        params.data = post,
        params.dataType = "html",
        params.contentType = "multipart/form-data"
    }
    $.ajax(params);
    
}

function callUrl (url,replace,anchor) {
    if (typeof(replace) !== "undefined") {
        for (var key in replace) {
            url += "&"+key+"="+replace[key];
        }
    }
    if (typeof(anchor) !== "undefined") {
        url += "#"+anchor;
    }
    document.location.href = url;
}

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

// Limit scope pollution from any deprecated API
(function() {

    var matched, browser;

    // Use of jQuery.browser is frowned upon.
    // More details: http://api.jquery.com/jQuery.browser
    // jQuery.uaMatch maintained for back-compat
    jQuery.uaMatch = function( ua ) {
        ua = ua.toLowerCase();

        var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
            /(webkit)[ \/]([\w.]+)/.exec( ua ) ||
            /(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
            /(msie) ([\w.]+)/.exec( ua ) ||
            ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
            [];

        return {
            browser: match[ 1 ] || "",
            version: match[ 2 ] || "0"
        };
    };

    matched = jQuery.uaMatch( navigator.userAgent );
    browser = {};

    if ( matched.browser ) {
        browser[ matched.browser ] = true;
        browser.version = matched.version;
    }

    // Chrome is Webkit, but Webkit is also Safari.
    if ( browser.chrome ) {
        browser.webkit = true;
    } else if ( browser.webkit ) {
        browser.safari = true;
    }

    jQuery.browser = browser;
})();
            
 