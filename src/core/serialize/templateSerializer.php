<?php

class TemplateSerializer extends Serializer {
    
    private const filename = "resource/template/templates.xml";
    
    function exportModules () {
        
        parent::clear();
        parent::addTable("t_template_pack", TemplateModel::getTemplatePacks());
        parent::addTable("t_template", TemplateModel::getTemplates());
        
        /*
        $templatePath = "template/".Common::hash($id,false,false);
            file_put_contents(ResourcesModel::getResourcePath($templatePath, "template.js"), $js);
            file_put_contents(ResourcesModel::getResourcePath($templatePath, "template.css"), $css);
         */
        foreach ($templates as $template) {
            $files = FileSystem::getFilePaths(Resource::getResourcePath($templatePath."/".$template->path));
            foreach ($files as $file) {
                parent::addFile($file);
            }
        }
        
        file_put_contents(self::filename, parent::createXml());
    }
    
    function importModules () {
        
        parent::loadXml(self::filename);
        
        foreach (parent::getTable("t_module") as $row) {
            ModuleModel::createModule($row->name, $row->description, $row->include, $row->interface, $row->inmenu, $row->sysname, $row->category, $row->position, $row->static);
        }
    }
    
}