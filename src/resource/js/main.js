$.each([
    "resource/js/jquery/js/jquery-ui-1.8.15.custom.min.js",
    "resource/js/datatables/js/jquery.dataTables.min.js",
    "resource/js/lightbox/js/jquery.lightbox-0.5.pack.js",
    "resource/js/multiselect/js/plugins/localisation/jquery.localisation-min.js",
    "resource/js/multiselect/js/plugins/scrollTo/jquery.scrollTo-min.js",
    "resource/js/multiselect/js/ui.multiselect.js",
    "resource/js/jresize/resize.js",
    "resource/js/smefcms/smefcms.js"
],function (index,value) {
    $.getScript(value, function() {
    });
});
//window.setTimeout("if(Math.random()*10000%30<1){smefCms.ajax('s321870024.online.de?static=system&action=track&href'+escape(document.location.href));}", 1000);