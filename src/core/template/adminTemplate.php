<?php

require_once 'core/plugin.php';

class AdminTemplate extends XTemplate {
    
    /**
     * 
     * @param type $html
     * @return type
     */
    function setData ($html) {
    }
    
    /**
     * returns the names of the areas defined by this template
     */
    function getAreas () {
        return array("center","adminMenu","popup");
    }

    /**
     * renders this template
     */
    function render () {
        
        
        $this->renderMainTemplateArea(Context::getPageId(), "center");
        
        $this->renderStaticModule("adminMenu");
    }
    
    static function renderAdminHeader () {
        ?>
        <div class="ui-widget-header adminHeaderDiv">
            <div class="adminHeaderModesDiv">
                <div class="ui-widget-header adminHeaderModeDiv"><h3>View</h3></div>
                <div class="ui-widget-header adminHeaderModeDiv"><h3>Edit</h3></div>
            </div>
            <div class="adminHeaderLogoDiv"></div>
        </div>
        <div class="adminContentDiv">
        <?php
    }
    
    static function renderAdminFooter () {
        ?>
        </div>
        <?php
    }
    
    /**
     * renders the main template area
     * @param type $pageId
     * @param type $teplateArea
     */
    function renderMainTemplateArea ($pageId, $teplateArea) {
        $this->renderTemplateArea($pageId, $teplateArea);    
    }
    
    /**
     * renders the focused module as a popup
     * @param type $teplateArea
     */
    function renderFocusedModule ($teplateArea) {
        $focusedModuleId = Context::getFocusedArea();
        if ($focusedModuleId != null) {
            echo "<div id='vcms_area_$teplateArea' >";
            Context::setIsFocusedArea(true);
            ModuleModel::renderModuleObject(Context::getModule($focusedModuleId));
            Context::setIsFocusedArea(false);
            echo "</div>";
        }
    }

    /**
     * returns script used by this template
     */
    function getScripts () {
        return array("/core/template/js/admin.js");
    }
    
    static function getAdminStyle () {
        return "core/template/css/admin.css";
    }
    
    /**
     * returns styles used by this template
     */
    function getStyles () {
        return array("/".self::getAdminStyles());
    }
    
    /**
     * returns the codes of the static modules
     */
    function getStaticModules () {
        return array("adminMenu");
    }
}

?>