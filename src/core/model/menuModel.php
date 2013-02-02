<?php

class MenuModel {
    
    static function getMenuStyle ($id) {
        $id = mysql_real_escape_string($id);
        return Database::queryAsObject("select * from t_menu_style where id = '$id'");
    }
    
    static function getMenuStyles () {
        return Database::queryAsArray("select * from t_menu_style","id");
    }
    
    static function saveMenuStyle ($id,$name,$cssname,$cssstyle) {
        $name = mysql_real_escape_string($name);
        $cssname = mysql_real_escape_string($cssname);
        $cssstyle = mysql_real_escape_string($cssstyle);
        if ($id == null) {
            Database::query("insert into t_menu_style(name,cssclass,cssstyle) values('$name','$cssname','$cssstyle')");
            $result = Database::queryAsObject("select last_insert_id() as lastid from t_menu_style");
            return $result->lastid;
        } else {
            $id = mysql_real_escape_string($id);
            Database::query("update t_menu_style set name = '$name', cssclass = '$cssname', cssstyle = '$cssstyle' where id = '$id'");
        }
    }
    
    static function deleteMenuStyle ($id) {
        $id = mysql_real_escape_string($id);
        Database::queryAsObject("delete from t_menu_style where id = '$id'");
    }
    
    static function getMenuInstances () {
        $results = Database::queryAsArray("select * from t_menu_instance","id");
        if (count($results) == 0) {
            $menuTypes = Database::queryAsArray("select DISTINCT type from t_menu");
            $siteId = mysql_real_escape_string(Context::getSiteId());
            foreach ($menuTypes as $menuType) {
                $type = mysql_real_escape_string($menuType->type);
                Database::query("insert into t_menu_instance(id,name,siteid) values('$type','$type','$siteId')");
            }
            $results = Database::queryAsArray("select * from t_menu_instance","id");
        }
        return $results;
    }
    
    static function deleteMenuInstance ($id) {
        $id = mysql_real_escape_string($id);
        Database::query("delete from t_menu_instance where id = '$id'");
    }
    
    static function saveMenuInstance ($id,$name) {
        $name = mysql_real_escape_string($name);
        $siteId = mysql_real_escape_string(Context::getSiteId());
        if ($id == null) {
            Database::query("insert into t_menu_instance(name,siteid) values('$name','$siteId')");
            $result = Database::queryAsObject("select last_insert_id() as lastid from t_menu_instance");
            return $result->lastid;
        } else {
            $id = mysql_real_escape_string($id);
            Database::query("update t_menu_instance set name = '$name' where id = '$id'");
        }
    }
    
    static function getNextMenuPosition () {
        $result = Database::queryAsObject("select max(position) as maxpos from t_menu");
        return $result->maxpos + 1;
    }

    static function setPagePosition ($pageId,$position,$lang = null) {
        $pageId = mysql_real_escape_string($pageId);
        $position = mysql_real_escape_string($position);
        if ($lang != null) {
            $lang = mysql_real_escape_string($lang);
        }
        // Database::query("update t_menu set position = '$position' where page = '$pageId'".($lang != null ? " and lang = '$lang'" : ""));
        Database::query("update t_menu set position = '$position' where page = '$pageId'");
    }

    static function setPageActivateInMenu ($pageId,$active,$lang) {
        $pageId = mysql_real_escape_string($pageId);
        $lang = mysql_real_escape_string($lang);
        $active = ($active || $active == 1) ? 1 : 0;
        $query = "update t_menu set active = '$active' where page = '$pageId' and lang = '$lang'";
        Database::query($query);
    }
    
    static function getPagesInMenu ($siteId=null, $active=true, $lang=null) {
        
        if ($siteId == null) {
            $site = DomainsModel::getCurrentSite();
            if ($site == null) {
                $siteId = "null";
            } else {
                $siteId = "'".mysql_real_escape_string($site->siteid)."'";
            }
        } else {
            $siteId = "'".mysql_real_escape_string($siteId)."'";
        }
        $lang = ($lang == null) ? Context::getLang() : $lang;
        $lang = mysql_real_escape_string($lang);
        
        if (count(Context::getRoleGroups()) < 1) {
            return array();
        }
        //
        $query = "
            select p.id, p.type, m.parent, m.position, m.active, m.type as menuid, p.namecode, c.value as name, p.welcome, p.title, p.keywords, p.description
            from t_menu m
                left join t_page as p on p.id = m.page and p.siteid = $siteId
                left join t_code as c on p.namecode = c.code and c.lang = '$lang' 
            where m.lang = '$lang' and
                 p.id in (
                    select p1.id from t_page p1 
                    inner join t_page_roles as pc on p1.id = pc.pageid and 
                    pc.roleid in (".implode(array_values(Context::getRoleGroups()),',').")
                    where p1.siteid = $siteId
                ) ";  
        if ($active) 
            $query .= " and m.active = '1'";
        $query .= " order by m.position asc";
        //echo $query;
        $pages = array();
        if (count(Context::getRoleGroups()) > 0) {
            $pages = Database::queryAsArray($query);
        }
        $menus = array();
        foreach ($pages as $page) {
            
            if ($page->parent == null || $page->parent == "0") {
                $child = MenuModel::getChildPage($pages, $page->id);
                if ($child->page != null) {
                    $menus[$page->menuid][$page->id] = $child;
                }
            }
        }
        return $menus;
    }
    
    static function getChildPage ($pages,$id) {
        
        $pageObj;
        $pageObj->page = null;
        $pageObj->children = array();
        $pageObj->selected = false;
        
        foreach ($pages as $page) {
            
            if ($id != $page->id) {
                
                if ($id == $page->parent) {
                    
                    $child = MenuModel::getChildPage($pages, $page->id);
                    if ($child->page != null) {
                        if ($child->selected == true) {
                            $pageObj->selected = true;
                        }
                        $pageObj->children[] = $child;
                    }
                }
            } else {
                
                $pageObj->page = $page;
                if (Context::getPageId() == $page->id) {
                    $pageObj->selected = true;
                }
            }
        }
        return $pageObj;
    }

    static function getPagesInAllLangs ($type, $parent, $active, $lang) {
        $type = mysql_real_escape_string($type);
        $lang = mysql_real_escape_string($lang);
        $parent = mysql_real_escape_string($parent);
        $siteId = DomainsModel::getCurrentSite();
        if ($siteId == null) {
            $siteId = "is null";
        } else {
            $siteId = "= '".mysql_real_escape_string($siteId->siteid)."'";
        }
        $query = "select p.id, p.type, m.parent, m.position, m.active, p.namecode, c.value as name, p.welcome, p.title, p.keywords, p.description, t.template as templateinclude, t.interface as interface
            from t_menu m
            inner join t_page as p on p.id = m.page and p.siteid $siteId 
            left join t_template t on p.template = t.id
            left join t_code as c on p.namecode = c.code and c.lang = '$lang'
            where m.type = '$type'";
        if ($active)
            $query .= " and m.active = '1'";
        if ($parent == null || $parent == '')
            $query .= " and m.parent is null";
        else if ($parent > -1)
            $query .= " and m.parent = '$parent'";
        $query .= " order by m.position asc";
        //echo $query;
        $results = Database::queryAsArray($query);
        $pages = array();
        foreach ($results as $row) {
            $includeResult = true;
            for ($i=0; $i<count($pages); $i++)
                if ($pages[$i]->id == $row->id)
                    $includeResult = false;
            if ($includeResult)
                $pages[] = $row;
        }
        return $pages;
    }

    static function getPageParents ($pageId, $lang) {
        $pageId = mysql_real_escape_string($pageId);
        $lang = mysql_real_escape_string($lang);
        $parent = $pageId;
        $parents = array();
        $pos = 0;
        while ($parent != null) {

            $query = "select p.id, p.type, m.parent, m.position, m.active, p.namecode, c.value as name, p.welcome, p.title, p.keywords, p.description
                from t_page p
                left join t_menu as m on p.id = m.page
                left join t_code as c on p.namecode = c.code and c.lang = '$lang'
                where  m.page = '$parent'";
            $result = Database::query($query);
            $row = mysql_fetch_object($result);
            if ($row != null) {
                $parent = $row->parent;
                $parents[] = $row;
            } else {
                $parent = null;
            }
            $pos++;
        }
        return $parents;
    }
    
    static function createPageInMenu ($pageId,$menuType,$menuParent,$lang) {
        $pageId = mysql_real_escape_string($pageId);
        $menuType = mysql_real_escape_string($menuType);
        $menuParent = mysql_real_escape_string($menuParent);
        $lang = mysql_real_escape_string($lang);
        // add page to menu
        if ($menuParent == '' || $menuParent == null) {
            $parentStr = "null";
        } else {
            $parentStr = "'$menuParent'";
        }
	$result = Database::queryAsArray("select 1 as doseexist from t_menu where page = '$pageId' and lang = '$lang'");
        if (!Common::isEmpty($result)) {
		// update t_menu
	} else {
		$nextPosition = MenuModel::getNextMenuPosition();
        	Database::query("insert into t_menu(page,type,active,parent,lang,position) values('$pageId','$menuType','0',$parentStr,'$lang','$nextPosition')");
	}
	
    }
    
    static function updatePageInMenu ($pageId,$menuType,$menuParent,$lang) {
        // create the parent menu points if they dont exist in that language
        $parents = MenuModel::getPageParents($pageId,$lang);
        for ($i=count($parents)-1; $i>-1; $i--) {
            if (!MenuModel::dosePageInMenuExist($parents[$i]->id,$menuType,$parents[$i]->parent,$lang)) {
                MenuModel::createPageInMenu($parents[$i]->id, $menuType, $parents[$i]->parent, $lang);
            }
        }
        if (MenuModel::dosePageInMenuExist($pageId, $menuType, $menuParent, $lang) == false) {
            //echo "yyyyyyyyy creating page in  xxxxxxxxxx";
            MenuModel::createPageInMenu($pageId, $menuType, $menuParent, $lang);
            
        }
        //echo "creating page in lang finnished!";
    }
    
    static function dosePageInMenuExist ($pageId,$menuType,$menuParent,$lang) {
        $lang = mysql_real_escape_string($lang);
        $pageId = mysql_real_escape_string($pageId);
        $menuType = mysql_real_escape_string($menuType);
        $menuParent = mysql_real_escape_string($menuParent);
        $obj = Database::queryAsObject("select 1 as res from t_menu where page = '$pageId' and type = '$menuType' and lang = '$lang'");
        return ($obj != null && $obj->res == '1') ? true : false;
    }
    
}

