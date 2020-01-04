<?php

class RoleSerializer extends Serializer {
    
    private const filename = "core/install/defaultRoles.xml";
    
    function exportRoles () {
        
        parent::clear();
        parent::addTable("t_roles_custom", RolesModel::getCustomRoles());
        parent::addTable("t_roles_rights", RolesModel::getRoleRights());
        parent::addTable("t_module_roles", RolesModel::getModuleRoles());
        
        file_put_contents(self::filename, parent::createXml());
    }
    
    function importRoles () {
        
        parent::loadXml(self::filename);
        
        $oldIdNewId = array();
        foreach (parent::getTable("t_roles_custom") as $row) {
            $oldIdNewId[$row->id] = RolesModel::insertCustomRole($row->id, $row->name, $row->system);
        }
        
        foreach (parent::getTable("t_roles_rights") as $row) {
            RolesModel::insertRoleRights($row->id, $row->customroleid, $row->customrolerightid);
        }
        
        foreach (parent::getTable("t_module_roles") as $row) {
            RolesModel::insertModuleRoleToCustomRole($row->id, $row->modulerole, $row->customrole);
        }
    }
    
}
