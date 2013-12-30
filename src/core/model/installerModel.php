<?php

require_once('core/plugin.php');

class InstallerModel {
    
    static function createInstaller () {

    }


    static function buildConfig ($hostname,$username,$password,$database,$email) {
        
        $piwikPassword = Common::randHash();
        $piwikUsername = $username;
        
        $config  = '<?php'.PHP_EOL;
        // database config
        $config .= '$GLOBALS[\'dbName\'] = \''.$database.'\';'.PHP_EOL;
        $config .= '$GLOBALS[\'dbHost\'] = \''.$hostname.'\';'.PHP_EOL;
        $config .= '$GLOBALS[\'dbUser\'] = \''.$username.'\';'.PHP_EOL;
        $config .= '$GLOBALS[\'dbPass\'] = \''.$password.'\';'.PHP_EOL;
        $config .= '$GLOBALS[\'dbTablePrefix\'] = \'t_\';'.PHP_EOL;
        $config .= '$GLOBALS[\'cmsDbDateFormat\'] = \'\';'.PHP_EOL;
        $config .= '$GLOBALS[\'cmsUiDateFormat\'] = \'\';'.PHP_EOL;

        // session config
        $config .= '$GLOBALS[\'cmsSessionExpireTime\'] = 20*60*1000;'.PHP_EOL;

        // resource config
        $config .= '$GLOBALS[\'resourcePath\'] = \'files/\';'.PHP_EOL;

        // cms info
        $config .= '$GLOBALS[\'cmsName\'] = \'vbmscms\';'.PHP_EOL;
        $config .= '$GLOBALS[\'cmsVersion\'] = \'0.5\';'.PHP_EOL;
        $config .= '$GLOBALS[\'cmsLicese\'] = \'\';'.PHP_EOL;
        $config .= '$GLOBALS[\'cmsSecureLink\'] = true;'.PHP_EOL;
        $config .= '$GLOBALS[\'cmsMainDomain\'] = \''.DomainsModel::getDomainName().'\';'.PHP_EOL;
        
        // crypto configs
        $config .= '$GLOBALS[\'serverSecret\'] = \'';
        $config .= InstallerModel::generateServerSecret();
        $config .= '\';'.PHP_EOL;
        $config .= '$GLOBALS[\'serverPublicKey\'] = \'\';'.PHP_EOL;
        $config .= '$GLOBALS[\'serverPrivateKey\'] = \'\';'.PHP_EOL;

        // shop config
        $config .= '$GLOBALS[\'currencySymbol\'] = \'&euro;\';'.PHP_EOL;
        $config .= '$GLOBALS[\'weightUnit\'] = \'kg\';'.PHP_EOL;
        $config .= '$GLOBALS[\'weightInGram\'] = \'1000\';'.PHP_EOL;

        $config .= '$GLOBALS[\'seoUrl\'] = false;'.PHP_EOL;
        $config .= '$GLOBALS[\'piwikUsername\'] = \''.$piwikUsername.'\';'.PHP_EOL;
        $config .= '$GLOBALS[\'piwikPassword\'] = \''.$piwikPassword.'\';'.PHP_EOL;
        $config .= '$GLOBALS[\'cmsAdminEmail\'] = \'silkyfx@hotmail.de\';'.PHP_EOL;
        
        $config .= "?>";

        // write config file
        file_put_contents("config.php",$config);
        
        // write piwik config file
        $piwikConfig = '; <?php exit; ?> DO NOT REMOVE THIS LINE
; file automatically generated or modified by Piwik; you can manually override the default values in global.ini.php by redefining them in this file.
[database]
host = "'.$hostname.'"
username = "'.$username.'"
dbname = "'.$database.'"
password = "'.$password.'"
tables_prefix = "piwik_"
charset = "utf8"

[superuser]
login = "'.$piwikUsername.'"
password = "'.md5($piwikPassword).'"
email = "'.$email.'"
salt = "'.md5(Common::randHash()).'"

[PluginsInstalled]
PluginsInstalled[] = "Login"
PluginsInstalled[] = "CoreAdminHome"
PluginsInstalled[] = "UsersManager"
PluginsInstalled[] = "SitesManager"
PluginsInstalled[] = "Installation"
PluginsInstalled[] = "CorePluginsAdmin"
PluginsInstalled[] = "CoreHome"
PluginsInstalled[] = "Proxy"
PluginsInstalled[] = "API"
PluginsInstalled[] = "Widgetize"
PluginsInstalled[] = "Transitions"
PluginsInstalled[] = "LanguagesManager"
PluginsInstalled[] = "Actions"
PluginsInstalled[] = "Dashboard"
PluginsInstalled[] = "MultiSites"
PluginsInstalled[] = "Referers"
PluginsInstalled[] = "UserSettings"
PluginsInstalled[] = "Goals"
PluginsInstalled[] = "SEO"
PluginsInstalled[] = "UserCountry"
PluginsInstalled[] = "VisitsSummary"
PluginsInstalled[] = "VisitFrequency"
PluginsInstalled[] = "VisitTime"
PluginsInstalled[] = "VisitorInterest"
PluginsInstalled[] = "ExampleAPI"
PluginsInstalled[] = "ExamplePlugin"
PluginsInstalled[] = "ExampleRssWidget"
PluginsInstalled[] = "Provider"
PluginsInstalled[] = "Feedback"
PluginsInstalled[] = "CoreUpdater"
PluginsInstalled[] = "PDFReports"
PluginsInstalled[] = "UserCountryMap"
PluginsInstalled[] = "Live"
PluginsInstalled[] = "CustomVariables"
PluginsInstalled[] = "PrivacyManager"
PluginsInstalled[] = "ImageGraph"
PluginsInstalled[] = "DoNotTrack"
PluginsInstalled[] = "Annotations"
PluginsInstalled[] = "MobileMessaging"
PluginsInstalled[] = "Overlay"
PluginsInstalled[] = "SegmentEditor"';
        
        file_put_contents("modules/statistics/piwik/config/config.ini.php", $piwikConfig);
    }

    static function generateServerSecret () {
            $GLOBALS['serverSecret'] = "";
            return Common::randHash(128);
    }

    static function installModel () {
        $_SESSION['installProgress'] = "0";

        // installs the default datamodel
        $defaultModelSql = file_get_contents('core/model/defaultModel.php');
        $defaultModelParts = explode(";",$defaultModelSql);
        $parts = count($defaultModelParts) - 2;
        for ($i=1; $i<$parts; $i++) {
                Database::query($defaultModelParts[$i]);
                $_SESSION['installProgress'] = floor(($i / ($parts-1)) * 100)+"";
        }
    }

    static function createInitialUser ($username,$firstname,$lastname,$password,$email,$birthDate) {
        
        // create user
        $initialUserId = UsersModel::saveUser(null, $username, $firstname, $lastname, $password, $email, $birthDate, null);
        UsersModel::setUserActiveFlag($initialUserId,1);
        
        // add roles
        $customRoles = RolesModel::getCustomRoles();
        foreach ($customRoles as $customRole) {
            RolesModel::saveRole(null, $customRole->id, $initialUserId, $customRole->id);
        }
        
        // register cms customer
        $initialCustomerId = CmsCustomerModel::createCmsCustomer($initialUserId);
        
        // create inital site
        $siteId = SiteModel::createSite("vbmscms", $initialCustomerId, "vbmscms inital site", DomainsModel::getDomainName());
        
        // add templates
        $defaultTemplates = TemplateModel::getTemplates();
        foreach ($defaultTemplates as $template) {
            TemplateModel::addTemplate($siteId, $template->id, $template->main);
        }
        
    }

}

?>