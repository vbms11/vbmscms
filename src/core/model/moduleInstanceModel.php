<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ModuleInstanceModel
 *
 * @author Administrator
 */
class ModuleInstanceModel {
    
    static function deleteModuleInstance ($instanceId) {
        
        $instanceId = mysql_real_escape_string($instanceId);
        
        Database::query("delete from t_module_instance_params where instanceid = '$instanceId'");
        Database::query("delete from t_module_instance where id = '$instanceId'");
    }
    
    static function createModuleInstance ($moduleId) {
        
        $moduleId = mysql_real_escape_string($moduleId);
        
        Database::query("insert into t_module_instance(moduleid) values('$moduleId')");
        $lastIdObj = Database::queryAsObject("select last_insert_id() as id from t_module_instance");
        
        return $lastIdObj->id;
    }
    
        
}

?>
