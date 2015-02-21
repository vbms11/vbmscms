<?php

class AjaxRenderer extends BaseRenderer {
    
    function invokeRender () {
        
        // ajax request
        $moduleId = Context::getModuleId();
        $moduleClass = ModuleModel::getModuleClass(TemplateModel::getTemplateModule($moduleId));
        $moduleClass->setParams(ModuleModel::getModulesParams($moduleId));
        $moduleClass->view($moduleClass->getId());
    }

}
?>