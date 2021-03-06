<?php

require_once("core/plugin.php");
require_once("core/model/pagesModel.php");
require_once("core/model/moduleModel.php");
require_once("core/model/rolesModel.php");
require_once("modules/admin/adminPagesBaseModule.php");

class PageConfigModule extends AdminPagesBaseModule {

    function onProcess ()  {

        if (Context::hasRole("pages.editmenu")) {
            
            switch (parent::getAction()) {
                case "savepage":
                    $this->savePageAction();
                    // parent::redirect();
            }
        }

    }

    /**
     * called when page is viewed and html created
     */
    function onView () {

        if (Context::hasRole("pages.edit")) {
            $this->printEditPage();
        }
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("pages.editmenu","pages.edit");
    }

    function printEditPage () {

        $id = isset($_GET["id"]) ? $_GET["id"] : "";
        $page = null;
        if ($id != "") {
            $page = PagesModel::getPage($id, Context::getLang(), false);
        }
        
        ?>
        <div class="panel">
            <div class="pageConfigBackBtn">
                <?php
                if (isset($_GET['menuModuleId']) && !empty($_GET['menuModuleId'])) {
                    ?>
                    <button onclick="callUrl('<?php echo NavigationModel::createModuleLink($_GET['menuModuleId'],array("action"=>"edit","parent"=>$_GET['parent'])); ?>');" class="jquiButton"><?php echo parent::getTranslation("pageConfig.button.backToMenu"); ?></button>
                    <?php
                }
                if (!empty($id)) {
                    ?>
                    <button onclick="callUrl('<?php echo NavigationModel::createPageLink($id); ?>');" class="jquiButton"><?php echo parent::getTranslation("pageConfig.button.backToPage"); ?></button>
                    <?php
                }
                ?>
            </div>
            <div class="pageConfigPanel">
                <h3><a href="#pageConfigPanelSection1"><?php echo parent::getTranslation("pageConfig.label.configPage"); ?></a></h3>
                <div id="pageConfigPanelSection1">
                    <?php $this->printPageSettingsView($page); ?>
                </div>
            </div>
        </div>
        <script type="text/javascript">
        $(".pageConfigPanel").accordion({
                heightStyle: "content"
        });
        </script>
        <?php
    }
    
}
?>