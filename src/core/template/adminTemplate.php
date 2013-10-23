<?php

require_once 'core/plugin.php';

class AdminTemplate extends XTemplate {
    
    /**
     * returns the names of the areas defined by this template
     */
    function getAreas () {
        return array("center","adminMenu","dialog");
    }

    /**
     * renders this template
     */
    function render () {
        ?>
        <div class="adminMenuDiv">
            <?php $this->renderStaticModule("adminMenu"); ?>
        </div>
        <div class="adminContentSplitter"></div>
        <div class="adminBodyDiv">
            <?php $this->renderMainTemplateArea("center"); ?>
        </div>
        <script>
        $(function() {
            $('.adminContentSplitter').draggable({    
                axis: 'x',
                containment: '.adminContentDiv',
                drag: function(event, ui) {
                    $('.adminMenuDiv').css({ "width" : ui.position.left + 'px' });
                    $('.adminBodyDiv').css({ 
                        "left" : ui.position.left + 3 + 'px'
                    });
                },
                refreshPositions: true,
                scroll: false
            });
        });
        </script>
        <?php
        $this->renderFocusedModule("dialog");
    }
    
    /**
     * 
     */
    static function renderAdminHeader () {
        ?>
        <div class="ui-widget-header adminHeaderDiv">
            <div class="adminHeaderModesDiv">
                <div class="ui-widget-header adminHeaderModeDiv"><a>View</a></div>
                <div class="ui-widget-header adminHeaderModeDiv">
                    <a href="<?php NavigationModel::createStaticPageLink("adminPages", array("action"=>"editPage","id"=>  Context::getPageId())); ?>">Edit</a>
                </div>
            </div>
            <div class="adminHeaderLogoDiv"></div>
        </div>
        <div class="adminContentDiv">
        <?php
    }
    
    /**
     * 
     */
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
    function renderMainTemplateArea ($teplateArea) {
        $this->renderTemplateArea($teplateArea);    
    }
    
    /**
     * renders the focused module as a dialog
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
    
    /**
     * @return string
     */
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