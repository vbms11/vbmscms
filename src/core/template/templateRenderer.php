<?php

class TemplateRenderer {
    
    /**
     * returns the pages in given menu
     */
    function getMenu ($menu, $parent = null) {
        if ($this->menus == null) {
            $this->menus = MenuModel::getPagesInMenu();
        }
        if (!empty($parent)) {
            $childs = array();
            foreach ($this->menus as $menu) {
                if ($menu->parent == $parent) {
                    $childs[] = $menu;
                }
            }
            return $childs;
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
    
    /**
     * renders a menu in for the given area name
     * 
     * @param <type> $pageId
     * @param <type> $menuName
     */
    function renderMenu ($pageId, $menuName) {
        // get the menu module
        $menuModule = null;
        $menuAreaModules = Context::getModules($menuName);
        foreach ($menuAreaModules as $module) {
            if (isset($module->code) && $module->code == $menuName) {
                $menuModule = $module;
            }
        }
        // create it if it dose not exist
        if ($menuModule == null) {
            $menuModule = TemplateModel::getStaticModule($menuName,$menuName);
            Context::addModule($menuModule);
        }
        // render the menu
        echo "<div id='vcms_area_$menuName' >";
        foreach (Context::getModules($menuName) as $module) {
            ModuleModel::renderModuleObject($module);
        }
        echo "</div>";
    }

    /**
     * renders a static module area by sysname and area name
     *
     * @param <type> $pageId
     * @param <type> $moduleName
     * @param <type> $areaName
     */
    function renderStaticModule ($moduleSysName, $areaName = null, $pageId = null) {
        $this->renderModule($moduleSysName,$areaName,true,$pageId);
    }
    
    /**
     * renders an instance module area by sysname and area name
     *
     * @param <type> $pageId
     * @param <type> $moduleName
     * @param <type> $areaName
     */
    function renderInstanceModule ($moduleSysName, $areaName = null, $pageId = null) {
        $this->renderModule($moduleSysName,$areaName,false,$pageId);
    }

    /**
     * renders a module by module type, template area name and static (false = new module instance per page)
     * @param type $moduleType
     * @param type $areaName
     * @param type $static
     * @param type $pageId
     * @param type $targetOnly
     */
    function renderModule ($moduleType, $areaName = null, $static = false, $pageId = null, $targetOnly = false) {
        if (empty($pageId)) {
            $pageId = Context::getPageId();
        }
        if (empty($areaName)) {
            $areaName = $moduleType;
        }
        // find target module
        $modules = Context::getModules($areaName);
        $targetModule = null;
        foreach ($modules as $module) {
            if ($module->sysname == $moduleType) {
                $targetModule = $module;
            }
        }
        // create module if it dose not exist
        if (empty($targetModule)) {
            if ($static) {
                TemplateModel::createStaticModule($areaName, $moduleType);
            } else {
                $module = ModuleModel::getModuleByName($moduleType);
                $newModuleId = TemplateModel::insertTemplateModule($pageId, $areaName, $module->id);
                $newModule = ModuleModel::getModule($newModuleId);
                Context::addModule($newModule);
                $targetModule = $newModule;
            }
            $modules = Context::getModules($areaName);
        }
        // render area with module in it
        echo "<div id='vcms_area_$areaName' >";
        if ($targetOnly) {
            ModuleModel::renderModuleObject($targetModule);
        } else {
            foreach ($modules as $areaModules) {
                foreach ($areaModules as $areaModule) {
                    if ($areaModule->moduleAreaName == $areaName) {
                        ModuleModel::renderModuleObject($module);
                    }
                }
            }
        }
        echo "</div>";
    }

    /**
     * renders the html header
     */
    function renderHtmlHeader () {

        $page = Context::getPage();
        
        // print page meta data
        $keywords = ""; $title = ""; $description = "";
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
        <?php

        // print page resource links
        $headerStyles = array();
        $headerScripts = array();

        // get module resouces
        $modulesByArea = Context::getModules();
        foreach ($modulesByArea as $modulesInArea) {
            foreach ($modulesInArea as $module) {
                $scripts = $module->getScripts();
                if (!empty($scripts)) {
                    foreach ($scripts as $script) {
                        if (strpos($script,'http://') === 0 || strpos($script,'https://') === 0) {
                            $link = $script;
                        } else if (strpos($script,'/') === 0) {
                            $link = substr($script,1);
                        } else {
                            $link = ResourcesModel::createModuleResourceLink($module, $script);
                        }
                        $headerScripts[$link] = $link;
                    }
                }
                $styles = $module->getStyles();
                if (!empty($styles)) {
                    foreach ($styles as $style) {
                        if (strpos($style,'http://') === 0 || strpos($style,'https://') === 0) {
                            $link = $style;
                        } else if (strpos($style,'/') === 0) {
                            $link = substr($style,1);
                        } else {
                            $link = ResourcesModel::createModuleResourceLink($module, $style);
                        }
                        $headerStyles[$link] = $link;
                    }
                }
            }
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

        ?>
        <link rel="shortcut icon" href="<?php echo ResourcesModel::createTemplateResourceLink("favicon.ico"); ?>" type="image/x-icon" />
        <link type="text/css" href="resource/css/main.css" media="all" rel="stylesheet"/>
        <script type="text/javascript" src="resource/js/jquery/js/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="resource/js/jquery/js/jquery-ui-1.8.15.custom.min.js"></script>
        <script type="text/javascript" src="resource/js/main.js"></script>
        
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

        // render style links
        foreach ($headerStyles as $style) {
            echo '<link rel="stylesheet" type="text/css" href="'.$style.'" />'.PHP_EOL.'        ';
        }
        // render script links
        foreach ($headerScripts as $script) {
            echo '<script type="text/javascript" src="'.$script.'" ></script>'.PHP_EOL.'        ';
        }
    }
    
    function renderTrackerScript ($page) {
        if (!empty($page->pagetrackerscript) || !empty($page->sitetrackerscript) || !empty($page->domaintrackerscript)) {
            echo "<script>";
            // echo $page->pagetrackerscript.PHP_EOL;
            // echo $page->sitetrackerscript.PHP_EOL;
            // echo $page->domaintrackerscript.PHP_EOL;
            echo "</script>";
        }
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
                <?php
                echo '</script>'.PHP_EOL;
            }
            $this->renderTrackerScript(Context::getPage());
            echo '</body>'.PHP_EOL.'</html>'.PHP_EOL;
        }
    }

    function handelRenderRequest () {
        // get render request parameters
        $areas = explode(",",Context::get('reRender'));
        $animate = $_GET['animate'];
        $effect = $_GET['effect'];
        // set response type to xml
        header('Content-Type: text/xml; charset=utf-8');
        
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

}
?>