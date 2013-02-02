<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function printTinyMceInitScript ($id,$value) {
    
    //$value = addslashes($value);

    require_once('resource/js/fckeditor/fckeditor.php');
    $oFCKeditor = new FCKeditor("$id") ;
    $oFCKeditor->BasePath = 'resource/js/fckeditor/' ;
    $oFCKeditor->Value = "$value";
    $oFCKeditor->Height = "500px";
    $oFCKeditor->ToolbarSet = 'MyToolbar' ;
    $oFCKeditor->Create();


/*
    ?>
    <script type="text/javascript">
	CKEDITOR.replace( '<?php echo $id; ?>' );
    </script>
    <?php
*/

    /*
    if ($id == "*") {
        $selectMode = "mode:'textareas',";
    } else {
        $selectMode = "mode : 'exact', elements : '$id',";
    }
    ?>
    <script type="text/javascript">
        tinyMCE.init({
        // General options
        <?php echo $selectMode; ?>
        theme : "advanced",
        skin : "o2k7",
        skin_variant : "silver",
        plugins : "safari,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,imagemanager,filemanager,phpimage",

        // Theme options
        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "undo,redo,|,cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,anchor,image,cleanup",
        theme_advanced_buttons3 : "insertdate,inserttime,preview,|,tablecontrols,|,hr,removeformat,visualaid,|,sub,sup",
        theme_advanced_buttons4 : "forecolor,backcolor,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen,|,insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker",
        theme_advanced_buttons5 : "cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage,phpimage,|,swampy_browser",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "center",
        theme_advanced_resizing : true,
        height : "450",

        file_browser_callback : "openSwampyBrowser",
		
        // Drop lists for link/image/media/template dialogs
        template_external_list_url : "js/template_list.js",
        external_link_list_url : "js/link_list.js",
        external_image_list_url : "js/image_list.js",
        media_external_list_url : "js/media_list.js",
        
        forced_root_block : false,
        force_br_newlines : true,
        force_p_newlines : false,
    });


    </script>
    <?php

     */
}
function printNewTinyMceInit ($id) {
    ?>
    tinyMCE.init({
        // General options
        mode : "exact",
        elements : "<?php echo $id; ?>",
        theme : "advanced",
        skin : "o2k7",
        skin_variant : "silver",
        plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups",

        // Theme options
        theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,help,|,forecolor,backcolor",
        theme_advanced_buttons3 : "visualaid,|,sub,sup,|,fullscreen,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,nonbreaking,|,swampy_browser",

        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "none",
        theme_advanced_resizing : true,
        
        height : "450",

	file_browser_callback : "openSwampyBrowser",

        // Example content CSS (should be your site CSS)
        content_css : "resource/css/content.css",

        // Drop lists for link/image/media/template dialogs
        template_external_list_url : "lists/template_list.js",
        external_link_list_url : "lists/link_list.js",
        external_image_list_url : "lists/image_list.js",
        media_external_list_url : "lists/media_list.js",

        forced_root_block : false,
        force_br_newlines : true,
        force_p_newlines : false,

        // Replace values for the template plugin
        template_replace_values : {
                username : "Some User",
                staffid : "991234"
        }
    });
    <?php
}
?>