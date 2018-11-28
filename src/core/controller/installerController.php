<?php

require_once('core/plugin.php');

class InstallerController {
    
    static function createInstaller () {

    }


    static function buildConfig ($hostname,$username,$password,$database,$email) {
        
        $piwikPassword = Common::randHash();
        $piwikUsername = $username;
        
        $config  = '<?php'.PHP_EOL;
        // database config
        $config .= '$CONFIG[\'dbName\'] = \''.$database.'\';'.PHP_EOL;
        $config .= '$CONFIG[\'dbHost\'] = \''.$hostname.'\';'.PHP_EOL;
        $config .= '$CONFIG[\'dbUser\'] = \''.$username.'\';'.PHP_EOL;
        $config .= '$CONFIG[\'dbPass\'] = \''.$password.'\';'.PHP_EOL;
        $config .= '$CONFIG[\'dbTablePrefix\'] = \'t_\';'.PHP_EOL;
        $config .= '$CONFIG[\'cmsDbDateFormat\'] = \'\';'.PHP_EOL;
        $config .= '$CONFIG[\'cmsUiDateFormat\'] = \'\';'.PHP_EOL;

        // session config
        $config .= '$CONFIG[\'cmsSessionExpireTime\'] = 60;'.PHP_EOL;

        // resource config
        $config .= '$CONFIG[\'resourcePath\'] = \'files\';'.PHP_EOL;

        // cms info
        $config .= '$CONFIG[\'cmsName\'] = \'vbmscms\';'.PHP_EOL;
        $config .= '$CONFIG[\'cmsVersion\'] = \'0.5\';'.PHP_EOL;
        $config .= '$CONFIG[\'cmsLicese\'] = \'\';'.PHP_EOL;
        $config .= '$CONFIG[\'cmsSecureLink\'] = true;'.PHP_EOL;
        $config .= '$CONFIG[\'cmsMainDomain\'] = \''.DomainsModel::getDomainName().'\';'.PHP_EOL;
        
        // crypto configs
        $config .= '$CONFIG[\'serverSecret\'] = \'';
        $config .= self::generateServerSecret();
        $config .= '\';'.PHP_EOL;
        $config .= '$CONFIG[\'serverPublicKey\'] = \'\';'.PHP_EOL;
        $config .= '$CONFIG[\'serverPrivateKey\'] = \'\';'.PHP_EOL;

        // shop config
        $config .= '$CONFIG[\'currencySymbol\'] = \'&euro;\';'.PHP_EOL;
        $config .= '$CONFIG[\'weightUnit\'] = \'kg\';'.PHP_EOL;
        $config .= '$CONFIG[\'weightInGram\'] = \'1000\';'.PHP_EOL;

        $config .= '$CONFIG[\'seoUrl\'] = false;'.PHP_EOL;
        $config .= '$CONFIG[\'piwikUsername\'] = \''.$piwikUsername.'\';'.PHP_EOL;
        $config .= '$CONFIG[\'piwikPassword\'] = \''.$piwikPassword.'\';'.PHP_EOL;
        $config .= '$CONFIG[\'cmsAdminEmail\'] = \''.$email.'\';'.PHP_EOL;
        
        $config .= "?>";

        // write config file
        file_put_contents("config.php",$config);
        
        include_once("config.php");
        
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
            $CONFIG['serverSecret'] = "";
            return Common::randHash(128);
    }

    static function installModel () {
        $_SESSION['installProgress'] = "0";

        // installs the default datamodel
        self::executeSqlFile('core/model/install/defaultData.php');
        $_SESSION['installProgress'] = 50;
        
        self::executeSqlFile('core/model/install/piwikData.php');
        $_SESSION['installProgress'] = 100;
    }
    
    static function executeSqlFile ($filename) {
        $sqlFileContent = file_get_contents($filename);
        $sqlFileParts = explode(";",$sqlFileContent);
        $parts = count($sqlFileParts) - 2;
        for ($i=1; $i<$parts; $i++) {
            Database::query($sqlFileParts[$i]);
        }
    }

    static function createInitialUser ($username,$firstname,$lastname,$password,$email,$birthDate,$gender) {
        
        // create user
        $initialUserId = UsersModel::saveUser(null, $username, $firstname, $lastname, $password, $email, $birthDate, null, $gender);
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
            if (!empty($template->interface)) {
                continue;
            }
            TemplateModel::addTemplate($siteId, $template->id, $template->main);
        }
        
    }

}

?>