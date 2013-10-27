<?php

require_once("core/plugin.php");
require_once("core/model/pagesModel.php");
require_once("core/model/moduleModel.php");
require_once("core/model/rolesModel.php");
require_once("modules/admin/adminPagesBaseModule.php");

class AdminPagesModule extends AdminPagesBaseModule {

    function onProcess ()  {

        if (Context::hasRole("pages.editmenu")) {
            
            switch (parent::getAction()) {
                
                case "savepage":
                    
                    $this->savePageAction();
                    
                case "editPage":
                    
                    if (isset($_GET["adminPageId"])) {
                        $_SESSION["adminPageId"] = $_GET["adminPageId"];
                    }
                    break;
                
                case "setTemplate":
                    break;
                
                case "deletepage":
                    
                    $this->deletePageAction();
                    break;
                
                case "moveup":
                    
                    $this->movePageUpAction();
                    break;
                    
                case "movedown":
                    
                    $this->movePageDownAction();
                    break;

            }
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {
        
        switch (parent::getAction()) {
            default:
                if (Context::hasRole("pages.edit")) {
                    $this->printEditPage();
                }
        }
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("pages.editmenu","pages.edit");
    }

    function printEditPage () {
        
        if (isset($_SESSION["adminPageId"])) {
            
            $page = PagesModel::getPage($_SESSION["adminPageId"], Context::getLang(), false);
            
            ?>
            <div id="adminPagesTabs">
                <ul>
                    <li><a href="#tabs-1">Content</a></li>
                    <li><a href="#tabs-2">Menu</a></li>
                    <li><a href="#tabs-3">Template</a></li>
                    <li><a href="#tabs-4">Settings</a></li>
                </ul>
                <div id="tabs-1">
                    <?php $this->printPageContentView($page); ?>
                </div>
                <div id="tabs-2">
                    <h3>Configure Page Menu</h3>
                    <?php $this->printPageMenuView($page->menuid,$page->id); ?>
                </div>
                <div id="tabs-3">
                    <?php $this->printPageTemplateView($page); ?>
                </div>
                <div id="tabs-4">
                    <h3>Configure Page Settings</h3>
                    <?php $this->printPageSettingsView($page); ?>
                </div>
            </div>
            <script>
            $("#adminPagesTabs").tabs({
                active : $.cookie('activetab'),
                activate : function( event, ui ){
                    $.cookie( 'activetab', ui.newTab.index(),{
                        expires : 10
                    });
                }
            });
            
            </script>
            <?php
        
        } else {
            echo "no page selected";
        }
    }
    
}
?>