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
            case "editDomain":
                if (Context::hasRole("domains.edit")) {
                    DomainsModel::updateDomain(parent::get("id"), parent::post("domainName"), Context::getSiteId(), parent::post("domainTrackerScript"));
                }
                break;
            case "deleteDomain":
                if (Context::hasRole("domains.edit")) {
                    DomainsModel::deleteDomain(parent::get("id"));
                }
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
                    $this->renderMainTabs();
                }
        }
    }
    
    function getRoles() {
        return array("domains.edit","domains.view");
    }
    
    function renderMainTabs () {
        ?>
        <div class="panel adminDomainsPanel">
            <div class="adminDomainTabs">
                <ul>
                    <li><a href="#adminDomains"><?php echo parent::getTranslation("admin.domains.domains"); ?></a></li>
                </ul>
                <div id="adminDomains">
                    <?php $this->renderMainView(); ?>
                </div>
            </div>
        </div>
        <script>
        $(".adminDomainTabs").tabs();
        </script>
        <?php
    }
    
    function renderRegisterTabs () {
        ?>
        <div class="panel adminDomainsPanel">
            <div class="adminDomainTabs">
                <ul>
                    <li><a href="#adminDomains"><?php echo parent::getTranslation("admin.domains.domains"); ?></a></li>
                    <li><a href="#adminRegisterDomains"><?php echo parent::getTranslation("admin.domains.register"); ?></a></li>
                </ul>
                <div id="adminDomains">
                    <?php $this->renderMainView(); ?>
                </div>
                <div id="adminRegisterDomains">
                    <?php $this->renderRegisterView(); ?>
                </div>
            </div>
        </div>
        <script>
        $(".adminDomainTabs").tabs({
            active : 1
        });
        </script>
        <?php
    }
    
    function renderEditTabs ($domain) {
        ?>
        <div class="panel adminDomainsPanel">
            <div class="adminDomainTabs">
                <ul>
                    <li><a href="#adminDomains"><?php echo parent::getTranslation("admin.domains.domains"); ?></a></li>
                    <li><a href="#adminEditDomains"><?php echo parent::getTranslation("admin.domains.edit"); ?></a></li>
                </ul>
                <div id="adminDomains">
                    <?php $this->renderMainView(); ?>
                </div>
                <div id="adminEditDomains">
                    <?php $this->renderEditView($domain); ?>
                </div>
            </div>
        </div>
        <script>
        $(".adminDomainTabs").tabs({
            active : 1
        });
        </script>
        <?php
    }
    
    function renderEditView ($domain) {
        ?>
        <h3><?php echo parent::getTranslation("admin.domains.register"); ?></h3>
        <form method="post" action="<?php echo parent::link(array("action"=>"editDomain","id"=>$domain->id)) ?>">
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
    
    function renderRegisterView () {
        ?>
        <h3><?php echo parent::getTranslation("admin.domains.register"); ?></h3>
        <form method="post" action="<?php echo parent::link(array("action"=>"createDomain")) ?>">
            <table class="formTable"><tr><td>
                <label for="domainName"><?php echo parent::getTranslation("admin.domains.register.name"); ?></label>
            </td><td>
                <?php InputFeilds::printTextFeild("domainName"); ?>
            </td></tr><tr><td>
                <label for="domainTrackerScript"><?php echo parent::getTranslation("admin.domains.register.trackerScript"); ?></label>
            </td><td>
                <?php InputFeilds::printTextArea("domainTrackerScript"); ?>
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
        <h3><?php echo parent::getTranslation("admin.domains.domainsManager"); ?></h3>

        <table class="resultTable" cellspacing="0">
        <thead><tr>
            <td><?php echo parent::getTranslation("admin.domains.table.sitename"); ?></td>
            <td class="expand"><?php echo parent::getTranslation("admin.domains.table.domain"); ?></td>
            <td colspan="2"><?php echo parent::getTranslation("admin.domains.table.tools"); ?></td>
        </tr></thead>
        <tbody>
        <?php
        
        foreach ($domains as $domain) {
            ?>
            <tr>
                <td><?php echo $domain->name; ?></td>
                <td><?php echo $domain->url; ?></td>
                <td><a href="<?php echo parent::link(array("action"=>"editDomain","id"=>$domain->id)); ?>"><img src="resource/img/preferences.png" alt="" /></a></td>
                <td><img src="resource/img/delete.png" alt="" onclick="doIfConfirm('<?php echo parent::getTranslation("admin.domains.confirm.delete"); ?>','<?php echo parent::link(array("action"=>"deleteDomain","id"=>$domain->id),false); ?>');" /></td>
            </tr>
            <?php
        }
        
        ?>
        </tbody></table>
        
        <hr/>
        <div class="alignRight">
            <button class="addDomain"><?php echo parent::getTranslation("admin.domains.addDomain"); ?></button>
        </div>
        
        <script type="text/javascript">
        $(".adminDomainsPanel .alignRight .addDomain").button().click(function(){
            callUrl("<?php echo parent::link(array("action"=>"addDomain"), false) ?>");
        });
        </script>
        <?php
    }
    
}

?>