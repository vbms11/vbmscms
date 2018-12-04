<?php

require_once('core/plugin.php');

class InstallerController {
    
    static function createInstaller () {
        
    }
    
    static function buildConfig ($hostname,$username,$password,$database,$email) {
        
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
        $config .= '$CONFIG[\'resourcePath\'] = \'files/\';'.PHP_EOL;

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
        
        // log config
        $config .= '$CONFIG[\'queryLog\'] = false;'.PHP_EOL;
        
        // shop config
        $config .= '$CONFIG[\'currencySymbol\'] = \'&euro;\';'.PHP_EOL;
        $config .= '$CONFIG[\'weightUnit\'] = \'kg\';'.PHP_EOL;
        $config .= '$CONFIG[\'weightInGram\'] = \'1000\';'.PHP_EOL;

        $config .= '$CONFIG[\'seoUrl\'] = false;'.PHP_EOL;
        $config .= '$CONFIG[\'cmsAdminEmail\'] = \''.$email.'\';'.PHP_EOL;
        
        $config .= "?>";

        // write config file
        file_put_contents("config.php",$config);
    }

    static function generateServerSecret () {
        return Common::randHash(128);
    }

    static function installModel ($setup) {

        // installs the datamodel
        self::executeSqlFile("core/model/install/setups/$setup");
        
    }
    
    static function executeSqlFile ($filename) {
        $sqlFileContent = file_get_contents($filename);
        $sqlFileParts = explode(";",$sqlFileContent);
        $parts = count($sqlFileParts) - 2;
        for ($i=1; $i<$parts; $i++) {
            Database::query($sqlFileParts[$i]);
        }
    }
    
    static function createInitialSite ($name, $description) {
        
        // register cms customer
        $initialCustomerId = CmsCustomerModel::createCmsCustomer();
        
        // create inital site
        $siteId = SiteModel::createSite($name, $initialCustomerId, $description, DomainsModel::getDomainName());
        
        // add templates
        $defaultTemplates = TemplateModel::getTemplates();
        foreach ($defaultTemplates as $template) {
            if (!empty($template->interface)) {
                continue;
            }
            TemplateModel::addTemplate($siteId, $template->id, $template->main);
        }
        
        return array("cmsCustomer"=>$initialCustomerId,"siteId"=>$siteId);
    }
    
    static function createInitialUser ($username,$firstname,$lastname,$password,$email,$birthDate,$gender,$cmsCustomerId,$siteId) {
        
        // create user
        $initialUserId = UsersModel::saveUser(null, $username, $firstname, $lastname, $password, $email, $birthDate, null, $gender, null, $siteId);
        UsersModel::setUserActiveFlag($initialUserId,1);
        
        // add roles
        $customRoles = RolesModel::getCustomRoles();
        foreach ($customRoles as $customRole) {
            RolesModel::saveRole(null, $customRole->id, $initialUserId, $customRole->id);
        }
        
        // set cms customer userid
        CmsCustomerModel::setCmsCustomerUserId($cmsCustomerId, $initialUserId);
    }
    
    static function createInstalledLockFile () {
        
        file_put_contents("install/locks/installed", "");
    }

}

?>