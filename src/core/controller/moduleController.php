<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of moduleController
 *
 * @author vbms
 */
class ModuleController {
    
    /**
     * renders a module by db object
     * @param type $moduleObj database module object
     */
    static function renderModule ($moduleObj) {
        
        self::renderModuleObject(ModuleModel::getModuleClass($moduleObj));
    }
    
    /**
     * renders a module object
     * @param type $moduleObject
     * @param type $contextMenu
     */
    static function renderModuleObject ($moduleObject, $contextMenu = true, $multiModuleContextMenu = true) {
        
        ?>
        <div class="vcms_module" id="vcms_module_<?php echo $moduleObject->getId(); ?>">
            <?php
            $moduleObject->view($moduleObject->getId());
            ?>
        </div>
        <?php
        if ($contextMenu && (!Context::isAjaxRequest() && !Context::isRenderRequest())) {
            if (Context::hasRole("pages.edit") && Context::getFocusedArea() != $moduleObject->getId()) {
                self::renderContextMenu($moduleObject, $multiModuleContextMenu);
            }
        }
    }
        
    /**
     * renders a modules context menu
     * @param type $moduleClass
     */
    static function renderContextMenu ($moduleClass, $multiModuleContextMenu = true) {

        ?>
        <script>
        var moduleMenuDiv = $('#vcms_module_<?php echo $moduleClass->getId(); ?>');
        moduleMenuDiv.contextMenu([
            {'Edit Module':function (menuItem,menu) {   callUrl('<?php echo NavigationModel::createModuleLink($moduleClass->getId(),array("action"=>"edit"),false); ?>'); }},
            <?php
            if ($multiModuleContextMenu) {
                ?>
                {'Insert Module':function (menuItem,menu) { callUrl('<?php echo NavigationModel::createStaticPageLink("insertModule",array("action"=>"insertModule","selectedPage"=>Context::getPageId(),"area"=>$moduleClass->getAreaName(),"position"=>$moduleClass->getPosition()),false); ?>'); }},
                <?php
            }
            ?>
            {'Configure Page':function (menuItem,menu) {   callUrl('<?php echo NavigationModel::createStaticPageLink("pageConfig",array("action"=>"edit","id"=>Context::getPageId()),false); ?>'); }},
            $.contextMenu.separator,
            <?php
            if ($multiModuleContextMenu) {
                ?>
                {'Move Up':function (menuItem,menu) {       callUrl('<?php echo NavigationModel::createPageLink(Context::getPageId(),array("action"=>"moveup","id"=>$moduleClass->getIncludeId()),false); ?>'); }},
                {'Move Down':function (menuItem,menu) {     callUrl('<?php echo NavigationModel::createPageLink(Context::getPageId(),array("action"=>"movedown","id"=>$moduleClass->getIncludeId()),false); ?>'); }},
                {'Move':function (menuItem,menu) {
                    initSortableAreas(<?php echo $moduleClass->getId(); ?>,'<?php echo NavigationModel::createPageLink(Context::getPageId(),array("action"=>"movemodule"),false); ?>');
                }},
                <?php
                if ($moduleClass->getId() != Context::getPage()->codeid) {
                    ?>
                    $.contextMenu.separator,
                    {'Delete Module':function (menuItem,menu) { doIfConfirm('<?php echo TranslationsModel::getTranslation("admin.pages.modules.delete.confirm"); ?>','<?php echo NavigationModel::createPageLink(Context::getPageId(),array("action"=>"delete","id"=>$moduleClass->getId()),false); ?>'); }}
                    <?php
                }
            }
            ?>
            ],{theme:'vista'});
        moduleMenuDiv.mouseover(function(){
            $(this).addClass("vcms_module_show_border");
        });
        moduleMenuDiv.mouseout(function(){
            $(this).removeClass("vcms_module_show_border");
        });
        </script>
        <?php
    }
    
    /*
     * processes module class as service
     */
    static function processService ($serviceName, $params = array()) {
        
        $serviceClass = ModuleModel::getModuleClass(ModuleModel::getModuleBySysname($serviceName));
        Context::setIsFocusedArea(true);
        $serviceClass->process($serviceName);
        Context::setIsFocusedArea(false);
    }
    
    /*
     * render module class as service
     */
    static function renderService ($serviceName, $params = array()) {
        
        $serviceClass = ModuleModel::getServiceClass($serviceName);
        Context::setIsFocusedArea(true);
        $serviceClass->setParams($params);
        $serviceClass->view($serviceName);
        Context::setIsFocusedArea(false);
    }
    
    /**
     * calls the destroy method on the module interface
     */
    static function destroyModule ($moduleObj) {

        $moduleClass = ModuleModel::getModuleClass($moduleObj);
        $moduleClass->destroy($moduleObj->id);
    }
    
    /**
     * performs page module management actions
     */
    static function processAction () {

        if (Context::hasRole("pages.edit") && isset($_GET['action'])) {

            $id = isset($_GET['id']) ? $_GET['id'] : null;

            switch ($_GET['action']) {
                case "new":
                    NavigationModel::redirectStaticModule("pages", array("action"=>"insertModule","module"=>$id));
                    break;
                case "delete":
                    TemplateModel::deleteAreaModule($id);
                    break;
                case "moveup":
                    TemplateModel::moveTemplateModuleUp(Context::getPageId(),$id);
                    break;
                case "movedown":
                    TemplateModel::moveTemplateModuleDown(Context::getPageId(),$id);
                    break;
                case "movemodule":
                    TemplateModel::moveTemplateModule(Context::getPageId(),$id,$_GET["area"],$_GET["pos"]);
                    Context::setReturnValue("");
                    break;
                case "logdata":
                    LogDataModel::logThis($_GET['data']);
                default:
            }
        }
    }
    
    /**
     * perform module actions or page management actions
     */
    static function processActions () {
        
        // decide if to unfocus the main content area
        $moduleId = Context::getModuleId();
        if (Context::getFocusedArea() != $moduleId || empty($moduleId)) {
            Context::setFocusedArea(null);
        }

        // process system or module actions
        if (empty($moduleId)) {
            self::processAction();
        } else {
            $moduleClass = ModuleModel::getModuleClass(TemplateModel::getTemplateModule($moduleId));
            $moduleClass->setParams(ModuleModel::getModulesParams($moduleId));
            self::processModuleObject($moduleClass);
        }
    }    
    
    /**
     * process a module by id
     * @param type $moduleId
     */
    static function processModule ($moduleId) {
        
        $module = self::getModule($moduleId);
        if (!empty($module)) {
            self::processModuleObject($module);
        } else {
            //log("invalid moduleId: $moduleId");
        }
    }
    
    /**
     * process a module by module object
     * @param type $moduleObject
     */
    static function processModuleObject ($moduleObject) {
        
        if (!empty($moduleObject)) {
            Context::setIsFocusedArea(true);
            $moduleObject->process($moduleObject->getId());
            Context::setIsFocusedArea(false);
        } else {
            //log("invalid moduleId: $moduleId");
        }
    }
}

?>
