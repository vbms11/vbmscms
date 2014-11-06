<?php

require_once 'core/plugin.php';

class EditableTemplatePreview extends EditableTemplate {
    
    function renderHeader () {
        
    }
    
    function renderFooter () {
        
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
        
        echo "</div>";
    }
    
    function renderModule ($moduleType, $areaName = null, $static = false, $pageId = null, $targetOnly = false, $contextMenu = false) {
        parent::renderModule ($moduleType,$areaName,$static,$pageId,$targetOnly,false);
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
        ModuleController::renderModuleObject(current($this->getModules($menuName)), false);
        echo "</div>";
    }
}

?>