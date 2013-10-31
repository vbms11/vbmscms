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
                
                case "savepage":
                    
                    $this->savePageAction();
                    parent::redirect();
                    break;
                
                case "createPage":
                    
                    break;
                    
                case "editMenu":
                    
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
    
    function printEditMenu () {
        
        if (isset($_SESSION["adminMenuId"])) {
            
            // $page = PagesModel::getPage($_SESSION["adminMenuId"], Context::getLang(), false);
            
            ?>
            <div id="adminMenusTabs">
                <ul>
                    <li><a href="#tabs-1">Menu</a></li>
                </ul>
                <div id="tabs-1">
                    <?php $this->printPageMenuView($_SESSION["adminMenuId"], null); ?>
                </div>
            </div>
            <script>
            $("#adminMenusTabs").tabs();
            </script>
            <?php
        
        } else {
            echo "no menu selected";
        }
    }
    
}
?>