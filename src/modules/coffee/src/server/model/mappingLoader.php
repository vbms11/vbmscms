<?php

class MappingLoader {
    
    static $defaultMappingFile = "mapping.xml";
    
    function load () {
                
        $obj = simplexml_load_string();
        foreach ($obj->table as $table) {
            MappingLoader::loadTable($table);
        }
    }
    
    function loadTable ($table) {
        
        // dose table exist
        
        
        // create table
        $table->name;
        foreach ($table->column as $column) {
            $this->loadColumn($table, $column);
        }
    }
    
    function loadColumn ($table, $column) {
        
        $ddl = "";
        switch ($column->type) {
            
            case ModelObject::type_varchar:
                break;
            case ModelObject::type_text:
                break;
            case ModelObject::type_int:
                break;
            case ModelObject::type_float:
                break;
            case ModelObject::type_double:
                break;
            case ModelObject::type_date:
                break;
            case ModelObject::type_timestamp:
                break;
        }
    }
}

?>