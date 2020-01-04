<?php

class ModuleSerializer extends Serializer {
    
    private const filename = "core/install/defaultModules.xml";
    
    function exportModules () {
        
        parent::clear();
        parent::addTable("t_module", ModuleModel::getModules());
        
        file_put_contents(self::filename, parent::createXml());
    }
    
    function importModules () {
        
        parent::loadXml(self::filename);
        
        foreach (parent::getTable("t_module") as $row) {
            ModuleModel::createModule($row->name, $row->description, $row->include, $row->interface, $row->inmenu, $row->sysname, $row->category, $row->position, $row->static);
        }
    }
    
}