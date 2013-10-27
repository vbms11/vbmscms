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
                    <a href="<?php echo NavigationModel::createPageLink($adminPageId,array("setAdminMode"=>"0")); ?>">View</a>
                </div>
                <div class="ui-widget-header <?php echo Context::isAdminMode() ? "ui-state-hover" : ""; ?> adminHeaderModeDiv">
                    <a href="<?php echo NavigationModel::createStaticPageLink("adminPages", array("action"=>"editPage","setAdminMode"=>"adminPages","adminPageId"=>$adminPageId)); ?>">Edit</a>
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
        $focusedModuleId = Context::getFocusedArea();
        if (empty($focusedModuleId)) {
            
            echo "<div class='vcms_area' id='vcms_area_$teplateArea' >";

            $areaModules = Context::getModules($teplateArea);
            if (count($areaModules) > 0) {
                foreach ($areaModules as $areaModule) {
                    if ($areaModule->sysname == Context::isAdminMode()) {
                        ModuleModel::renderModuleObject($areaModule, false);
                    }
                }
            }

            echo "</div>";
            
        } else {
            ?>
            <div id="adminEditModuleTabs">
                <ul>
                    <li><a href="#tabs-1">Edit Module</a></li>
                    <li><a href="#tabs-2">Attributes</a></li>
                </ul>
                <div id="tabs-1">
                    <?php 
                    echo "<div id='vcms_area_$teplateArea' >";
                    Context::setIsFocusedArea(true);
                    ModuleModel::renderModuleObject(Context::getModule($focusedModuleId));
                    Context::setIsFocusedArea(false);
                    echo "</div>";
                    ?>
                </div>
                <div id="tabs-2">
                    <?php  ?>
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
     * @param type $teplateArea
     * @param type $pageId
     */
    function renderTemplateArea ($teplateArea, $pageId = null) {
        
        if (empty($pageId)) {
            $pageId  = Context::getPageId();
        }
        
        echo "<div class='vcms_area' id='vcms_area_$teplateArea' >";

        $areaModules = Context::getModules($teplateArea);
        if (count($areaModules) > 0) {
            foreach ($areaModules as $areaModule) {
                ModuleModel::renderModuleObject($areaModule, false);
            }
        }
        
        echo "</div>";
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
        if (Context::isAdminMode() == "adminPages" && Context::getFocusedArea() == null) {
            $staticModules[] = array(
                "name" => "center",
                "type" => "adminPages"
            );
        }
        return $staticModules;
    }
}

?>