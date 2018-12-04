<?php

require_once 'core/plugin.php';

class AdminTemplate extends XTemplate {
    
    /**
     * returns the names of the areas defined by this template
     */
    function getAreas () {
        return array("center");
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
    }
    
    /**
     * 
     */
    static function renderAdminHeader () {
    	/*
        if (Context::isAdminMode()) {
            $adminPageId = isset($_GET['adminPageId']) ? $_GET['adminPageId'] : null;
            if (empty($adminPageId)) {
                $adminPageId = isset($_SESSION['adminPageId']) ? $_SESSION['adminPageId'] : null;
            }
        } else {
            $adminPageId = Context::getPageId();
        }
        
        ?>
        <div class="ui-widget-header adminHeaderDiv">
            <div class="adminHeaderModesDiv">
                <div class="ui-widget-header <?php echo !Context::isAdminMode() ? "ui-state-hover" : ""; ?> adminHeaderModeDiv">
                    <a href="<?php echo NavigationModel::createPageLink($adminPageId,array("setAdminMode"=>"0")); ?>">
                        <?php echo parent::getTranslation("admin.template.header.view"); ?>
                    </a>
                </div>
                <div class="ui-widget-header <?php echo Context::isAdminMode() ? "ui-state-hover" : ""; ?> adminHeaderModeDiv">
                    <a href="<?php echo NavigationModel::createStaticPageLink("adminPages", array("action"=>"editPage","setAdminMode"=>"adminPages","adminPageId"=>$adminPageId)); ?>">
                        <?php echo parent::getTranslation("admin.template.header.edit"); ?>
                    </a>
                </div>
            </div>
            <div class="adminHeaderLogoDiv"></div>
        </div>
        <div class="adminContentDiv">
        <?php
        */
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
     * @param Integer $pageId
     * @param String $teplateArea
     */
    function renderMainTemplateArea ($teplateArea, $pageId=null) {
        $focusedModuleId = Context::getFocusedArea();
        if (!empty($focusedModuleId)) {
            $module = $this->getModule($focusedModuleId);
        } else {
            $module = null;
        }
        if (empty($focusedModuleId) || (!empty($module) && $module->sysname == Context::isAdminMode())) {
            
            echo "<div class='vcms_area' id='vcms_area_$teplateArea' >";

            $areaModules = $this->getModules($teplateArea);
            if (count($areaModules) > 0) {
                foreach ($areaModules as $areaModule) {
                    if ($areaModule->sysname == Context::isAdminMode()) {
                        if (!empty($focusedModuleId)) {
                            Context::setIsFocusedArea(true);
                        }
                        ModuleController::renderModuleObject($areaModule, false);
                        if (!empty($focusedModuleId)) {
                            Context::setIsFocusedArea(false);
                        }
                    }
                }
            }

            echo "</div>";
            
        } else {
            ?>
            <div id="adminEditModuleTabs">
                <ul>
                    <li><a href="#tabs-1"><?php echo parent::getTranslation("admin.template.module.edit"); ?></a></li>
                </ul>
                <div id="tabs-1">
                    <?php 
                    echo "<div id='vcms_area_$teplateArea' >";
                    Context::setIsFocusedArea(true);
                    ModuleController::renderModuleObject($this->getModule($focusedModuleId));
                    Context::setIsFocusedArea(false);
                    echo "</div>";
                    ?>
                </div>
            </div>
            <script>
            $("#adminEditModuleTabs").tabs();
            </script>
            <?php
        }
    }
    
    /**
     * 
     * @param String $teplateArea
     * @param Integer $pageId
     */
    function renderTemplateArea ($teplateArea, $pageId = null) {
        
        if (empty($pageId)) {
            $pageId  = Context::getPageId();
        }
        
        echo "<div class='vcms_area' id='vcms_area_$teplateArea' >";

        $areaModules = $this->getModules($teplateArea);
        if (count($areaModules) > 0) {
            foreach ($areaModules as $areaModule) {
                ModuleController::renderModuleObject($areaModule, false);
            }
        }
        
        echo "</div>";
    }
    
    function renderFooter () {
        
        AdminTemplate::renderAdminFooter();
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
        return array("/".self::getAdminStyle());
    }
    
    /**
     * returns the codes of the static modules
     */
    function getStaticModules () {
        $staticModules = array(array(
            "name"=>"adminMenu",
            "type"=>"adminMenu"
        ));
        if (Context::isAdminMode() && Context::getFocusedArea() == null) {
            $staticModules[] = array(
                "name" => "center",
                "type" => Context::isAdminMode()
            );
        }
        return $staticModules;
    }
}

?>