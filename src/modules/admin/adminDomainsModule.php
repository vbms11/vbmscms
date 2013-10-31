<?php

require_once 'core/plugin.php';

class AdminDomainsModule extends XModule {
    
    function onProcess () {
        
        switch (parent::getAction()) {
            
        }
    }
    
    function onView () {
        
        switch (parent::getAction()) {
            case "addDomain":
                
                $this->renderRegisterTabs();
                break;
                
            default:
                $this->renderMainTabs();
        }
    }
    
    static function getTranslations() {
        return array("en" => array(
            "admin.domains.register"            => "Register Domain",
            "admin.domains.register.save"       => "Save",
            "admin.domains.domains"             => "Domains",
            "admin.domains.addDomain"           => "Add Domain",
            "admin.domains.domainsManager"	=> "Domains Manager",
            "admin.domains.table.domain"	=> "Domain",
            "admin.domains.table.sitename"	=> "Site Name",
            "admin.domains.table.tools"         => "Tools"
        ),"de" => array(
            "admin.domains.register"            => "Register Domain",
            "admin.domains.register.save"       => "Save",
            "admin.domains.domains"             => "Domains",
            "admin.domains.addDomain"           => "Add Domain",
            "admin.domains.domainsManager"	=> "Domains Manager",
            "admin.domains.table.domain"	=> "Domain",
            "admin.domains.table.sitename"	=> "Site Name",
            "admin.domains.table.tools"         => "Tools"
        ));
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
    
    function renderRegisterView () {
        ?>
        <h3><?php echo parent::getTranslation("admin.domains.register"); ?></h3>
        <label for="domainName"><?php echo parent::getTranslation("admin.domains.register.name"); ?></label>
        <input type="text" name="domainName" value="" />
        <hr/>
        <button id="registerDomain">
            <?php echo parent::getTranslation("admin.domains.register.save"); ?>
        </button>
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
            <td><?php echo parent::getTranslation("admin.domains.table.tools"); ?></td>
        </tr></thead>
        <tbody>
        <?php
        
        foreach ($domains as $domain) {
            ?>
            <tr>
                <td><?php echo $domain->name; ?></td>
                <td><?php echo $domain->url; ?></td>
                <td></td>
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