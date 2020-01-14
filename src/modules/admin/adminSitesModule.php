<?php

require_once 'core/plugin.php';
include_once 'core/model/cmsCustomerModel.php';
include_once 'core/model/sitesModel.php';

class AdminSitesModule extends XModule {
    
    function onProcess () {
        
        if (Context::hasRole("site.edit")) {
            switch (parent::getAction()) {
                case "createSite":
                    $customer = CmsCustomerModel::getCurrentCmsCustomer(Context::getUserId());
                    SiteModel::createSite(parent::post("siteName"), $customer->id, parent::post("siteDescription"), null, parent::post("siteTrackerScript"), parent::post("facebookAppId"), parent::post("facebookSecret"), parent::post("googleClientId"), parent::post("googleClientSecret"), parent::post("twitterKey"), parent::post("twitterSecret"));
                    parent::redirect();
                    break;
                case "updateSite":
                    SiteModel::updateSite(parent::get("id"), parent::post("siteName"), parent::post("siteDescription"), parent::post("siteTrackerScript"), parent::post("facebookAppId"), parent::post("facebookSecret"), parent::post("googleClientId"), parent::post("googleClientSecret"), parent::post("twitterKey"), parent::post("twitterSecret"));
                    Context::setSite(null);
                    parent::redirect();
                    break;
                case "deleteSite":
                    //TODO delete all site content
                    SiteModel::deleteSite(parent::get("id")); 
                    parent::redirect();
                    break;
                case "viewSite":
                    $siteId = parent::get("id");
                    //TODO validate cmsuseid
                    // $site = SitesModel::getSite($siteId);
                    // if (Context::getSite()->cmscustomerid == $site->cmscustomerid)
                    Context::setSiteId($siteId);
                    break;
                case "doExport":
                    $validation = array();
                    $filename = parent::post("filename");
                    $filename = basename($filename).".gz";
                    $path = Resource::getResourcePath("types",$filename);
                    if (is_file($path)) {
                        $validation["filename"] = "A file with that name already exists.";
                        parent::setMessages($validation);
                        parent::redirect(array("action"=>"export","id"=>parent::get("id")));
                    } else {
                        SiteController::exportSite(parent::get("id"),$path);
                        parent::redirect();
                    }
                    break;
                case "doImport":
                    $directory = Resource::getResourcePath("export/types");
                    $import = parent::post("filename");
                    if (in_array($import, FileSystem::getFiles($directory))) {
                        SiteController::importSiteCopy($directory."/".$import);
                    }
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
            case "editSite":
                if (Context::hasRole("site.edit")) {
                    $site = SiteModel::getSite(parent::get("id"));
                    $this->renderEditTabs($site);
                }
                break;
            case "export":
                if (Context::hasRole("site.edit")) {
                    $this->renderExportView(parent::get("id"));
                }
                break;
            case "import":
                if (Context::hasRole("site.edit")) {
                    $this->renderImportView();
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
    
    function renderEditTabs ($site) {
        ?>
        <div class="panel adminSitesPanel">
            <div class="adminSitesTabs">
                <ul>
                    <li><a href="#adminSitesTab"><?php echo parent::getTranslation("admin.sites.tab.label"); ?></a></li>
                    <li><a href="#adminSitesEditTab"><?php echo parent::getTranslation("admin.sites.tab.edit"); ?></a></li>
                </ul>
                <div id="adminSitesTab">
                    <?php $this->renderMainView(); ?>
                </div>
                <div id="adminSitesEditTab">
                    <?php $this->renderEditView($site); ?>
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
    
    function renderEditView ($site) {
        ?>
        <h3><?php echo parent::getTranslation("admin.sites.title.create"); ?></h3>
        <form method="post" action="<?php echo parent::link(array("action"=>"updateSite","id"=>$site->id)); ?>">
            <table class="formTable"><tr><td>
                <label for="siteName"><?php echo parent::getTranslation("admin.sites.label.name"); ?></label>
            </td><td>
                <?php InputFeilds::printTextFeild("siteName", $site->name); ?>
            </td></tr><tr><td>
                <label for="siteDescription"><?php echo parent::getTranslation("admin.sites.label.description"); ?></label>
            </td><td>
                <?php InputFeilds::printTextArea("siteDescription", $site->description); ?>
            </td></tr><tr><td>
                <label for="siteTrackerScript"><?php echo parent::getTranslation("admin.sites.label.trackerScript"); ?></label>
            </td><td>
                <?php InputFeilds::printTextArea("siteTrackerScript", $site->sitetrackerscript); ?>
            </td></tr><tr><td>
                <label for="facebookAppId"><?php echo parent::getTranslation("admin.sites.label.facebookAppId"); ?></label>
            </td><td>
                <?php InputFeilds::printTextFeild("facebookAppId", $site->facebookappid); ?>
            </td></tr><tr><td>
                <label for="facebookSecret"><?php echo parent::getTranslation("admin.sites.label.facebookSecret"); ?></label>
            </td><td>
                <?php InputFeilds::printTextFeild("facebookSecret", $site->facebooksecret); ?>
            </td></tr><tr><td>
                <label for="googleClientId"><?php echo parent::getTranslation("admin.sites.label.googleClientId"); ?></label>
            </td><td>
                <?php InputFeilds::printTextFeild("googleClientId", $site->googleclientid); ?>
            </td></tr><tr><td>
                <label for="googleClientSecret"><?php echo parent::getTranslation("admin.sites.label.googleClientSecret"); ?></label>
            </td><td>
                <?php InputFeilds::printTextFeild("googleClientSecret", $site->googleclientsecret); ?>
            </td></tr><tr><td>
                <label for="twitterKey"><?php echo parent::getTranslation("admin.sites.label.twitterKey"); ?></label>
            </td><td>
                <?php InputFeilds::printTextFeild("twitterKey", $site->twitterkey); ?>
            </td></tr><tr><td>
                <label for="twitterSecret"><?php echo parent::getTranslation("admin.sites.label.twitterSecret"); ?></label>
            </td><td>
                <?php InputFeilds::printTextFeild("twitterSecret", $site->twittersecret); ?>
            </td></tr>
            </table>
            <hr/>
            <div class="alignRight">
                <button class="jquiButton" id="registerSite">
                    <?php echo parent::getTranslation("admin.sites.create.save"); ?>
                </button>
            </div>
        </form>
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
            </td></tr><tr><td>
                <label for="siteTrackerScript"><?php echo parent::getTranslation("admin.sites.label.trackerScript"); ?></label>
            </td><td>
                <?php InputFeilds::printTextArea("siteTrackerScript"); ?>
            </td></tr><tr><td>
                <label for="facebookAppId"><?php echo parent::getTranslation("admin.sites.label.facebookAppId"); ?></label>
            </td><td>
                <?php InputFeilds::printTextFeild("facebookAppId"); ?>
            </td></tr><tr><td>
                <label for="facebookSecret"><?php echo parent::getTranslation("admin.sites.label.facebookSecret"); ?></label>
            </td><td>
                <?php InputFeilds::printTextFeild("facebookSecret"); ?>
            </td></tr><tr><td>
                <label for="googleClientId"><?php echo parent::getTranslation("admin.sites.label.googleClientId"); ?></label>
            </td><td>
                <?php InputFeilds::printTextFeild("googleClientId"); ?>
            </td></tr><tr><td>
                <label for="googleClientSecret"><?php echo parent::getTranslation("admin.sites.label.googleClientSecret"); ?></label>
            </td><td>
                <?php InputFeilds::printTextFeild("googleClientSecret"); ?>
            </td></tr><tr><td>
                <label for="twitterKey"><?php echo parent::getTranslation("admin.sites.label.twitterKey"); ?></label>
            </td><td>
                <?php InputFeilds::printTextFeild("twitterKey"); ?>
            </td></tr><tr><td>
                <label for="twitterSecret"><?php echo parent::getTranslation("admin.sites.label.twitterSecret"); ?></label>
            </td><td>
                <?php InputFeilds::printTextFeild("twitterSecret"); ?>
            </td></tr>
            </table>
            <hr/>
            <div class="alignRight">
                <button class="jquiButton" id="registerSite">
                    <?php echo parent::getTranslation("admin.sites.create.save"); ?>
                </button>
            </div>
        </form>
        <?php
    }
    
    function renderExportView ($siteId) {
        
        ?>
        <h3><?php echo parent::getTranslation("admin.sites.title.export"); ?></h3>
        <form method="post" action="<?php echo parent::link(array("action"=>"doExport","id"=>$siteId)); ?>">
            <table class="formTable"><tr><td>
                <?php echo parent::getTranslation("admin.sites.label.title"); ?>
            </td><td>
                <?php 
                InputFeilds::printTextFeild("filename");
                if (parent::getMessage("filename") != null) {
                    echo '<span class="validateTips">'.parent::getMessage("filename").'</span>';
                }
                ?>
            </td></tr></table>
            <hr/>
            <div class="alignRight">
                <button class="jquiButton" type="submit">
                    <?php echo parent::getTranslation("admin.sites.export"); ?>
                </button>
            </div>
        </form>
        <?php
    }
    
    function renderImportView () {
        $files = Common::toMap(FileSystem::getFiles(Resource::getResourcePath("types")));
        ?>
        <h3><?php echo parent::getTranslation("admin.sites.title.import"); ?></h3>
        <form method="post" action="<?php echo parent::link(array("action"=>"doImport")); ?>">
            <table class="formTable"><tr><td>
                <?php echo parent::getTranslation("admin.sites.label.file"); ?>
            </td><td>
                <?php 
                InputFeilds::printSelect("filename",null,$files);
                ?>
            </td></tr></table>
            <hr/>
            <div class="alignRight">
                <button class="jquiButton" type="submit">
                    <?php echo parent::getTranslation("admin.sites.import"); ?>
                </button>
            </div>
        </form>
        <?php
    }
    
    function renderMainView() {
        ?>
        <h3><?php echo parent::getTranslation("admin.sites.title"); ?></h3>
        <?php
	$customer = CmsCustomerModel::getCurrentCmsCustomer();
        $sites = SiteModel::byCmscustomerid($customer->id);
        if (!empty($sites)) {

            ?>
            <table class="resultTable" cellspacing="0">
            <thead><tr>
                <td>ID</td>
                <td class="expand">Name</td>
                <td colspan="4">Tools</td>
            </tr></thead>
            <tbody>
            <?php

            foreach ($sites as $site) {
                ?>
                <tr>
                    <td><?php echo $site->id; ?></td>
                    <td><?php echo $site->name; ?></td>
                    <td><a href="<?php echo parent::link(array("action"=>"export","id"=>$site->id)); ?>">export</a></td>
                    <td><a href="<?php echo parent::link(array("action"=>"viewSite","id"=>$site->id),false); ?>"><img src="resource/img/view.png" alt="" /></a></td>
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
            <button class="btnImportSite"><?php echo parent::getTranslation("admin.sites.import "); ?></button>
        </div>
        <script type="text/javascript">
        $(".btnCreateSite").click(function () {
            callUrl("<?php echo parent::link(array("action"=>"newSite")); ?>");
        });
        $(".btnImportSite").click(function () {
            callUrl("<?php echo parent::link(array("action"=>"import")); ?>");
        });
        </script>
        <?php

    }
    
}
