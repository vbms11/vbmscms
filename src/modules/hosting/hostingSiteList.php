<?php

require_once 'core/plugin.php';
include_once 'core/model/cmsCustomerModel.php';
include_once 'core/model/sitesModel.php';

class RegisterHostingModule extends XModule {
    
    function onProcess () {
        
        if (Context::hasRole("site.edit")) {
            switch (parent::getAction()) {
                case "update":
                    $content = $_POST['articleContent'];
                    WysiwygPageModel::updateWysiwygPage(parent::getId(),Context::getLang(),$content);
                    PagesModel::updateModifyDate();
                    parent::redirect();
                    parent::blur();
                    break;
                case "edit":
                    parent::focus();
                    break;
                case "registerCmsCustomer":
                    
                    $siteName = parent::post("siteName");
                    
                    if (strlen($siteName) < 100) {
                        
                    }
                    
                    $_SESSION["registerDomain.siteName"] = $siteName;
                    
                    if (Context::isLoggedIn()) {
                        CmsCustomerModel::createCmsCustomer(Context::getUserId());
                    } else {
                        NavigationModel::addStaticNextAction("registerHosting");
                        NavigationModel::redirectStaticModule("register");
                        break;
                    }
                
                    
                
                
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
    
    function renderEditView ($site) {
        ?>
        <h3><?php echo parent::getTranslation("admin.sites.title.create"); ?></h3>
        <form method="post" action="<?php echo parent::link(array("action"=>"updateSite","id"=>$site->id)); ?>">
            <table class="formTable"><tr><td>
                <label for="siteName"><?php echo parent::getTranslation("registerHosting.create.label.name"); ?></label>
            </td><td>
                <?php InputFeilds::printTextFeild("siteName", $site->name); ?>
            </td></tr><tr><td>
                <label for="siteDescription"><?php echo parent::getTranslation("admin.sites.label.description"); ?></label>
            </td><td>
                <?php InputFeilds::printTextArea("siteDescription", $site->description); ?>
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
    
    function renderMainView() {
        
            ?>
        <h3><?php echo parent::getTranslation("admin.sites.title.create"); ?></h3>
        <form method="post" action="<?php echo parent::link(array("action"=>"updateSite","id"=>$site->id)); ?>">
            <table class="formTable"><tr><td>
                <label for="siteDomain"><?php echo parent::getTranslation("registerHosting.siteName.label"); ?></label>
            </td><td>
                <?php InputFeilds::printTextFeild("siteDomain", "", null, parent::getTranslation("registerHosting.siteName.placehoder")); ?>
            </td></tr>
                <tr><td>
                <label for="siteName"><?php echo parent::getTranslation("registerHosting.create.label.name"); ?></label>
            </td><td>
                <?php InputFeilds::printTextFeild("siteName", $site->name); ?>
            </td></tr><tr><td>
                <label for="siteDescription"><?php echo parent::getTranslation("admin.sites.label.description"); ?></label>
            </td><td>
                <?php InputFeilds::printTextArea("siteDescription", $site->description); ?>
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

            foreach ($sites as $site) {
                ?>
                <tr>
                    <td><?php echo $site->id; ?></td>
                    <td><?php echo $site->name; ?></td>
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

    }
    
}
