<?php

class VcmsRenderer extends BaseRenderer {
    
    function invokeRender () {
        
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
            $this->renderTemplateArea($area, Context::getPageId());
            echo "]]></area>".PHP_EOL;
        }
        echo "</vcms>".PHP_EOL;
        
    }

}
?>