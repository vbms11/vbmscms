<?php

class TemplateController {
    
    function selectTemplatePack ($templatePackId) {
        PagesModel::getPageTemplate();
        $oldTemplatePack = TemplateModel::getTemplatePack($id);
        PagesModel::getPages();
        foreach ($pages as $i => $page) {
            
        }
                // get templates used from current pack
    }
    
    static function deleteTemplatePack ($packId) {
        $templates = TemplateModel::getTemplatesByPack($packId);
        foreach ($templates as $pos => $template) {
            TemplateModel::deleteTemplate($template->id);
        }
        TemplateModel::deleteTemplatePack($packId);
    }
    
    static function switchTemplatePack ($packId,$siteId) {
        
        $templates = TemplateModel::getTemplatesByPack($packId);
        foreach ($templates as $k => $template) {
            PagesModel::setTemplateByType($siteId,$template->id,$template->type);
        }
        
    }
    
    static function copyTemplatePack ($name, $description, $packId) {
        $templatePackId = TemplateModel::createTemplatePack($name, $description);
        $templates = TemplateModel::getTemplatesByPack($packId);
        foreach ($templates as $k => $template) {
            TemplateModel::createTemplate($template->name, $template->html, $template->js, $template->css, $template->type, $templatePackId);
        }
    }
    
    static function createTemplate () {
        
    }
    
    function export ($templateId, $uniqueName) {
        
    }
    
    function import ($zipFilename, $siteId) {
        
    }
}

