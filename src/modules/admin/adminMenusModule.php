<?php

require_once("core/plugin.php");
require_once("core/model/pagesModel.php");
require_once("core/model/moduleModel.php");
require_once("core/model/rolesModel.php");
require_once("modules/admin/adminPagesBaseModule.php");

class AdminMenusModule extends AdminPagesBaseModule {

    function onProcess ()  {

        if (Context::hasRole("pages.editmenu")) {
            
            switch (parent::getAction()) {
                
                case "newMenu":
                    
                    $newId = $this->newMenuAction();
                    $_SESSION["adminMenuId"] = $newId;
                    break;
                    
                case "editMenu":
                    
                    $this->editMenuAction();
                    break;
                
                case "deleteMenu":
                    
                    $this->deleteMenuAction();
                    $selectedMenu = current(MenuModel::getMenuInstancesAssocId());
                    if ($selectedMenu !== false) {
                        $_SESSION["adminMenuId"] = $selectedMenu->id;
                    }
                    break;
                    
                case "savepage":
                    
                    $this->savePageAction();
                    parent::redirect();
                    break;
                
                case "createPage":
                    
                    break;
                    
                case "showEditMenu":
                    
                    if (isset($_GET["adminMenuId"])) {
                        $_SESSION["adminMenuId"] = $_GET["adminMenuId"];
                    }
                    break;
                
                case "deletepage":
                    
                    $this->deletePageAction();
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

    /**
     * called when page is viewed and html created
     */
    function onView () {
        
        switch (parent::getAction()) {
            
            case "createPage":
                
                $this->printPageSettingsTabView();
                break;
                
            default:
                if (Context::hasRole("pages.edit")) {
                    $this->printEditMenu();
                }
        }
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("pages.editmenu","pages.edit");
    }
    
    static function getTranslations() {
        return array_merge_recursive(parent::getTranslations(),
            array(
                "en" => array(
                    "admin.menus.button.delete" => "Click here to delete this menu",
                    "admin.menus.button.rename" => "Click here to rename this menu",
                    "admin.menus.button.new"    => "Click here to create a new menu",
                    "admin.menus.legend.rename" => "Rename Menu",
                    "admin.menus.legend.new"    => "Create New Menu",
                    "admin.menus.legend.delete" => "Delete Menu"
                ),"de" => array(
                    "admin.menus.button.delete" => "Clicken sie here um diesen menu zu löchen",
                    "admin.menus.button.rename" => "Clicken sie here um den menu umzubenenen",
                    "admin.menus.button.new"    => "Clicken sie here um ein neues menu zu erstellen",
                    "admin.menus.legend.rename" => "Menu Umbenenen",
                    "admin.menus.legend.new"    => "Neues Menu",
                    "admin.menus.legend.delete" => "Menu Löchen"
                )
            )
        );
        
    }
    
    function printEditMenu () {
        
        if (isset($_SESSION["adminMenuId"])) {
            
            ?>
            <div id="adminMenusTabs">
                <ul>
                    <li><a href="#menuPagesTab"><?php echo parent::getTranslation("admin.menus.tab.menu"); ?></a></li>
                    <li><a href="#menuOperationsTab"><?php echo parent::getTranslation("admin.menus.tab.operations"); ?></a></li>
                </ul>
                <div id="menuPagesTab">
                    <?php $this->printPageMenuView($_SESSION["adminMenuId"], null); ?>
                </div>
                <div id="menuOperationsTab">
                    <fieldset>
                        <legend><?php echo parent::getTranslation("admin.menus.legend.rename"); ?></legend>
                        <?php $this->printRenameMenuView($_SESSION["adminMenuId"]); ?>
                        <button id="btn_editMenu"><?php echo parent::getTranslation("admin.menus.button.rename"); ?></button>
                    </fieldset>
                    <fieldset>
                        <legend><?php echo parent::getTranslation("admin.menus.legend.new"); ?></legend>
                        <?php $this->printCreateMenuView(); ?>
                        <button id="btn_newMenu"><?php echo parent::getTranslation("admin.menus.button.new"); ?></button>
                    </fieldset>
                    <fieldset>
                        <legend><?php echo parent::getTranslation("admin.menus.legend.delete"); ?></legend>
                        <button id="btn_deleteMenu"><?php echo parent::getTranslation("admin.menus.button.delete"); ?></button>
                    </fieldset>
                </div>
            </div>
            <script>
            $("#btn_newMenu").button().click(function () {
                $("#new-menu-dialog").dialog("open");
            });
            $("#btn_editMenu").button().click(function () {
                $("#edit-menu-dialog").dialog("open");
            });
            $("#btn_deleteMenu").button().click(function () {
                doIfConfirm('<?php echo parent::getTranslation("menu.delete.confirm") ?>',
                    '<?php echo parent::link(array("action"=>"deleteMenu")); ?>',{"id":"<?php echo $_SESSION["adminMenuId"]; ?>"});
            });
            $("#adminMenusTabs").tabs();
            </script>
            <?php
        
        } else {
            echo "no menu selected";
        }
    }
    
}
?>