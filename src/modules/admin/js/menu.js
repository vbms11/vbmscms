

/* menu */

var timeout	= 100;
var closetimer	= {};
var openMenuLayers = [];

// called when mouse over happens on a menu layer
function mopen (idArr) {
    $.each(openMenuLayers,function (index,object) {
        if (!$.contains(idArr,object)) {
            // alert("closing menu layer");
            // mCloseMenuLayer(object);
        }
    });
    mOpenMenuLayer(idArr);
}

// opens the menu layer
function mOpenMenuLayer (idArr) {
    if ($.isArray(idArr)) {
        openMenuLayers = idArr;
        $.each(idArr,function(index,object) {
            mDoOpenMenuLayer(object);
        });
    } else {
        openMenuLayers = [idArr];
        mDoOpenMenuLayer(idArr);
    }
}

// closes the menu layer
function mCloseMenuLayer (idArr) {
    if ($.isArray(idArr)) {
        $.each(idArr,function(index,object) {
            mDoCloseMenuLayer(object);
        });
    } else {
        mDoCloseMenuLayer(idArr);
    }
}


// opens the layer
function mDoOpenMenuLayer (id) {
    mcancelclosetime(id);
    var item = $("#"+id);
    if (item && (item.hasClass("sddmShow") == false)) {
        item.removeClass("sddmHide");
        item.addClass("sddmShow");
        
        if (item.offset()) {
            if (item.offset().top + item.height() > $(window).height()) {
                item.css({"top":"-"+item.height()+"px"});
            }
        }
    }
}

// closes the layer
function mDoCloseMenuLayer (id) {
    var item = $("#"+id);
    if (item && (item.hasClass("sddmHide") == false || closetimer[id] == null)) {
        item.removeClass("sddmShow");
        var selected = false;
        if (item.hasClass("sddmSelected")) {
            selected = true;
            item.removeClass("sddmSelected")
        }
        item.addClass("sddmHide");
        if (selected) {
            item.addClass("sddmSelected")
        }
    }
}

// close showed layer
function mclose(id) {
    closetimer[id] = null;
    mCloseMenuLayer(id);
}

// go close timer
function mclosetime(id) {
    var mcloseFunc = 'mclose(\''+id+'\')'
    closetimer[id] = window.setTimeout(mcloseFunc, timeout);
}

// cancel close timer
function mcancelclosetime(id) {
    if(closetimer[id] != null) {
        window.clearTimeout(closetimer[id]);
        closetimer[id] = null;
    }
}

$(function() {
    $(".sddm a").mouseover(function(){
        var openDivs = [];
        var childDiv = $(this).parent().find("div");
        if (childDiv) {
            openDivs.push(childDiv.first().attr("id"));
        }       
        $(this).parents(".sddm div").each(function(index,object){
            openDivs.push($(object).attr("id"));
        });
        mopen(openDivs);
    });
    $(".sddm a").mouseout(function(){
        var closeDiv = $(this).parent().find("div");
        if (closeDiv) {
            mclosetime(closeDiv.attr("id"));
        }
    });
    $(".sddm div div").mouseout(function(){
        mclosetime($(this).attr("id"));
    });
    $(".sddm div div").mouseover(function(){
        var openDivs = [$(this).attr("id")];
        $(this).parents(".sddm div").each(function(index,object){
            openDivs.push($(object).attr("id"));
        });
        mopen(openDivs);
    });
});






