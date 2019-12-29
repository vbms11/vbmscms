<?php

require_once 'core/plugin.php';
include_once 'core/model/cmsCustomerModel.php';
include_once 'core/model/sitesModel.php';

class HostingCreateSiteModule extends XModule {
    
    function onProcess () {
        
        if (Context::hasRole("site.edit")) {
            switch (parent::getAction()) {
                case "update":
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
                    parent::redirect();
                    break;
                case "deleteSite":
                    parent::redirect();
                    break;
            }
        }
    }
    
    function onView () {
        
        switch (parent::getAction()) {
            
            case "edit":
                if (Context::hasRole("site.edit")) {
                    $this->renderEditView();
                }
                break;
            default:
                if (Context::hasRole("site.view")) {
                    $this->renderMainView();
                }
        }
    }
    
    function getStyles () {
        return array("css/admin.css");
    }
    
    function getRoles () {
        return array("createSite.edit","createSite.view");
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
