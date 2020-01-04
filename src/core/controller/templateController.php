<?php

class TemplateController {
    
    static function deleteTemplatePack ($packId) {
        $templates = TemplateModel::getTemplatesByPack($packId);
        foreach ($templates as $template) {
            $templateFolder = Resource::getResourcePath("template/".$template->path);
            unlink($templateFolder);
            TemplateModel::deleteTemplate($template->id);
        }
        TemplateModel::deleteTemplatePack($packId);
    }
    
    static function switchTemplatePack ($packId,$siteId) {
        SiteModel::setTemplatepackidById($siteId, $packId);
        $templates = TemplateModel::getTemplatesByPack($packId);
        foreach ($templates as $template) {
            PagesModel::setTemplateByType($siteId,$template->id,$template->type);
        }
        
    }
    
    static function copyTemplatePack ($name, $description, $packId) {
        $templatePackId = TemplateModel::createTemplatePack($name, $description);
        $templates = TemplateModel::getTemplatesByPack($packId);
        foreach ($templates as $template) {
            $templatePath = Resource::getResourcePath("template/".$template->path);
            $id = TemplateModel::createTemplate($template->name, $template->html, $template->js, $template->css, $template->type, $templatePackId);
            $newTemplate = TemplateModel::getTemplate($id);
            $newTemplatePath = Resource::getResourcePath("template/".$newTemplate->path);
            $files = scandir($templatePath);
            foreach ($files as $file) {
                if ($file != "." || $file != "..") {
                    $fileFullPath = $templatePath."/".$file;
                    if (is_file($fileFullPath)) {
                        copy($fileFullPath, $newTemplatePath."/".$file);
                    } else if (is_dir($fileFullPath) && !is_dir($newTemplatePath."/".$file)) {
                        mkdir($newTemplatePath."/".$file);
                    }
                }
            }
        }
    }
    
    static function createTemplate () {
        
    }
    
    function export ($templateId, $uniqueName) {
        
    }
    
    function import ($zipFilename, $siteId) {
        
    }
}

