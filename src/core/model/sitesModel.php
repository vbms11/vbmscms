<?php

class SiteModel {
    
    static function getSite ($siteId) {
        $siteId = mysql_real_escape_string($siteId);
        return Database::queryAsObject("select * from t_site where id = '$siteId'");
    }
    
    static function getSites () {
        return Database::queryAsArray("select * from t_site");
    }
    
    static function getSiteDomains ($site) {
        $site = mysql_real_escape_string($site);
        return Database::queryAsObject("select d.url, s.* from t_site s join t_domain as d on s.id = d.siteid where d.id = '$site'");
    }
    
    static function getCurrentSite () {
	return Context::getSiteId();
    }
    
    static function getSiteName () {
        return $_SERVER['HTTP_HOST'];
    }
    
    static function deleteSite ($siteId) {
        
        $site = self::getSite($siteId);
        PiwikModel::deleteSite($site->piwikid);
        
        $siteId = mysql_real_escape_string($siteId);
        
        Database::query("delete from t_site where id = '$siteId'");
        
    }
    
    static function createSite ($name, $cmsCustomerId, $description, $domain = null, $trackerScript = '', $facebookAppId = '', $facebookSecret = '', $googleClientId = '', $googleClientSecret = '', $twitterKey = '', $twitterSecret = '') {
	$name = mysql_real_escape_string($name);
        $description = mysql_real_escape_string($description);
        $cmsCustomerId = mysql_real_escape_string($cmsCustomerId);
        $trackerScript = mysql_real_escape_string($trackerScript);
        $facebookAppId = mysql_real_escape_string($facebookAppId);
        $facebookSecret = mysql_real_escape_string($facebookSecret);
        $twitterKey = mysql_real_escape_string($twitterKey);
        $twitterSecret = mysql_real_escape_string($twitterSecret);
	$googleClientId = mysql_real_escape_string($googleClientId);
	$googleClientSecret = mysql_real_escape_string($googleClientSecret);
        // 
        if (empty($domain)) {
            $defaultDomain = DomainsModel::getSubDomainUrl($name);
        } else {
            $defaultDomain = $domain;
        }
        $piwikSiteId = PiwikModel::createSite($name, $defaultDomain);
        $piwikUser = PiwikModel::getCmsCustomerUserName($cmsCustomerId);
        $userSites = PiwikModel::getUserSites($piwikUser);
        PiwikModel::setUserSites($piwikUser, $userSites);
        
        Database::query("insert into t_site (name,cmscustomerid,description,piwikid,sitetrackerscript,facebookappid,facebooksecret,twitterkey,twittersecret,googleclientid,googleclientsecret) values ('$name','$cmsCustomerId','$description','$piwikSiteId','$trackerScript','$facebookAppId','$facebookSecret','$twitterKey','$twitterSecret','$googleClientId','$googleClientSecret')");
	$result = Database::queryAsObject("select last_insert_id() as newid from t_site");
        
        DomainsModel::createDomain($defaultDomain, $result->newid);
        
        return $result->newid;
    }
    
    static function updateSite ($siteId, $name, $description, $trackerScript, $facebookAppId = '', $facebookSecret = '', $googleClientId = '', $googleClientSecret = '', $twitterKey = '', $twitterSecret = '') {
        $siteId = mysql_real_escape_string($siteId);
        $name = mysql_real_escape_string($name);
        $description = mysql_real_escape_string($description);
        $trackerScript = mysql_real_escape_string($trackerScript);
        $facebookAppId = mysql_real_escape_string($facebookAppId);
        $facebookSecret = mysql_real_escape_string($facebookSecret);
        $googleClientId = mysql_real_escape_string($googleClientId);
        $googleClientSecret = mysql_real_escape_string($googleClientSecret);
        $twitterKey = mysql_real_escape_string($twitterKey);
        $twitterSecret = mysql_real_escape_string($twitterSecret);
        Database::query("update t_site set 
            name = '$name', 
            description = '$description', 
            sitetrackerscript = '$trackerScript', 
            facebookappid = '$facebookAppId', 
            facebooksecret = '$facebookSecret', 
            twitterkey = '$twitterKey', 
            twittersecret = '$twitterSecret', 
            googleclientid = '$googleClientId', 
            googleclientsecret = '$googleClientSecret' 
            where id = '$siteId'");
    }
    
    static function byCmscustomerid ($cmsCustomerId) {
        $cmsCustomerId = mysql_real_escape_string($cmsCustomerId);
        return Database::queryAsArray("select * from t_site where cmscustomerid = '$cmsCustomerId'");
    }
    
}

?>
