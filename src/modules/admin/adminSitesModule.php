<?php

require_once 'core/plugin.php';
include_once 'core/model/cmsCustomerModel.php';
include_once 'core/model/sitesModel.php';

class AdminSitesModule extends XModule {
    
    function onProcess () {
        
        if (Context::hasRole("site.edit")) {
            switch (parent::getAction()) {
                case "createSite":
                    $customer = CmsCustomerModel::getCmsCustomer(Context::getUserId());
                    SiteModel::createSite(parent::post("siteName"), $customer->id, parent::post("siteDescription"));
                    
                    parent::redirect();
                    break;
            }
        }
    }
    
    function onView () {
        
        
        switch (parent::getAction()) {
            
            case "newSite":
                if (Context::hasRole("site.edit")) {
                    $this->renderCreateTabs();
                }
                break;
            default:
                if (Context::hasRole("site.view")) {
                    $this->renderMainTabs();
                }
        }
    }
    
    function getStyles () {
        return array("css/admin.css");
    }
    
    function getRoles () {
        return array("site.edit","site.view");
    }
    
    function renderEditSiteView ($siteId = null) {
        
        ?>
        <div class="panel">
            
            <script>
            $("#tabs").tabs({
                collapsible: true
            });
            $("#btnSubmit").button(function(){
                $("#<?php echo parent::alias("templatesForm"); ?>").submit();
            });
            $("#btnCacnel").button(function(){
                history.back();
            });
            </script>
        </div>
        <?php
    }
    
    function renderMainTabs () {
        ?>
        <div class="panel adminSitesPanel">
            <div class="adminSitesTabs">
                <ul>
                    <li><a href="#adminSitesTab"><?php echo parent::getTranslation("admin.sites.tab.label"); ?></a></li>
                </ul>
                <div id="adminSitesTab">
                    <?php $this->renderMainView(); ?>
                </div>
            </div>
        </div>
        <script type="text/javascript">
        $(".adminSitesTabs").tabs();
        </script>
        <?php
    }
    
    function renderCreateTabs () {
        ?>
        <div class="panel adminSitesPanel">
            <div class="adminSitesTabs">
                <ul>
                    <li><a href="#adminSitesTab"><?php echo parent::getTranslation("admin.sites.tab.label"); ?></a></li>
                    <li><a href="#adminSitesCreateTab"><?php echo parent::getTranslation("admin.sites.tab.create"); ?></a></li>
                </ul>
                <div id="adminSitesTab">
                    <?php $this->renderMainView(); ?>
                </div>
                <div id="adminSitesCreateTab">
                    <?php $this->renderCreateView(); ?>
                </div>
            </div>
        </div>
        <script type="text/javascript">
        $(".adminSitesTabs").tabs({
            active : 1
        });
        </script>
        <?php
    }
    
    function renderCreateView () {
        ?>
        <h3><?php echo parent::getTranslation("admin.sites.title.create"); ?></h3>
        <form method="post" action="<?php echo parent::link(array("action"=>"createSite")); ?>">
            <table class="formTable"><tr><td>
                <label for="siteName"><?php echo parent::getTranslation("admin.sites.label.name"); ?></label>
            </td><td>
                <?php InputFeilds::printTextFeild("siteName"); ?>
            </td></tr><tr><td>
                <label for="siteDescription"><?php echo parent::getTranslation("admin.sites.label.description"); ?></label>
            </td><td>
                <?php InputFeilds::printTextArea("siteDescription"); ?>
            </td></tr></table>
            <hr/>
            <div class="alignRight">
                <button class="jquiButton" id="registerSite">
                    <?php echo parent::getTranslation("admin.sites.create.save"); ?>
                </button>
            </div>
        </form>
        <?php
    }
    
    function renderMainView() {
        ?>
        <h3><?php echo parent::getTranslation("admin.sites.title"); ?></h3>

        <?php
        $customer = CmsCustomerModel::getCmsCustomer(Context::getUserId());
        $sites = SiteModel::byCmscustomerid($customer->id);

        if (!empty($sites)) {

            ?>
            <table class="resultTable" cellspacing="0">
            <thead><tr>
                <td>ID</td>
                <td class="expand">Name</td>
                <td colspan="2">Tools</td>
            </tr></thead>
            <tbody>
            <?php

            foreach ($sites as $site) {
                ?>
                <tr>
                    <td><?php echo $site->id; ?></td>
                    <td><?php echo $site->name; ?></td>
                    <td><a href="<?php echo parent::link(array("action"=>"editSite","id"=>$site->id)); ?>"><img src="resource/img/preferences.png" alt="" /></a></td>
                    <td><img src="resource/img/delete.png" alt="" onclick="doIfConfirm('<?php echo parent::getTranslation("admin.sites.confirm.delete"); ?>','<?php echo parent::link(array("action"=>"deleteSite","id"=>$site->id),false); ?>');" /></td>
                </tr>
                <?php
            }

            ?>
            </tbody></table>
            <?php
        }

        ?>

        <hr/>
        <div class="alignRight">
            <button class="btnCreateSite"><?php echo parent::getTranslation("admin.sites.create"); ?></button>
        </div>
        <script type="text/javascript">
        $(".btnCreateSite").each(function (index,object) {
            $(object).button().click(function () {
                callUrl("<?php echo parent::link(array("action"=>"newSite")); ?>");
            });
        });
        </script>
        <?php
    }
    
}

?>