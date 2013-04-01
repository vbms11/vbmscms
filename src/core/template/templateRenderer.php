<?php

class TemplateRenderer {
    
    /**
     * returns the pages in given menu
     */
    function getMenu ($menu) {
        if ($this->menus == null) {
            $this->menus = MenuModel::getPagesInMenu();
        }
        return isset($this->menus[$menu]) ? $this->menus[$menu] : null;
    }

    /**
     * returns the pages in all menus
     */
    function getMenus () {
    	return $this->menus;
    }
    
    /**
     * called when an area of the template is to be rendered
     * @param <type> $pageId
     * @param <type> $teplateArea
     */
    function renderTemplateArea ($pageId, $teplateArea) {
        
        echo "<div class='vcms_area' id='vcms_area_$teplateArea' >";

        $areaModules = Context::getModules($teplateArea);
        if (count($areaModules) > 0) {
            foreach ($areaModules as $areaModule) {
                ModuleModel::renderModuleObject($areaModule);
            }
        } else {
            if (Context::hasRole("pages.edit")) {
                ?>
                <div class="toolButtonDiv show">
                    <a class="toolButtonSpacinng" href="<?php echo NavigationModel::createStaticPageLink("insertModule",array("action"=>"insertModule","selectedPage"=>Context::getPageId(),"area"=>$teplateArea,"position"=>-1)); ?>"><img src="resource/img/new.png" class="imageLink" alt="" title="Neues Modul einpflegen" /></a>
                </div>
                <?php
            }
        }
        
        if (Context::hasRole("pages.edit")) {
            ?>
            <script>
            var areaMenuDiv = $('#vcms_area_<?php echo $teplateArea; ?>');
            areaMenuDiv.contextMenu([
                    {'Insert Module':function (menuItem,menu) { callUrl('<?php echo NavigationModel::createStaticPageLink("insertModule",array("action"=>"insertModule","selectedPage"=>Context::getPageId(),"area"=>$teplateArea,"position"=>-1),false); ?>'); }},
                    {'Configure Page':function (menuItem,menu) {   callUrl('<?php echo NavigationModel::createStaticPageLink("pageConfig",array("action"=>"edit","id"=>Context::getPageId()),false); ?>'); }}],
                    {theme:'vista'});
            areaMenuDiv.mouseover(function(){
                $(this).addClass("vcms_area_show_border");
            });
            areaMenuDiv.mouseout(function(){
                $(this).removeClass("vcms_area_show_border");
            });
            </script>
            <?php
        }
        
        echo "</div>";
    }

    /**
     * called when the main area of the template is to be rendred
     * @param <type> $pageId
     * @param <type> $teplateArea
     */
    function renderMainTemplateArea ($pageId, $teplateArea) {
        
        $focusedModuleId = Context::getFocusedArea();
        if ($focusedModuleId != null) {
            echo "<div id='vcms_area_$teplateArea' >";
            Context::setIsFocusedArea(true);
            ModuleModel::renderModuleObject(Context::getModule($focusedModuleId));
            Context::setIsFocusedArea(false);
            echo "</div>";
        } else {
            $this->renderTemplateArea($pageId, $teplateArea);
        }
        
    }
    
    function renderMenu($pageId, $menuName) {

        echo "<div id='vcms_area_$menuName' >";
        foreach (Context::getModules($menuName) as $module) {
            ModuleModel::renderModuleObject($module);
        }
        echo "</div>";
    }

    /**
     * renders the html header
     */
    function renderHtmlHeader () {

        $keywords = ""; $title = ""; $description = "";

        $page = Context::getPage();

        if ($page != null) {
            $title = htmlentities($page->title, ENT_QUOTES);
            $keywords = htmlentities($page->keywords, ENT_QUOTES);
            $description = htmlentities($page->description, ENT_QUOTES);
        }

        ?>
        <title><?php echo $title; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <meta http-equiv="Pragma" content="no-cache"/>
        <meta http-equiv="Expires" content="0"/>
        <meta name="keywords" content="<?php echo $keywords; ?>" />
        <meta name="description" content="<?php echo $description; ?>" />
        <meta name="robots" content="index, follow" />
        <link rel="shortcut icon" href="<?php echo ResourcesModel::createTemplateResourceLink("favicon.ico"); ?>" type="image/x-icon" />
        <link type="text/css" href="resource/css/main.css" media="all" rel="stylesheet"/>
        <script type="text/javascript" src="resource/js/jquery/js/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="resource/js/main.js"></script>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
        <script type="text/javascript" src="resource/js/jquery/js/jquery-ui-1.8.15.custom.min.js"></script>
        <script type="text/javascript" src="resource/js/datatables/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="resource/js/lightbox/js/jquery.lightbox-0.5.pack.js"></script>
        <script type="text/javascript" src="resource/js/multiselect/js/plugins/localisation/jquery.localisation-min.js"></script>
        <script type="text/javascript" src="resource/js/multiselect/js/plugins/scrollTo/jquery.scrollTo-min.js"></script>
        <script type="text/javascript" src="resource/js/multiselect/js/ui.multiselect.js"></script>
        <script type="text/javascript" src="resource/js/smefcms/smefcms.js"></script>
        <!-- elRTE -->
        <script src="resource/js/elrte/js/elrte.min.js" type="text/javascript" charset="utf-8"></script>
        <link rel="stylesheet" href="resource/js/elrte/css/elrte.min.css" type="text/css" media="screen" charset="utf-8"/>
        <script src="resource/js/elrte/js/i18n/elrte.en.js" type="text/javascript" charset="utf-8"></script>
        <!-- elFinder -->
        <link rel="stylesheet" href="resource/js/elfinder/css/elfinder.css" type="text/css" media="screen" title="no title" charset="utf-8"/>
        <script src="resource/js/elfinder/js/elfinder.min.js" type="text/javascript" charset="utf-8"></script>
	
        <link type="text/css" href="resource/js/valums-file-uploader/client/fileuploader.css" media="all" rel="stylesheet"/>
        <script type="text/javascript" src="resource/js/valums-file-uploader/client/fileuploader.js"></script>
        
        <link type="text/css" href="resource/js/contextmenu/jquery.contextmenu.css" media="all" rel="stylesheet"/>
        <script type="text/javascript" src="resource/js/contextmenu/jquery.contextmenu.js"></script>
        
        
        
        <?php
        
        $headerStyles = array();
        $headerScripts = array();
        
        // get module resouces
        $modulesByArea = TemplateModel::getTemplateAreas(Context::getPageId());
        $modules = array();
        foreach ($modulesByArea as $moduleArea) {
            foreach ($moduleArea as $module) {
                if (!isset($modules[$module->typeid])) {
                    $modules[$module->typeid] = $module;
                }
            }
        }
        foreach ($modules as $module) {
            $moduleObj = ModuleModel::getModuleClass($module);
            $styles = $moduleObj->getStyles();
            if ($styles != null || count($styles) != 0) {
                foreach ($styles as $style) {
                    $link = ResourcesModel::createModuleResourceLink($module, $style);
                    $headerStyles[$link] = $link;
                }
            }
            $scripts = $moduleObj->getScripts();
            if ($scripts != null || count($scripts) != 0) {
                foreach ($scripts as $script) {
                    $link = ResourcesModel::createModuleResourceLink($module, $script);
                    $headerScripts[$link] = $link;
                }
            }
        }

        // render module styles
        foreach ($headerStyles as $style) {
            echo '<link rel="stylesheet" type="text/css" href="'.$style.'" />'.PHP_EOL.'        ';
        }
        // render module scripts
        foreach ($headerScripts as $script) {
            echo '<script type="text/javascript" src="'.$script.'" ></script>'.PHP_EOL.'        ';
        }
        
        // get template resources
        $template = TemplateModel::getTemplateObj($page);
        $styles = $template->getStyles();
        if (!Common::isEmpty($styles)) {
            $templateStylePaths = $template->getResourcePaths($styles);
            foreach ($templateStylePaths as $templateStylePath) {
                $headerStyles[$templateStylePath] = $templateStylePath;
            }
        }
        $scripts = $template->getScripts();
        if (!Common::isEmpty($scripts)) {
            $templateScriptPaths = $template->getResourcePaths($scripts);
            foreach ($templateScriptPaths as $templateScriptPath) {
                $headerScripts[$templateScriptPath] = $templateScriptPath;
            }
        }
        
        // menu styles and scripts
        echo '<link rel="stylesheet" type="text/css" href="modules/pages/styles.css.php" />'.PHP_EOL.'        ';
        echo '<script type="text/javascript" src="modules/pages/js/menu.js" ></script>'.PHP_EOL.'        ';

        // render template styles
        foreach ($headerStyles as $style) {
            echo '<link rel="stylesheet" type="text/css" href="'.$style.'" />'.PHP_EOL.'        ';
        }
        // render template scripts
        foreach ($headerScripts as $script) {
            echo '<script type="text/javascript" src="'.$script.'" ></script>'.PHP_EOL.'        ';
        }
    }

    
    function printPlainMenu ($menu,$reRender=null,$animate=null,$effect="slide") {
        ?>
        <div class="sddm">
        <?php
        $menus = $this->getMenu($menu);
        
        if ($menus != null) {
            $first = true;
            foreach ($menus as $page) {
                ?>
                <div>
                    <a class="<?php echo (($first == true) ? "sddmFirst " : "").(($page->selected == true) ? "sddmSelected " : ""); ?>" href="<?php echo NavigationModel::createPageNameLink($page->page->name,$page->page->id); ?>" onmouseout="mclosetime();" onmouseover="mopen('<?php echo "m_".$page->page->id; ?>');"  onclick="<?php if ($reRender != null) { echo NavigationModel::createPageRenderClick($page->page->id,$reRender,"$animate","$effect"); }?>"><?php echo $page->page->name; ?></a> 
                    <?php
                    if (count($page->children) > 0) {
                        ?>
                        <div id="<?php echo "m_".$page->page->id; ?>" class='sddmHide <?php if ($page->selected == true) echo "sddmSelected"; ?>' onmouseover="mcancelclosetime()" onmouseout="mclosetime()">
                        <?php
                        foreach ($page->children as $childPage) {
                            ?>
                            <a href="<?php echo NavigationModel::createPageNameLink($childPage->page->name,$childPage->page->id); ?>" onclick="<?php if ($reRender != null) { echo NavigationModel::createPageRenderClick($page->page->id,$reRender,"$animate","$effect"); }?>" <?php if ($childPage->selected == true) echo "class='sddmSelected'"; ?>><?php echo $childPage->page->name; ?></a>
                            <?php
                        }
                        ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <?php
                $first = false;
            }
        }
        if (Context::hasRole("pages.editmenu")) {
            ?>
            <div class="sddmButton">
                <a href="<?php echo NavigationModel::createStaticPageLink("pages",array("levels"=>"2","menu"=>$menu)); ?>" class="navileft_passive" title="Menu Verwalten">
                    <img class="imageLink" src="resource/img/edit.png"  alt=""/>
                </a>
            </div>
            <?php
        }
        ?>
        </div>
        <?php
    }

    function printLoginMenu () {

        if (Context::isLoggedIn()) {
            ?>
            <a class="loginButton" href="<?php echo NavigationModel::createStaticPageLink("login",array("action"=>"logout")); ?>" title="administrator login">Logout</a>
            <?php
        } else {
            ?>
            <a class="loginButton" href="<?php echo NavigationModel::createStaticPageLink("login"); ?>" title="administrator login">Login</a>
            <?php
        }
    }
    
    function renderTrackerScript ($page) {
	// echo $page->pagetrackerscript.PHP_EOL;
        // echo $page->sitetrackerscript.PHP_EOL;
	// echo $page->domaintrackerscript.PHP_EOL;
    }
    
    function renderFooter () {
        ?>
        <!-- footer -->
        <div id="cmsFooterDiv" class="cmsFooter"></div>
        <div id="cmsFooterDivButtons" class="cmsFooter">
            <div class="cmsFooterButton" id="cmsUsersOnline">
                <?php
                echo "<span id='cmsUsersOnlineText'>(0) Users Online</span>";
                ?>
                <div id="cmsUsersOnlineMenu" class="hide"></div>
            </div>
            <div id="cmsFooterMenu">
                <?php 
                $this->printPlainMenu(24,array("center"),"#contentDivOpacity,#contentDiv","fade"); 
                ?>
            </div>
        </div>
        <?php 
        // echo "querys = ".implode(" <br/>\n<br/>\n<br/> ",$_SESSION['database.querys']); 
        ?>
        <script>
        $("#cmsUsersOnline").click(function () {
            $("#cmsUsersOnlineMenu").slideToggle("slow", function () {});
        });
        $("#cmsUsersOnlineMenu div").click(function () {
            $("#cmsUsersOnlineMenu").slideToggle("slow", function () {});
        });
        </script>
        <?php
    }
    
    function invokeRender () {
        
        if (Context::isAjaxRequest()) {
            if (Context::isRenderRequest()) {
                // rerender request
                $this->handelRenderRequest();
            } else {
                // ajax request
                $module = TemplateModel::getTemplateModule(Context::getModuleId());
                ModuleModel::renderModule($module);
            }
        } else {
            echo '<?xml version="1.0" encoding="ISO-8859-1" ?>'.PHP_EOL;
            echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">'.PHP_EOL;
            // echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">'.PHP_EOL;
            echo '<html xmlns="http://www.w3.org/1999/xhtml">'.PHP_EOL.'<head>'.PHP_EOL;
            $this->renderHtmlHeader();
            echo '</head>'.PHP_EOL.'<body>'.PHP_EOL.'<div id="cmsBodyDiv">'.PHP_EOL;
            $this->render();
            echo '</div>'.PHP_EOL;
            // $this->renderFooter();
	    
            if (Context::hasRole("pages.edit")) {

                echo '<script>'.PHP_EOL;
                ?>
                $("body").contextMenu([
                    {'Configure Page':function (menuItem,menu) {   callUrl('<?php echo NavigationModel::createStaticPageLink("pageConfig",array("action"=>"edit","id"=>Context::getPageId()),false); ?>'); }}],
                    {theme:'vista'});

                <?php /*
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
                ?>
                <?php
                echo '</script>'.PHP_EOL;
            }
            $this->renderTrackerScript(Context::getPage());
            echo '</body>'.PHP_EOL.'</html>'.PHP_EOL;
        }
    }

    function handelRenderRequest () {
        // get render request parameters
        $areas = $_GET['reRender'];
        $areas = explode(",",$areas);
        $animate = $_GET['animate'];
        $effect = $_GET['effect'];
        // set response type to xml
        header ('Content-Type: text/xml; charset=utf-8');
        
        echo "<vcms>".PHP_EOL;
        
        $page = Context::getPage();
        $modulesByArea = TemplateModel::getTemplateAreas(Context::getPageId());
        $modules = array();
        foreach ($modulesByArea as $moduleArea) {
            foreach ($moduleArea as $module) {
                if (!isset($modules[$module->typeid])) {
                    $modules[] = $module;
                }
            }
        }
        foreach ($modules as $module) {
            $moduleObj = ModuleModel::getModuleClass($module);
            $styles = $moduleObj->getStyles();
            if ($styles != null || count($styles) != 0) {
                foreach ($styles as $style) {
                    echo '<style href="'.ResourcesModel::createModuleResourceLink($module, $style).'" />'.PHP_EOL;
                }
            }
            $scripts = $moduleObj->getScripts();
            if ($scripts != null || count($scripts) != 0) {
                foreach ($scripts as $script) {
                    echo '<script src="'.ResourcesModel::createModuleResourceLink($module, $script).'" />'.PHP_EOL;
                }
            }
        }
        $template = TemplateModel::getTemplateObj($page);
        $styles = $template->getStyles();
        if ($styles != null || count($scripts) != 0) {
            foreach ($styles as $style) {
                echo '<link href="'.ResourcesModel::createTemplateResourceLink($style).'" />'.PHP_EOL;
            }
        }
        $scripts = $template->getScripts();
        if ($scripts != null || count($scripts) != 0) {
            foreach ($scripts as $script) {
                echo '<script src="'.ResourcesModel::createTemplateResourceLink($script).'" />'.PHP_EOL;
            }
        }
        
        // check if template is the same
        // tell client to include scripts and styles
        
        // render areas that have changed
        foreach ($areas as $area) {
            echo "<area id='$area' animate='$animate' effect='$effect'><![CDATA[";
            $this->renderTemplateArea(Context::getPageId(),$area);
            echo "]]></area>".PHP_EOL;
        }
        echo "</vcms>".PHP_EOL;
    }
    
    function printWelcomeText () {
        ?>
        Welcome user 
        <?php
        echo Context::getUsername();
    }

}

?>
