<?php

class MenuView extends XModule {
    
    function onProcess () {
	if (Context::hasRole("menu.edit")) {
	
        switch (parent::getAction()) {
            case "edit":
                parent::focus();
                break;
            case "newMenu":
                $newId = MenuModel::saveMenuInstance(null,$_POST['newMenuName']);
                parent::param("selectedMenu",$newId);
                parent::redirect(array("action"=>"edit"));
                break;
            case "editMenu":
                MenuModel::saveMenuInstance(isset($_GET['id']) ? $_GET['id'] : null, $_POST['editMenuName']);
                parent::redirect(array("action"=>"edit"));
                break;
            case "selectMenu":
                parent::param("selectedMenu",$_GET['id']);
                parent::redirect(array("action"=>"edit"));
                break;
            case "deleteMenu":
                MenuModel::deleteMenuInstance($_GET['id']);
                parent::redirect(array("action"=>"edit"));
                break;
            case "newStyle":
                $newId = MenuModel::saveMenuStyle(null, $_POST['newStyleName'], "", "");
                parent::param("selectedStyle",$newId);
                parent::redirect(array("action"=>"edit"));
                break;
            case "editStyle":
                MenuModel::saveMenuStyle($_GET['id'],$_POST['styleName'],$_POST['cssname'],$_POST['cssstyle']);
                parent::redirect(array("action"=>"edit"));
                break;
            case "selectStyle":
                parent::param("selectedStyle",$_GET['id']);
                // parent::redirect(array("action"=>"edit"));
                break;
            case "deleteStyle":
                MenuModel::deleteMenuStyle($_GET['id']);
                parent::redirect(array("action"=>"edit"));
                break;
            case "deletepage":
                PagesModel::deletePage($_GET['id']);
                parent::redirect(array("action"=>"edit","parent"=>$_GET['parent']));
                break;
            case "moveup":
                $pages = MenuModel::getPagesInAllLangs(parent::param("selectedMenu"),$_GET['parent'],false,Context::getLang());
                for ($i=0; $i<count($pages); $i++) {
                    if ($pages[$i]->id == $_GET['id']) {
                        if ($i != 0) {
                            MenuModel::setPagePosition($pages[$i]->id,$pages[$i-1]->position);
                            MenuModel::setPagePosition($pages[$i-1]->id,$pages[$i]->position);
                            break;
                        }
                    }
                }
                parent::redirect(array("action"=>"edit","parent"=>$_GET['parent']));
                break;
            case "movedown":
                $pages = MenuModel::getPagesInAllLangs(parent::param("selectedMenu"),$_GET['parent'],false,Context::getLang());
                for ($i=count($pages)-1; $i>-1; $i--) {
                    if ($pages[$i]->id == $_GET['id']) {
                        if (count($pages)-1 > $i) {
                            MenuModel::setPagePosition($pages[$i]->id,$pages[$i+1]->position);
                            MenuModel::setPagePosition($pages[$i+1]->id,$pages[$i]->position);
                            break;
                        }
                    }
                }
                parent::redirect(array("action"=>"edit","parent"=>$_GET['parent']));
                break;
        }
	}
    }
    
    function onView () {
        
        switch (parent::getAction()) {
            case "newStyle":
            case "selectStyle":
            case "edit":
                if (Context::hasRole("menu.edit")) {
                    $this->printEditView();
                }
                break;
            default:
                $this->printMenuView();
        }
    }
    
    function getRoles () {
        return array("menu.edit");
    }
    
    function getStyles () {
        //return array("styles.css.php");
        return array();
    }
    
    function getScripts () {
        return array("js/menu.js");
    }
    
    function printEditView () {
        
        // get parent
        $parent = (isset($_GET['parent']) ? $_GET['parent'] : null);
        if (isset($_GET['menu'])) {
            parent::param("selectedMenu",$_GET['menu']);
        }
        
        // menus
        $menus = MenuModel::getMenuInstances();
        $selectedMenuName = "";
        if (count($menus) > 0) {
            if (parent::param("selectedMenu") != null && isset($menus[parent::param("selectedMenu")])) {
                $selectedMenuName = $menus[parent::param("selectedMenu")]->name;
            } else {
                $keys = array_keys($menus);
                $selectedMenuName = $menus[$keys[0]]->name;
                parent::param("selectedMenu",$keys[0]);
            }
        }
        
        // get pages to be shown
        $pages = MenuModel::getPagesInAllLangs(parent::param("selectedMenu"),$parent,false,Context::getLang());
        
        // styles
        $styles = MenuModel::getMenuStyles();
        $selectedStyle = null;
        if (count($styles) > 0) {
            if (parent::param("selectedStyle") != null && isset($styles[parent::param("selectedStyle")])) {
                $selectedStyle = MenuModel::getMenuStyle(parent::param("selectedStyle"));
            } else {
                $keys = array_keys($styles);
                parent::param("selectedStyle",$styles[$keys[0]]->id);
                $selectedStyle = MenuModel::getMenuStyle($styles[$keys[0]]->id);
            }
        }
        
        ?>
        <div class="panel">
            
            <div id="menu-accordion">
                <h3><a href="#section1">Configure Menu Pages</a></h3>
                <div>
                    
                    <table><tr>
                    <td class="nowrap">
                        Select Menu: 
                    </td>
                    <?php
                    if (count($menus) > 0) {
                        ?>
                        <td class="expand">
                            <?php InputFeilds::printSelect("selectedMenu", parent::param("selectedMenu"), Common::toMap($menus,"id","name")); ?>
                        </td>
                        <?php
                    }
                    ?>
                    <td>
                        <button id="btn_newMenu">New</button>
                    </td>
                    <?php
                    if (count($menus) > 0) {
                        ?>
                        <td>
                            <button id="btn_editMenu">Edit</button>
                        </td><td>
                            <button id="btn_deleteMenu">Delete</button>
                        </td>
                        <?php
                    }
                    ?>
                    </tr></table>
                    <hr/>
                    
                    <table><tr><td>
                        <button class="newPageButton">Neue Seite erstellen</button>
                    </td>
                    <?php
                    if ($parent != null) {
                        
                        $parentPages = MenuModel::getPageParents($parent,Context::getLang());
                        ?>
                        <td>
                        <a class="pagesPathLink" href="<?php echo parent::link(array("action"=>"edit","menu"=>parent::param("selectedMenu"),"parent"=>"")); ?>">Menu</a>
                        <?php
                        for ($i=count($parentPages)-1; $i>-1; $i--) {
                            if ($i - 1 < 0) $parentId = $parent;
                            else $parentId = $parentPages[$i-1]->parent;
                            ?>
                            <a class="pagesPathLink" href="<?php echo parent::link(array("action"=>"edit","menu"=>parent::param("selectedMenu"),"parent"=>$parentId)); ?>"><?php echo $parentPages[$i]->name; ?></a>
                            <?php
                        }
                        ?>
                        </td>
                        <?php
                    }
                    ?>
                    </tr></table>
                    <br/>

                    <?php
                    if (count($pages) > 0) {
                        ?>
                        <table class="resultTable expand" cellspacing="0" border="0"><tr>
                            <td class="resultTableCell resultTableHeader" align="center">id</td>
                            <td class="resultTableCell resultTableHeader expand" align="center">Name</td>
                            <td class="resultTableCell resultTableHeader" align="center" colspan="5">Tools</td>
                        </tr>
                        <?php
                        for ($i=0; $i<count($pages); $i++) {
                            ?>
                            <tr>
                                <td class="resultTableCell"><?php echo $pages[$i]->id; ?></td>
                                <td class="resultTableCell expand" align="center">
                                    <?php
                                    $name = ($pages[$i]->name == "") ? "Bitte Name vergeben" : $pages[$i]->name;
                                    ?>
                                    <a href="<?php echo parent::link(array("action"=>"edit","menu"=>parent::param("selectedMenu"),"parent"=>$pages[$i]->id)); ?>"><?php echo $name; ?></a>
                                </td>
                                <td class="resultTableCell"><a href="<?php echo NavigationModel::createPageLink($pages[$i]->id,array()); ?>"><img src="resource/img/view.png" class="imageLink" alt="" /></a></td>
                                <td class="resultTableCell"><a href="<?php echo NavigationModel::createStaticPageLink("pageConfig",array("menu"=>parent::param("selectedMenu"),"parent"=>$parent,"id"=>$pages[$i]->id)); ?>"><img src="resource/img/preferences.png" class="imageLink" alt="" /></a></td>
                                <td class="resultTableCell"><a href="<?php echo parent::link(array("action"=>"movedown","menu"=>parent::param("selectedMenu"),"parent"=>$parent,"id"=>$pages[$i]->id)); ?>"><img src="resource/img/movedown.png" class="imageLink" alt="" /></a></td>
                                <td class="resultTableCell"><a href="<?php echo parent::link(array("action"=>"moveup","menu"=>parent::param("selectedMenu"),"parent"=>$parent,"id"=>$pages[$i]->id)); ?>"><img src="resource/img/moveup.png" class="imageLink" alt="" /></a></td>
                                <td class="resultTableCell"><img src="resource/img/delete.png" class="imageLink" alt="" onclick="doIfConfirm('Wollen Sie wirklich diese Seite l&ouml;schen?','<?php echo parent::link(array("action"=>"deletepage","menu"=>parent::param("selectedMenu"),"parent"=>$parent,"id"=>$pages[$i]->id),false); ?>');" /></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </table>
                        <br/>
                        <button class="newPageButton">Neue Seite erstellen</button>
                        <hr/>
                        <?php
                    }
                    ?>
                    <div id="edit-menu-dialog" title="Edit Menu">
                        <form method="post" id="edit-menu-dialog-form" action="<?php echo parent::link(array("action"=>"editMenu","id"=>parent::param("selectedMenu"))); ?>">
                            <b>Menu Name</b>
                            <?php
                            InputFeilds::printTextFeild("editMenuName",$selectedMenuName);
                            ?>
                        </form>
                    </div>
                    <div id="new-menu-dialog" title="New Menu">
                        <form method="post" id="new-menu-dialog-form" action="<?php echo parent::link(array("action"=>"newMenu")); ?>">
                            <b>Menu Name</b>
                            <?php
                            InputFeilds::printTextFeild("newMenuName");
                            ?>
                        </form>
                    </div>
                    
                </div>
                <h3><a href="#section2">Configure Menu Style</a></h3>
                <div>
                    
                    <table><tr><td class="nowrap">
                        Select Style: 
                    </td>
                    <?php
                    if (count($styles) > 0) {
                        ?>
                        <td class="expand">
                            <?php InputFeilds::printSelect("selectedStyle", parent::param("selectedStyle"), Common::toMap($styles,"id","name")); ?>
                        </td>
                        <?php
                    }
                    ?>
                    <td>
                        <button id="btn_newStyle">New</button>
                    </td>
                    <?php
                    if (count($styles) > 0) {
                        ?>
                        <td>
                            <button id="btn_deleteStyle">Delete</button>
                        </td>
                        <?php
                    }
                    ?>
                    </tr></table>
                    <hr/>
                    
                    <?php
                    if (count($styles) > 0) {
                        ?>
                        <form method="post" action="<?php echo parent::link(array("action"=>"editStyle","id"=>parent::param("selectedStyle"))); ?>#section2">
                            <table width="100%"><tr>
                                <td class="nowrap">Style Name: </td>
                                <td class="expand">
                                    <?php InputFeilds::printTextFeild('styleName',$selectedStyle->name,"expand"); ?>
                                </td>
                            </tr><tr>
                                <td class="nowrap">Css Class Name: </td>
                                <td class="expand">
                                    <?php InputFeilds::printTextFeild('cssname',$selectedStyle->cssclass,"expand"); ?>
                                </td>
                            </tr><tr>
                                <td colspan="2">
                                    Menu Style Css Code:
                                </td>
                            </tr><tr>
                                <td colspan="2">
                                    <?php InputFeilds::printTextArea('cssstyle',$selectedStyle->cssstyle,"expand",15); ?>
                                </td>
                            </tr></table><hr/>
                            <div class="alignRight">
                                <button id="btn_saveStyle">Save</button>
                            </div>
                        </form>
                        <?php
                    }
                    ?>
                    
                    <div id="new-style-dialog" title="New Style">
                        <form method="post" id="new-style-dialog-form" action="<?php echo parent::link(array("action"=>"newStyle")); ?>#section2">
                            <b>Menu Style Name</b>
                            <?php
                            InputFeilds::printTextFeild("newStyleName");
                            ?>
                        </form>
                    </div>
                    
                </div>
            </div>
            
            
            <script>
            $("#selectedMenu").change(function () {
                callUrl("<?php echo parent::link(array("action"=>"selectMenu")); ?>",{"id":$("#selectedMenu").val()});
            });
            $("#btn_newMenu").button().click(function () {
                $("#new-menu-dialog").dialog("open");
            });
            $("#btn_editMenu").button().click(function () {
                $("#edit-menu-dialog").dialog("open");
            });
            $("#btn_deleteMenu").button().click(function () {
                doIfConfirm('Wollen Sie wirklich diese Menu l&ouml;schen?',
                    '<?php echo parent::link(array("action"=>"deleteMenu")); ?>',{"id":$("#selectedMenu").val()});
            });
            $("#edit-menu-dialog").dialog({
                autoOpen: false, height: 300, width: 350, modal: true,
                buttons: {
                    "Save": function() {
                        $("#edit-menu-dialog-form").submit();
                    },
                    "Cancel": function() {
                        $(this).dialog("close");
                    }
                }
            });
            $("#new-menu-dialog").dialog({
                autoOpen: false, height: 300, width: 350, modal: true,
                buttons: {
                    "Save": function() {
                        $("#new-menu-dialog-form").submit();
                    },
                    "Cancel": function() {
                        $(this).dialog("close");
                    }
                }
            });
            $("#new-style-dialog").dialog({
                autoOpen: false, height: 300, width: 350, modal: true,
                buttons: {
                    "Save": function() {
                        $("#new-style-dialog-form").submit();
                    },
                    "Cancel": function() {
                        $(this).dialog("close");
                    }
                }
            });
            $("#menu-accordion").accordion({
                autoHeight: false,
                navigation: true
            });
            $(".newPageButton").each(function (index,object) {
                $(object).button().click(function () {
                    callUrl("<?php echo NavigationModel::createStaticPageLink("pageConfig",array("menu"=>parent::param("selectedMenu"),"parent"=>$parent)); ?>");
                })
            })
            $("#btn_newStyle").button().click(function () {
                $("#new-style-dialog").dialog("open");
            });
            $("#btn_deleteStyle").button().click(function () {
                doIfConfirm('Wollen Sie wirklich diese Style l&ouml;schen?',
                    '<?php echo parent::link(array("action"=>"deleteStyle")); ?>',{"id":$("#selectedStyle").val()});
            });
            $("#btn_saveStyle").button().click(function () {
                $("#form_saveStyle").submit();
            });
            $("#selectedStyle").change(function () {
                callUrl("<?php echo parent::link(array("action"=>"selectStyle")); ?>",{"id":$("#selectedStyle").val()},"section2");
            });
            </script>
        </div>
        <?php
    }
    
    function printMenuView () {
        $menuStyle = MenuModel::getMenuStyle(parent::param("selectedStyle"));
        // styles
        $styles = MenuModel::getMenuStyles();
        $menuStyle = null;
        if ($menuStyle == null && count($styles) > 0) {
            if (parent::param("selectedStyle") != null && isset($styles[parent::param("selectedStyle")])) {
                $menuStyle = MenuModel::getMenuStyle(parent::param("selectedStyle"));
            } else {
                $keys = array_keys($styles);
                parent::param("selectedStyle",$styles[$keys[0]]->id);
                $menuStyle = MenuModel::getMenuStyle($styles[$keys[0]]->id);
            }
        }
        if ($menuStyle != null) {
            ?>
            <div class="<?php echo $menuStyle->cssclass ?>">
                <div class="sddm">
                    <?php
                    $menus = Context::getRenderer()->getMenu(parent::param("selectedMenu"));
                    // if no menu selected select the first menu if any exist
                    if (empty($menus)) {
                        $menus = Context::getRenderer()->getMenus();
                        $menuKeys = array_keys($menus);
                        if (count($menuKeys) > 0) {
                            parent::param("selectedMenu",$menuKeys[0]);
                            $menus = Context::getRenderer()->getMenu(parent::param("selectedMenu"));
                        }
                    }
                    $first = true;
                    if (!Common::isEmpty($menus)) {
                        foreach ($menus as $page) {
                            $levelId = "m_".$page->page->id;
                            if (!Common::isEmpty($page->page->name)) {
                                ?>
                                <div>
                                    <a class="<?php echo (($first == true) ? "sddmFirst " : "").(($page->selected == true) ? "sddmSelected " : ""); ?>" href="<?php echo NavigationModel::createPageNameLink($page->page->name, $page->page->id); ?>" onmouseover="mopen('<?php echo $levelId; ?>');" onmouseout="mclosetime('<?php echo $levelId; ?>')" ><?php echo Context::htmlEntities($page->page->name); ?></a>
                                    <?php
                                    $this->printMenuNode($page,array($levelId));
                                    ?>
                                </div>
                                <?php
                                $first = false;
                            }
                        }
                    } else {
                        echo "<br/>";
                    }
                    ?>
                </div>
            </div>
            <?php
        }
    }
    
    function printMenuNode ($page,$parentNodes) {
        
        if (count($page->children) > 0) {
		$nodes = $parentNodes;
            	$thisLevel = "m_".$page->page->id;
		?>
            <div id="<?php echo $thisLevel; ?>" class='sddmHide <?php if ($page->selected == true) echo "sddmSelected"; ?>' onmouseover="mopen(['<?php echo implode($parentNodes,"','") ?>']);" onmouseout="mclosetime('<?php echo $thisLevel; ?>');">
                <?php
                $first = true;
                foreach ($page->children as $childPage) {
			$parentNodes = $nodes;
			$levelId = "m_".$childPage->page->id;
			$parentNodes[] = $levelId;
                    ?>
                    <a href="<?php echo NavigationModel::createPageNameLink($childPage->page->name, $childPage->page->id); ?>" <?php if ($childPage->selected == true) echo "class='sddmSelected'"; ?> onmouseover="mopen(['<?php echo implode($parentNodes,"','") ?>']);" onmouseout="mclosetime('<?php echo $levelId; ?>');" ><?php echo $childPage->page->name; ?></a>
                    <?php
                    if (count($childPage->children) > 0) {
                        $this->printMenuNode($childPage,$parentNodes);
                    }
                    $first = false;
                }
                ?>
            </div>
            <?php
        }
    }
}

?>