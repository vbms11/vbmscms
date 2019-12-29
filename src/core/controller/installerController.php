<?php

require_once('core/plugin.php');

class InstallerController {
    
    static $installTypesPath = "core/model/install/setups";
    
    static function createInstaller () {
        
    }
    
    static function deleteInstallType ($filename) {
        
        $types = self::getInstallTypes();
        foreach ($types as $type) {
            if ($type->filename == $filename) {
                unlink(self::$installTypesPath."/".$filename);
            }
        }
    }
    
    static function createInstallType ($filename, $name, $description) {
        
        $content = "<installType>".PHP_EOL;
        $content .= "<name>".htmlentities($name)."</name>".PHP_EOL;
        $content .= "<description>".htmlentities($description)."</description>".PHP_EOL;
        $content .= "<sql>".htmlentities(BackupModel::getDatabaseSql(true))."</sql>";
        $content .= "</installType>";
        
        $handle = fopen(self::$installTypesPath."/".$filename,'w+');
        fwrite($handle,$content);
        fclose($handle);
    }
    
    static function doseInstallTypeFileExist ($filename) {
        
        return is_file(self::$installTypesPath."/".$filename);
    }
    
    static function getInstallTypes () {
        
        $setups = array();
        if ($handle = opendir(self::$installTypesPath)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    if (!Common::endsWith($entry, ".xml")) {
                        continue;
                    }
                    $setups []= self::getInstallType($entry);
                }
            }
        }
        return $setups;
    }
    
    static function getInstallType ($filename) {
        
        $doc = new DOMDocument();
        $doc->loadXML(self::$installTypesPath."/".$filename);
        $setup = stdClass;
        $setup->name = html_entity_decode($doc->getElementsByTagName("name")[0]->nodeValue);
        $setup->description = html_entity_decode($doc->getElementsByTagName("description")[0]->nodeValue);
        $setup->sql = html_entity_decode($doc->getElementsByTagName("sql")[0]->nodeValue);
        $setup->filename = $filename;
        return $setup;
    }
    
    static function confirmInstall () {
        
        self::buildConfig(null,null,null,null,null,true);
    }
    
    static function buildConfig ($hostname=null,$username=null,$password=null,$database=null,$email=null,$installed=false) {
        
        $content  = '<?php'.PHP_EOL;
        // database config
        $content .= '$CONFIG[\'dbName\'] = \''.($installed ? Config::getDBName() : $database).'\';'.PHP_EOL;
        $content .= '$CONFIG[\'dbHost\'] = \''.($installed ? Config::getDBHost() : $hostname).'\';'.PHP_EOL;
        $content .= '$CONFIG[\'dbUser\'] = \''.($installed ? Config::getDBUser() : $username).'\';'.PHP_EOL;
        $content .= '$CONFIG[\'dbPass\'] = \''.($installed ? Config::getDBPassword() : $password).'\';'.PHP_EOL;
        $content .= '$CONFIG[\'dbTablePrefix\'] = \'t_\';'.PHP_EOL;
        $content .= '$CONFIG[\'cmsDbDateFormat\'] = \'\';'.PHP_EOL;
        $content .= '$CONFIG[\'cmsUiDateFormat\'] = \'\';'.PHP_EOL;

        // session config
        $content .= '$CONFIG[\'cmsSessionExpireTime\'] = 60;'.PHP_EOL;

        // resource config
        $content .= '$CONFIG[\'resourcePath\'] = \'files/\';'.PHP_EOL;

        // cms info
        $content .= '$CONFIG[\'cmsName\'] = \'vbmscms\';'.PHP_EOL;
        $content .= '$CONFIG[\'cmsVersion\'] = \'0.5\';'.PHP_EOL;
        $content .= '$CONFIG[\'cmsLicese\'] = \'\';'.PHP_EOL;
        $content .= '$CONFIG[\'cmsSecureLink\'] = true;'.PHP_EOL;
        $content .= '$CONFIG[\'cmsMainDomain\'] = \''.DomainsModel::getDomainName().'\';'.PHP_EOL;
        
        // crypto configs
        $content .= '$CONFIG[\'serverSecret\'] = \''.($installed ? Config::getServerSecret() : self::generateServerSecret()).'\';'.PHP_EOL;
        $content .= '$CONFIG[\'serverPublicKey\'] = \'\';'.PHP_EOL;
        $content .= '$CONFIG[\'serverPrivateKey\'] = \'\';'.PHP_EOL;
        
        // log config
        $content .= '$CONFIG[\'queryLog\'] = false;'.PHP_EOL;
        
        // shop config
        $content .= '$CONFIG[\'currencySymbol\'] = \'&euro;\';'.PHP_EOL;
        $content .= '$CONFIG[\'weightUnit\'] = \'kg\';'.PHP_EOL;
        $content .= '$CONFIG[\'weightInGram\'] = \'1000\';'.PHP_EOL;

        $content .= '$CONFIG[\'seoUrl\'] = false;'.PHP_EOL;
        $content .= '$CONFIG[\'cmsAdminEmail\'] = \''.($installed ? Config::getCmsAdminEmail() : $email).'\';'.PHP_EOL;
        $content .= '$CONFIG[\'installed\'] = '.($installed ? 'true' : 'false').';'.PHP_EOL;
        
        $content .= "?>";

        // write config file
        file_put_contents("config.php",$content);
    }

    static function generateServerSecret () {
        return Common::randHash(128);
    }

    static function installModel ($filename) {
        
        $setup = file_get_contents(self::$installTypesPath."/".$filename);
        
        // installs the datamodel
        $sqlFileParts = explode(";",$setup);
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
            RolesModel::saveRole(null, $customRole->id, $initialUserId, $customRole->id, $siteId);
        }
        
        // set cms customer userid
        CmsCustomerModel::setCmsCustomerUserId($cmsCustomerId, $initialUserId);
    }

}

?>