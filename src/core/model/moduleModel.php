<?php

require_once 'core/model/moduleModel.php';

class ModuleModel {
    
    static function getModule ($id) {
        $id = Database::escape($id);
        return Database::queryAsObject("select * from t_module where id = '$id'");
    }

    static function getModules () {
        return Database::queryAsArray("select * from t_module");
    }
    
    static function getModuleBySysname ($sysname) {
        $sysname = Database::escape($sysname);
        return Database::queryAsObject("select * from t_module where sysname = '$sysname' and static = '1'");
    }
    
    static function getModuleByName ($moduleName) {
        $moduleName = Database::escape($moduleName);
        return Database::queryAsObject("select * from t_module where sysname = '$moduleName'");
    }
    
    static function getModuleCategorys () {
        return Database::queryAsArray("select * from t_module_category order by position asc");
    }
    
    static function getModulesInMenu () {
        return Database::queryAsArray("select * from t_module where inmenu = '1'");
    }
    
    static function getAvailableModules () {
        return array();
    }
    
    static function createModule ($name,$description,$include,$interface,$inmenu,$sysname,$category,$position,$static) {
        $name = Database::escape($name);
        $description = Database::escape($description);
        $include = Database::escape($include);
        $interface = Database::escape($interface);
        $inmenu = Database::escape($inmenu);
        $sysname = Database::escape($sysname);
        $category = Database::escape($category);
        $position = Database::escape($position);
        $static = Database::escape($static);
        Database::query("insert into t_module(name,description,include,interface,inmenu,sysname,category,position,static) values ('$name','$description','$include','$interface','$inmenu','$sysname','$category','$position','$static')");
        $newObj = Database::query("select max(id) as lastid from t_module");
        return $newObj->lastid;
    }
    
    static function saveModule ($id, $name, $description, $inmenu, $category) {
        $id = Database::escape($id);
        $name = Database::escape($name);
        $description = Database::escape($description);
        $inmenu = Database::escape($inmenu);
        $category = Database::escape($category);
        Database::query("update t_module set name = '$name', description = '$description', inmenu = '$inmenu', category = '$category' where id = '$id'");
    }
    
    static function setModuleCategory ($id, $category) {
        $id = Database::escape($id);
        $category = Database::escape($category);
        Database::query("update t_module set category = '$category' where id = '$id'");
    }
    
    static function addModule ($siteId,$moduleId) {
        $siteId = Database::escape($siteId);
        $moduleId = Database::escape($moduleId);
        $obj = Database::queryAsObject("select 1 from t_site_module where siteid = '$siteId' and moduleid = '$moduleId'");
        if ($obj == null) {
            Database::query("insert into t_site_module (siteid,moduleid) values('$siteId','$moduleId')");
        }
    }
    
    static function removeModule ($siteId,$moduleId) {
        $siteId = Database::escape($siteId);
        $moduleId = Database::escape($moduleId);
        Database::query("delete from t_site_module where siteid = '$siteId' and templateid = '$moduleId'");
    }
    
    /**
     * get a module object by module db object
     * @param Object $moduleObj
     * @param array $params
     * @return Object
     */
    static function getModuleClass ($moduleObj, $params = true) {
        if (empty($moduleObj) || empty($moduleObj->include) || empty($moduleObj->interface)) {
            echo "error loading module object<br/>";
            echo "module:<br>";
            print_r($moduleObj);
            echo "stacktrace<br/>";
            echo Common::getBacktrace();
            exit;
        }
        // get the module instance
        include_once($moduleObj->include);
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
     * @param array $moduleIds int or array
     * @return array
     */
    static function getModulesParams ($moduleIds) {
        
        $moduleParams = array();
        if (is_array($moduleIds)) {
            foreach ($moduleIds as $key => $value) {
                $moduleIds[$key] = Database::escape($value);
            }
            $moduleIdsStr = " in ('".implode("','",$moduleIds)."') ";
        } else {
            $moduleIdsStr = " = '".Database::escape($moduleIds)."' ";
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
        $moduleId = Database::escape($moduleId);
        $name = Database::escape($name);
        $value = Database::escape(serialize($value));
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
    
    static function getModuleInstancesBySiteId ($siteId) {
        $siteId = Database::escape($siteId);
        return Database::queryAsArray("select mi.* from t_module_instance mi join t_templatearea ta on mi.id = ta.instanceid join t_page p on ta.pageid = p.id where p.siteid = '$siteId'"); 
    }
    
    static function getModuleInstanceParamsBySiteId ($siteId) {
        $siteId = Database::escape($siteId);
        return Database::queryAsArray("select mip.* from t_module_instance_params mip join t_module_instance mi on mip.instanceid = mi.id join t_templatearea ta on mi.id = ta.instanceid join t_page p on ta.pageid = p.id where p.siteid = '$siteId'");
    }
}

?>
