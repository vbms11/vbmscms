
function showModuleMenu () {
    $(".moduleMenuPanel").slideDown();
}

$(document).ready(function(){
    $(".moduleMenuCategory").each(function(index,object){
        $(object).mouseover(function () {
            $(".moduleMenuGroup").hide();
            $(this).next().css({
                "left" : $(".moduleMenuPanel").width()+"px"
            }).show().mouseout(function(){
                $(this).hide();
            });
        });
});
        
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

