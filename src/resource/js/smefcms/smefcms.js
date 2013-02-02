



// set opacity

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




// close layer when click-out
// document.onclick = mclose;






/*

// open hidden layer
function mopen(id) {
	// cancel close timer
	mcancelclosetime();
	// close old layer
	if(ddmenuitem) { 
        $(this).removeClass("sddmShow");
        $(this).addClass("sddmHide");
        }
	// get new layer and show it
	ddmenuitem = $("#"+id);
	if(ddmenuitem) {
             $(ddmenuitem).fadeIn("fast", function () {
                 $(this).removeClass("sddmHide");
                $(this).addClass("sddmShow");
           });
        }
}

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






// jquery utils
function jq_randomEffect () {
    var jq_effects = ["blind","bounce","clip","drop","explode","fade","fold",
        "highlight","puff","pulsate","scale","shake","size","slide","transfer"];
    return jq_effects[Math.floor((Math.random() * 100000) % jq_effects.length)];
}

function getWindowDimensions () {
    if (document.body && document.body.offsetWidth) {
        winW = document.body.offsetWidth;
        winH = document.body.offsetHeight;
    }
    if (document.compatMode == 'CSS1Compat' && document.documentElement && document.documentElement.offsetWidth) {
        winW = document.documentElement.offsetWidth;
        winH = document.documentElement.offsetHeight;
    }
    if (window.innerWidth && window.innerHeight) {
        winW = window.innerWidth;
        winH = window.innerHeight;
    }
    return [winW,winH];
}

var tips;
function setForm (o) {
    tips = o;
}
function updateTips( t ) {
    tips.text( t ).addClass( "ui-state-highlight" );
    setTimeout(function() {
        tips.removeClass( "ui-state-highlight", 1500 );
    }, 500 );
}
function checkLength( o, n, min, max ) {
    if ( o.val().length > max || o.val().length < min ) {
        o.addClass( "ui-state-error" );
        updateTips( "Length of " + n + " must be between " + min + " and " + max + "." );
        return false;
    } else {
        return true;
    }
}
function requireFeild(o, n) {
    if (o.val().length < 1) {
        o.addClass( "ui-state-error" );
        updateTips( "Feild " + n + " is required.");
        return false;
    } else {
        return true;
    }
}
function checkRegexp( o, regexp, n ) {
    if (!(regexp.test(o.val()))) {
        o.addClass( "ui-state-error" );
        updateTips( n );
        return false;
    } else {
        return true;
    }
}

var smefCms = null;
function SmefCms (layout) {
    
    
    // chat bar vars
    this.usersOnline = {};
    this.userChats = {};
    
    // notifications bar
    this.notifications = {};
    
    // has functions init and resize
    this.layout = null;
    this.pollInterval = null;
    /* 
     * 
     */
    this.SmefCms = function () {
    }
    
    /*
     *
     */
    this.setLayout = function (layout1) {
        this.layout = layout1;
    }
    
    /*
     *
     */
    this.init = function (url) {
        $(window).resize(function() {
            smefCmsResize();
        });
        if (this.layout != null) {
            this.layout.init();
        }
        // this.startPoll(url);
    }
    
    /*
     *
     */
    this.resize = function (width,height) {
        this.layout.resize(width,height);
    }
    
    /*
     * 
     */
    function pollHandler () {
        
        var response = "";
        var resDoc = "";
        // process response

        // users online
        var ar_el_users = resDoc.getElementsByTagName("user");
        for (i=0; i<ar_el_users.size(); i++) {

            // read the user data and add to userlist
            var el_user = ar_el_users[i];
            var user = {
                "id" : el_user.getElementsByTagName("id")[0].innerText,
                "name" : el_user.getElementsByTagName("name")[0].innerText,
                "image" : el_user.getElementsByTagName("image")[0].innerText
            };
            usersOnline[user["id"]] = user;

            // add the element in the users online menu
            if ($("user_"+user["id"]) == null) {
                $("user_"+user["id"])
            }
        }

        // chat messages

        // notifications
    }
    
    /*
     * 
     */
    this.startPoll = function (url) {
        
        if (this.pollInterval == null) {
            this.pollInterval = window.setInterval("smefCms.pollHandler();",10000);
        }
    }
    
    /*
     * ajax function
     */
    this.ajax = function (url,handler) {
        
        $.ajax({
            "url": url,
            "context": document.body,
            "success": function(data){
                handler(data);
            }
        });
    }
    
    this.addUser = function (user) {
        var userId = "user_"+user['id'];
        $("cmsUsersOnlineMenu").append("<div id='"+userId+"'>"+user['name']+"</div>");
        $(userId).click(function () {
            smefCms.startConversation(user);
        });
    }

    this.startConversation = function (user) {
        var btnId = "chat_"+user['id'];
        var footerButton = "<div class=\"cmsFooterButton\" id=\""+btnId+"\">";
        footerButton += "<span>"+user["name"]+"</span>";
        footerButton += "<div id=\""+btnId+"_menu\" class=\"cmsUserChatBox hide\">";
        footerButton += "<div></div><form><input type='text' name='message'></form></div></div>";
        $("#cmsFooterDivButtons").append(footerButton);
        if (cmsFooterMenuOpenTab) {
            $(cmsFooterMenuOpenTab).slideToggle("slow",function(){});
        }
        cmsFooterMenuOpenTab = $("#"+btnId+"_menu").slideToggle("slow",function(){});
    }
}

smefCms = new SmefCms();

function smefCmsResize () {
    var dim = getWindowDimensions();
    smefCms.resize(dim[0],dim[1]);
}

function smefCmsRender(renderLink) {
    if (layout.reRender != undefined) {
        layout.reRender();
    }
    smefCms.ajax(renderLink,smefCmsRenderHandler);
}

function smefCmsHide (animate) {
    $("#contentHideDiv").fadeOut("slow", function () {});
    $(animate).slideUp("slow", function () {});
}
function smefCmsAddScript (src) {
    var script   = document.createElement("script");
    script.type  = "text/javascript";
    script.src   = src;
    document.head.appendChild(script);
}
function smefCmsAddStyle (href) {
    var style   = document.createElement("script");
    style.type  = "text/css";
    style.rel   = "stylesheet";
    style.href  = href;
    document.head.appendChild(style);
}
function smefCmsRenderHandler (content) {
    // render each script
    $(content).find("script").each(function (key,value) {
        var scriptSrc = $(this).attr("src");
        // add script if script not in header
        var scriptExclude = false;
        $("head").find("script").each(function (key,value) {
            if ($(this).attr("src") == scriptSrc) {
                scriptExclude = true;
            }
        });
        if (!scriptExclude) {
            smefCmsAddScript(scriptSrc);
        }
    });
    // render each style
    $(content).find("style").each(function (key,value) {
        var styleHref = $(this).attr("href");
        // add script if script not in header
        var styleExclude = false;
        $("head").find("link").each(function (key,value) {
            if ($(this).attr("href") == styleHref) {
                styleExclude = true;
            }
        });
        if (!styleExclude) {
            smefCmsAddStyle(styleHref);
        }
    });
    // render each area
    $(content).find("area").each(function (key,value) {
        // get area params
        var areaId = $(this).attr("id");
        var effect = $(this).attr("effect");
        var animate = $(this).attr("animate");
        var vcmsAreaStr = $(this).text();
        // run swap content effect
        switch (effect) {
            case "slide":
                $(animate).slideUp("slow", function () {
                    $(this).find("#vcms_area_"+areaId).each(function (key,value) {
                        $(value).parent().html(vcmsAreaStr);
                        $("#contentHideDiv").fadeIn("slow", function () {});
                    });
                    $(animate).slideDown("slow", function () {});
                });
                break;
            case "fade":
                $(animate).fadeOut("slow", function () {
                    $(this).find("#vcms_area_"+areaId).each(function (key,value) {
                        $(value).parent().html(vcmsAreaStr);
                        $("#contentHideDiv").fadeIn("slow", function () {});
                    });
                    $(animate).fadeIn("slow", function () {});
                });
                break;
        }
    });
}



function validateForm (feilds,message) {
    if (message == undefined) {
        message = "Please fill out the required feilds, they are marked with *";
    }
    result = true;
    $.each(feilds, function (index,object) {
        if (result && $("#"+object).val().trim().length < 1) {
            result = false
        }
    })
    if (result == false) {
        $("body").append("<div id=\"dialog-validation\" title=\"Please Validate Input\"><p>"+message+"</p></div>");
        $("#dialog-validation").dialog({
            autoOpen: true,
            height: 300,
            width: 350,
            modal: true,
            buttons: {
                "Ok": function() {
                    $(this).dialog("close");
                }
            },
            close: function() {
                $("#dialog-validation").remove();
            }
        });
    }
    return result;
}

