<?php

require_once 'core/template/adminTemplate.php';

class TemplateRenderer extends BaseRenderer {
	
    function getTemplate () {
    	return null;
    }
    
    /**
     * called when an area of the template is to be rendered
     * @param <type> $pageId
     * @param <type> $teplateArea
     */
    function renderTemplateArea ($teplateArea, $pageId = null) {
        
        if (empty($pageId)) {
            $pageId  = Context::getPageId();
        }
        
        echo "<div class='vcms_area' id='vcms_area_$teplateArea' >";

        $areaModules = $this->getModules($teplateArea);
        if (count($areaModules) > 0) {
            foreach ($areaModules as $areaModule) {
                ModuleController::renderModuleObject($areaModule);
            }
        } else {
            if (Context::hasRole("pages.edit")) {
                ?>
                <div class="toolButtonDiv show">
                    <a class="toolButtonSpacinng" href="<?php echo NavigationModel::createStaticPageLink("insertModule",array("action"=>"insertModule","selectedPage"=>$pageId,"area"=>$teplateArea,"position"=>-1)); ?>">
                        <img src="resource/img/new.png" class="imageLink" alt="" title="<?php echo parent::getTranslation("admin.pages.module.new"); ?>" />
                    </a>
                </div>
                <?php
            }
        }
        
        if (Context::hasRole("pages.edit")) {
            ?>
            <script>
            var areaMenuDiv = $('#vcms_area_<?php echo $teplateArea; ?>');
            areaMenuDiv.contextMenu([
                    {'Insert Module':function (menuItem,menu) { callUrl('<?php echo NavigationModel::createStaticPageLink("insertModule",array("action"=>"insertModule","selectedPage"=>$pageId,"area"=>$teplateArea,"position"=>-1),false); ?>'); }},
                    {'Configure Page':function (menuItem,menu) {   callUrl('<?php echo NavigationModel::createStaticPageLink("pageConfig",array("action"=>"edit","id"=>$pageId),false); ?>'); }}],
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
    function renderMainTemplateArea ($teplateArea, $pageId = null) {
        
        $focusedModuleId = Context::getFocusedArea();
        if (!empty($focusedModuleId)) {
            echo "<div id='vcms_area_$teplateArea' >";
            Context::setIsFocusedArea(true);
            ModuleController::renderModuleObject($this->getModule($focusedModuleId));
            Context::setIsFocusedArea(false);
            echo "</div>";
        } else {
            $this->renderTemplateArea($teplateArea, $pageId);
        }    
    }
    
    /**
     * renders a menu in for the given area name
     * 
     * @param <type> $pageId
     * @param <type> $menuName
     */
    function renderMenu ($menuName) {

        // render the menu
        echo "<div id='vcms_area_$menuName' >";
        ModuleController::renderModuleObject(current($this->getModules($menuName)),true,false);
        echo "</div>";
    }

    /**
     * renders a static module area by sysname and area name
     *
     * @param <type> $pageId
     * @param <type> $moduleName
     * @param <type> $areaName
     */
    function renderStaticModule ($moduleSysName, $areaName = null, $pageId = null, $contextMenu = false) {
        $this->renderModule($moduleSysName,$areaName,true,$pageId,true,$contextMenu);
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
    function renderModule ($moduleType, $areaName = null, $static = false, $pageId = null, $targetOnly = false, $contextMenu = false) {
        if (empty($pageId)) {
            $pageId = Context::getPageId();
        }
        if (empty($areaName)) {
            $areaName = $moduleType;
        }
        // find target module
        $modules = $this->getModules($areaName);
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
                $targetModule = TemplateModel::getStaticModule($moduleType, $moduleType);
            } else {
                $module = ModuleModel::getModuleByName($moduleType);
                $newModuleId = TemplateModel::insertTemplateModule($pageId, $areaName, $module->id);
                $targetModule = ModuleModel::getTemplateModule($newModuleId);
            }
            $this->addModule($targetModule);
            $modules = $this->getModules($areaName);
        }
        // render area with module in it
        echo "<div id='vcms_area_$areaName' >";
        if ($targetOnly) {
            ModuleController::renderModuleObject($targetModule, $contextMenu);
        } else {
            foreach ($modules as $areaModules) {
                foreach ($areaModules as $areaModule) {
                    if ($areaModule->moduleAreaName == $areaName) {
                        ModuleController::renderModuleObject($module);
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
        $site = Context::getSite();
        
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

        // get template resources
        $template = $this->getTemplate();
        if ($template == null) {
        	$template = TemplateModel::getTemplateObj($page);
        }
        
        $styles = $template->getStyles();
        if (!empty($styles)) {
            $templateStylePaths = $template->getResourcePaths($styles);
            foreach ($templateStylePaths as $templateStylePath) {
                Context::addRequiredStyle($templateStylePath);
            }
        }
        $scripts = $template->getScripts();
        if (!empty($scripts)) {
            $templateScriptPaths = $template->getResourcePaths($scripts);
            foreach ($templateScriptPaths as $templateScriptPath) {
                Context::addRequiredScript($templateScriptPath);
            }
        }

        ?>
        <link rel="shortcut icon" href="<?php echo ResourcesModel::createTemplateResourceLink("favicon.ico"); ?>" type="image/x-icon" />
        <link type="text/css" href="resource/js/jquery/css/base/jquery.ui.all.css" media="all" rel="stylesheet"/>
        <script type="text/javascript" src="resource/js/jquery/js/jquery-1.9.1.js"></script>
        <script type="text/javascript" src="resource/js/cookie/jquery.cookie.js"></script>
        <script type="text/javascript" src="resource/js/jquery/js/jquery-ui-1.10.3.custom.min.js"></script>
        <link type="text/css" href="resource/css/main.css" media="all" rel="stylesheet"/>
        <script type="text/javascript" src="resource/js/main.js"></script>
        <?php

        // render style links
        foreach (Context::getRequiredStyles() as $style) {
            echo '<link rel="stylesheet" type="text/css" href="'.$style.'" />'.PHP_EOL.'        ';
        }
        // render script links
        foreach (Context::getRequiredScripts() as $script) {
            echo '<script type="text/javascript" src="'.$script.'" ></script>'.PHP_EOL.'        ';
        }
        
?>
<!-- Piwik -->
<script type="text/javascript"> 
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="<?php echo NavigationModel::getSitePath(); ?>/modules/statistics/piwik/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', <?php echo $site->piwikid; ?>]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0]; g.type='text/javascript';
    g.defer=true; g.async=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- End Piwik Code -->
<!-- facebook -->
<script id="facebook-jssdk" type="text/javascript" src="//connect.facebook.net/en_US/all.js#xfbml=1&amp;appId=<?php echo Context::getSite()->facebookappid; ?>"></script>
<?php /*
<script type="text/javascript">(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=<?php echo Context::getSite()->facebookappid; ?>";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
*/ ?>
<!-- end facebook -->
<?php
        if (!empty($page->pagetrackerscript)) {
            echo $page->pagetrackerscript;
        }
        if (!empty($site->sitetrackerscript)) {
            echo $site->sitetrackerscript;
        }
        if (!empty($site->domaintrackerscript)) {
            echo $site->domaintrackerscript;
        }
    }
    
    function renderHeader () {
        
        //if (Context::hasRoleGroup("admin")) {
        //    AdminTemplate::renderAdminHeader();
        //    Context::addRequiredStyle(AdminTemplate::getAdminStyle());
        //}
    }
    
    function renderFooter () {
        
        //if (Context::hasRoleGroup("admin")) {
        //    AdminTemplate::renderAdminFooter();
        //}
        
        if (Context::hasRole("pages.edit")) {
            Context::addRequiredScript("resource/js/contextmenu/jquery.contextmenu.js");
            Context::addRequiredStyle("resource/js/contextmenu/jquery.contextmenu.css");
            ?>
            <script>
            $("body").contextMenu([
                {'Configure Page':function (menuItem,menu) {   callUrl('<?php echo NavigationModel::createStaticPageLink("pageConfig",array("action"=>"edit","id"=>Context::getPageId()),false); ?>'); }}],
                {theme:'vista'});
            </script>
            <?php
        }
        
    }
    
    function renderNotifications () {
        
        $alertNotifications = Context::getAlertNotifications();
        if (!empty($alertNotifications)) {
            ?>
            <div class="notificationsBox">
                <?php
                foreach ($alertNotifications as $alertNotification) {
                    $typeClass = null;
                    $notificationId = null;
                    $notificationMessage = null;
                    if (isset($alertNotification->message)) {
                        $notificationMessage = $alertNotification->message;
                        if ($alertNotification->type == "confirmOnce") {
                            $typeClass = $alertNotification->type;
                            $notificationId = $alertNotification->id;
                        }
                    } else {
                        $notificationMessage = $alertNotification;
                    }
                    
                    ?>
                    <div class="notification alertNotification <?php if (!empty($typeClass)) { echo $typeClass; } ?>" <?php if (!empty($notificationId)) { echo 'id="'.$notificationId.'"'; } ?>>
                        <?php echo $notificationMessage; ?>
                        <button><?php echo TranslationsModel::getTranslation("common.ok"); ?></button>
                    </div>
                    <?php
                }
                ?>
                <script type="text/javascript">
                $(".alertNotification").each(function(index,object){
                    $(object).click(function(){
                        if ($(this).hasClass("confirmOnce")) {
                            $.cookie($(this).attr("id"), "1", {
                                path : "/"
                            });
                        }
                        $(this).remove();
                    });
                });
                </script>
            </div>
            <?php
        }
    }
    
    function invokeRender () {

        ob_start();
        $this->renderHeader();
        $this->render();
        $this->renderFooter();
        $bodyHtml = ob_get_clean();
        
        echo '<?xml version="1.0" encoding="ISO-8859-1" ?>'.PHP_EOL;
        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">'.PHP_EOL;
        echo '<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#">'.PHP_EOL.'<head>'.PHP_EOL;
        $this->renderHtmlHeader();
        echo '</head>'.PHP_EOL.'<body>'.PHP_EOL;
        echo '<div id="fb-root"></div>'.PHP_EOL;
        
        $errors = Context::getErrors();
        if (empty($errors)) {
            echo $bodyHtml;
            $this->renderNotifications();
        } else {
            foreach ($errors as $error) {
                echo $error."<br/>";
            }
        }
        
	echo '<noscript><p><img src="modules/statistics/piwik/piwik.php?idsite=';
	echo Context::getSite()->piwikid;
	echo '" style="border:0" alt="" /></p></noscript>';
        echo '</body>'.PHP_EOL.'</html>'.PHP_EOL;
        
    }

}
?>
