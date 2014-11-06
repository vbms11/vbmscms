<?php

require_once 'core/model/moduleModel.php';

class ModuleModel {
    
    static function getModule ($id) {
        $aid = mysql_real_escape_string($id);
        return Database::queryAsObject("select * from t_module where id = '$aid'");
    }

    static function getModules () {
        return Database::queryAsArray("select * from t_module");
    }
    
    static function getModuleBySysname ($sysname) {
        $sysname = mysql_real_escape_string($sysname);
        return Database::queryAsObject("select * from t_module where sysname = '$sysname' and static = '1'");
    }
    
    static function getModuleByName ($moduleName) {
        $moduleName = mysql_real_escape_string($moduleName);
        return Database::queryAsObject("select * from t_module where sysname = '$moduleName'");
    }
    
    static function getModuleCategorys () {
        return Database::queryAsArray("select * from t_module_category");
    }
    
    static function getModulesInMenu () {
        return Database::queryAsArray("select * from t_module where inmenu = '1'");
    }
    
    static function getAvailableModules () {
        return array();
    }

    static function createModule ($name,$description,$include,$interface,$inmenu) {
        $name = mysql_real_escape_string($name);
        $description = mysql_real_escape_string($description);
        $include = mysql_real_escape_string($include);
        $interface = mysql_real_escape_string($interface);
        $inmenu = mysql_real_escape_string($inmenu);
        Database::query("insert into t_module(name,description,include,interface,inmenu) values ('$name','$description','$include','$interface','$inmenu')");
        $newObj = Database::query("select last_insert_id() as lastid from t_module");
        return $newObj->lastid;
    }
    
    static function addModule ($siteId,$moduleId) {
        $siteId = mysql_real_escape_string($siteId);
        $moduleId = mysql_real_escape_string($moduleId);
        $obj = Database::queryAsObject("select 1 from t_site_module where siteid = '$siteId' and moduleid = '$moduleId'");
        if ($obj == null) {
            Database::query("insert into t_site_module (siteid,moduleid) values('$siteId','$moduleId')");
        }
    }
    
    static function removeModule ($siteId,$moduleId) {
        $siteId = mysql_real_escape_string($siteId);
        $moduleId = mysql_real_escape_string($moduleId);
        Database::query("delete from t_site_module where siteid = '$siteId' and templateid = '$moduleId'");
    }
    
    /**
     * get a module object by module db object
     * @param type $moduleObj
     * @param type $params
     * @return type
     */
    static function getModuleClass ($moduleObj, $params = true) {
        // get the module instance
print_r($moduleObj);
        require_once($moduleObj->include);
        $className = $moduleObj->interface;
        $obj = eval("return new $className();");
        $obj->moduleId = $moduleObj->id;
        $obj->moduleAreaName = $moduleObj->name;
        $obj->modulePosition = $moduleObj->position;
        $obj->sysname = $moduleObj->sysname;
        $obj->include = $moduleObj->include;
        if (isset($moduleObj->includeid)) {
            $obj->includeId = $moduleObj->includeid;
        }
        // set module parameters
        if ($params) {
            $obj->setParams(self::getModulesParams($moduleObj->id));
        }
        return $obj;
    }
    
    /*
     * gets service module instance by service name
     */
    static function getServiceClass ($serviceName) {
        return self::getModuleClass(self::getModuleBySysname($serviceName));
    }
    
    /**
     * 
     * @param type $moduleIds int or array
     * @return type
     */
    static function getModulesParams ($moduleIds) {
        
        $moduleParams = array();
        if (is_array($moduleIds)) {
            foreach ($moduleIds as $key => $value) {
                $moduleIds[$key] = mysql_real_escape_string($value);
            }
            $moduleIdsStr = " in ('".implode("','",$moduleIds)."') ";
        } else {
            $moduleIdsStr = " = '".mysql_real_escape_string($moduleIds)."' ";
        }
        $moduleParamsData = Database::queryAsArray("select * from t_module_instance_params where instanceid $moduleIdsStr");
        foreach ($moduleParamsData as $param) {
            if (is_array($moduleIds)) {
                if (!isset($moduleParams[$param->instanceid])) {
                    $moduleParams[$param->instanceid] = array();
                }
                $moduleParams[$param->instanceid][$param->name] = unserialize($param->value);
            } else {
                $moduleParams[$param->name] = unserialize($param->value);
            }
        }
        return $moduleParams;
    }
    
    static function setModuleParam ($moduleId,$name,$value) {
        $moduleId = mysql_real_escape_string($moduleId);
        $name = mysql_real_escape_string($name);
        $value = mysql_real_escape_string(serialize($value));
        $result = Database::queryAsObject("select 1 as paramexists from t_module_instance_params where instanceid = '$moduleId' and name = '$name'");
        if ($result != null && $result->paramexists == 1) {
            Database::query("update t_module_instance_params set value = '$value' where instanceid = '$moduleId' and name = '$name'");
        } else {
            Database::query("insert into t_module_instance_params (instanceid,name,value) values ('$moduleId','$name','$value')");
        }
    }
    
    static function saveModuleParams($moduleIdsValues) {
        foreach ($moduleIdsValues as $moduleId => $moduleParams) {
            foreach ($moduleParams as $paramName => $paramValue) {
                self::setModuleParam($moduleId, $paramName, $paramValue);
            }
        }
    }
    
}

?>
