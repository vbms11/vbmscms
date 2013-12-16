<?php

require_once('core/plugin.php');

class InstallerModel {
    
    static function createInstaller () {

    }


    static function buildConfig ($hostname,$username,$password,$database) {

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
        $config .= '$GLOBALS[\'cmsMainDomain\'] = \''.DomainsModel::getDomainName().'\'';
        
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

        
        $config .= '$GLOBALS[\'seoUrl\'] = true;'.PHP_EOL;
        $config .= '$GLOBALS[\'cmsMainDomain\'] = \'local-vbmscms\';'.PHP_EOL;
        $config .= '$GLOBALS[\'piwikUsername\'] = \'vbms\';'.PHP_EOL;
        $config .= '$GLOBALS[\'piwikPassword\'] = \'protected7\';'.PHP_EOL;
        $config .= '$GLOBALS[\'cmsAdminEmail\'] = \'silkyfx@hotmail.de\';'.PHP_EOL;
        
        
        $config .= "?>";

        // write config file
        file_put_contents("config.php",$config);
        
        // write piwik config file
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
        SiteModel::createSite("vbmscms", $initialCustomerId, "vbmscms inital site");
    }

}

?>