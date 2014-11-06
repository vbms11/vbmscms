<?php

class AjaxRenderer extends BaseRenderer {
    
    function invokeRender () {
        
        // ajax request
        $module = TemplateModel::getTemplateModule(Context::getModuleId());
        ModuleModel::renderModule($module);
        
    }

}
?>