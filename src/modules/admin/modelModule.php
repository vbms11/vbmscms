<?php

require_once 'core/plugin.php';

class AdminDomainsModule extends XModule {
    
    function onProcess () {
        
        switch (parent::getAction()) {
            case "createDomain":
                if (Context::hasRole("domains.edit")) {
                    DomainsModel::createDomain(parent::post("domainName"), Context::getSiteId(), parent::post("domainTrackerScript"));
                }
                break;
            case "editSaveDomain":
                if (Context::hasRole("domains.edit")) {
                    DomainsModel::updateDomain(parent::get("id"), parent::post("domainName"), Context::getSiteId(), parent::post("domainTrackerScript"));
                }
                break;
            case "deleteDomain":
                if (Context::hasRole("domains.edit")) {
                    DomainsModel::deleteDomain(parent::get("id"));
                }
                break;
            case "makeModelObjects":
                $DB->getObjectFactory()->generateClassesFromDatabase(__DIR__."/output/test/");
                break;
                
        }
    }
    
    function onView () {
        
        switch (parent::getAction()) {
            case "addDomain":
                if (Context::hasRole("domains.edit")) {
                    $this->renderRegisterTabs();
                }
                break;
            case "editDomain":
                if (Context::hasRole("domains.edit")) {
                    $domain = DomainsModel::getDomain(parent::get("id"));
                    $this->renderEditTabs($domain);
                }
                break;
            default:
                if (Context::hasRole("domains.view")) {
                    $this->renderMainView();
                }
        }
    }
    
    function getRoles() {
        return array("domains.edit","domains.view");
    }
    
    function renderEditView ($domain) {
        ?>
        <h3><?php echo parent::getTranslation("admin.domains.register"); ?></h3>
        <form method="post" action="<?php echo parent::link(array("action"=>"editSaveDomain","id"=>$domain->id)) ?>">
            <table class="formTable"><tr><td>
                <label for="domainName"><?php echo parent::getTranslation("admin.domains.register.name"); ?></label>
            </td><td>
                <?php InputFeilds::printTextFeild("domainName",$domain->url); ?>
            </td></tr><tr><td>
                <label for="domainTrackerScript"><?php echo parent::getTranslation("admin.domains.register.trackerScript"); ?></label>
            </td><td>
                <?php InputFeilds::printTextArea("domainTrackerScript",$domain->domaintrackerscript); ?>
            </td></tr></table>
            <hr/>
            <div class="alignRight">
                <button type="submit" id="registerDomain">
                    <?php echo parent::getTranslation("admin.domains.register.save"); ?>
                </button>
            </div>
        </form>
        <?php
    }
    
    function renderMainView() {
        
        
        
        
        $domains = DomainsModel::getDomains(Context::getSiteId());
        ?>
        <h3><?php echo parent::getTranslation("module.title"); ?></h3>
        <p><?php echo parent::getTranslation("module.description"); ?><p>
        <a href="<?php echo parent::link(array("action"=>"makeModelObjects")) ?>"><?php echo parent::getTranslation("module.button"); ?></button>
        
        <?php
    }
    
}

?>