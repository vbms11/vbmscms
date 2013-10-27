<?php

require_once("modules/admin/adminPagesBaseModule.php");

class MenuView extends AdminPagesBaseModule {
    
    function onProcess () {
	if (Context::hasRole("menu.edit")) {
	
            switch (parent::getAction()) {
                case "edit":
                    parent::focus();
                    break;
                case "newMenu":
                    $newId = MenuModel::saveMenuInstance(null, parent::post('newMenuName'));
                    parent::param("selectedMenu",$newId);
                    parent::redirect(array("action"=>"edit"));
                    break;
                case "editMenu":
                    MenuModel::saveMenuInstance(parent::get('id'), parent::post('editMenuName'));
                    parent::redirect(array("action"=>"edit"));
                    break;
                case "selectMenu":
                    parent::param("selectedMenu",parent::get('id'));
                    // parent::redirect(array("action"=>"edit"));
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
                    
                    $this->deletePageAction();
                    parent::redirect(array("action"=>"edit","parent"=>$_GET['parent']));
                    break;
                    
                case "moveup":
                    
                    $this->movePageUpAction();
                    parent::redirect(array("action"=>"edit","parent"=>$_GET['parent']));
                    break;
                
                case "movedown":
                    
                    $this->movePageDownAction();
                    parent::redirect(array("action"=>"edit","parent"=>$_GET['parent']));
                    break;
            }
	}
    }
    
    function onView () {
        
        switch (parent::getAction()) {
            case "newStyle":
            case "selectMenu":
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
        return array("css/menu.css","/?service=menuStyles");
    }
    
    function getScripts () {
        return array("js/menu.js");
    }
    
    function printEditView () {
        // get parent
        $parent = (isset($_GET['parent']) ? $_GET['parent'] : null);
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
                    
                    <?php
                    if (parent::param("selectedMenu") != null) {
                        ?>
                        <hr/>
                        <?php
                        $_GET['menuModuleId'] = $this->getId();
                        $this->printPageMenuView(parent::param("selectedMenu"), $parent);
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
                <?php
                if (parent::param("selectedMenu") != null) {
                    ?>
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
                    <?php
                }
                ?>
            </div>
            <script>
            $("#selectedMenu").change(function () {
                callUrl("<?php echo parent::link(array("action"=>"selectMenu")); ?>",{"id":$("#selectedMenu").val()});
                e.preventDefault();
                return false;
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
                heightStyle: "content"
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
        $menuStyleClass = "";
        if (!empty($menuStyle)) {
            $menuStyleClass = $menuStyle->cssclass;
        }
        $menus = Context::getRenderer()->getMenu(parent::param("selectedMenu"));
        // if no menu selected select the first menu if any exist
        if (empty($menus)) {
            $menusList = Context::getRenderer()->getMenus();
            if (count($menusList) > 0) {
                $menus = current($menusList);
            }
        }
        ?>
        <div class="panel menuPanel <?php echo $menuStyleClass ?>">
            <?php
            if (!empty($menus) && !empty($menuStyle)) {
                ?>
                <div class="sddm">
                    <?php
                    $first = true;
                    if (!empty($menus)) {
                        foreach ($menus as $page) {
                            $levelId = "m_".$page->page->id;
                            if (!Common::isEmpty($page->page->name)) {
                                ?>
                                <div>
                                    <a class="<?php echo (($first == true) ? "sddmFirst " : "").(($page->selected == true) ? "sddmSelected " : ""); ?>" href="<?php echo NavigationModel::createPageNameLink($page->page->name, $page->page->id); ?>" onmouseover="mopen('<?php echo $levelId; ?>');" onmouseout="mclosetime('<?php echo $levelId; ?>')" ><?php echo Common::htmlEntities($page->page->name); ?></a>
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
            <?php
            }
            ?>
        </div>
        <?php
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