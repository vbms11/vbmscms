<?php

class SiteModel {
    
    static function getSite ($siteId) {
        $siteId = Database::escape($siteId);
        return Database::queryAsObject("select * from t_site where id = '$siteId'");
    }
    
    static function getSites () {
        return Database::queryAsArray("select * from t_site");
    }
    
    static function getSiteDomains ($site) {
        $site = Database::escape($site);
        return Database::queryAsObject("select d.url, s.* from t_site s join t_domain as d on s.id = d.siteid where d.id = '$site'");
    }
    
    static function getCurrentSite () {
	   return Context::getSiteId();
    }
    
    static function getSiteName () {
        return $_SERVER['HTTP_HOST'];
    }
    
    static function deleteSite ($siteId) {
        
        $siteId = Database::escape($siteId);
        
        Database::query("delete from t_site where id = '$siteId'");
        
    }
    
    static function createSite ($name, $cmsCustomerId, $description, $domain = null, $trackerScript = '', $facebookAppId = '', $facebookSecret = '', $googleClientId = '', $googleClientSecret = '', $twitterKey = '', $twitterSecret = '') {
        $name = Database::escape($name);
        $description = Database::escape($description);
        $cmsCustomerId = Database::escape($cmsCustomerId);
        $trackerScript = Database::escape($trackerScript);
        $facebookAppId = Database::escape($facebookAppId);
        $facebookSecret = Database::escape($facebookSecret);
        $twitterKey = Database::escape($twitterKey);
        $twitterSecret = Database::escape($twitterSecret);
        $googleClientId = Database::escape($googleClientId);
        $googleClientSecret = Database::escape($googleClientSecret);
        // 
        if (empty($domain)) {
            $defaultDomain = DomainsModel::getSubDomainUrl($name);
        } else {
            $defaultDomain = $domain;
        }
        
        Database::query("insert into t_site (name,cmscustomerid,description,sitetrackerscript,facebookappid,facebooksecret,twitterkey,twittersecret,googleclientid,googleclientsecret) values ('$name','$cmsCustomerId','$description','$trackerScript','$facebookAppId','$facebookSecret','$twitterKey','$twitterSecret','$googleClientId','$googleClientSecret')");
        $result = Database::queryAsObject("select max(id) as newid from t_site");
        
        DomainsModel::createDomain($defaultDomain, $result->newid);
        
        return $result->newid;
    }
    
    static function updateSite ($siteId, $name, $description, $trackerScript, $facebookAppId = '', $facebookSecret = '', $googleClientId = '', $googleClientSecret = '', $twitterKey = '', $twitterSecret = '') {
        $siteId = Database::escape($siteId);
        $name = Database::escape($name);
        $description = Database::escape($description);
        $trackerScript = Database::escape($trackerScript);
        $facebookAppId = Database::escape($facebookAppId);
        $facebookSecret = Database::escape($facebookSecret);
        $googleClientId = Database::escape($googleClientId);
        $googleClientSecret = Database::escape($googleClientSecret);
        $twitterKey = Database::escape($twitterKey);
        $twitterSecret = Database::escape($twitterSecret);
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
        $cmsCustomerId = Database::escape($cmsCustomerId);
        return Database::queryAsArray("select * from t_site where cmscustomerid = '$cmsCustomerId'");
    }
    
    static function setTemplatepackidById ($siteId, $templatePackId) {
        $siteId = Database::escape($siteId);
        $templatePackId = Database::escape($templatePackId);
        Database::query("update t_site set templatepackid = '$templatePackId' where id = '$siteId'");
        
    }
    
    function saveSiteType($id,$title,$description,$imageFile,$siteArchive) {
        $title = Database::escape($title);
        $description = Database::escape($description);
        $imageFile = Database::escape($imageFile);
        $siteArchive = Database::escape($siteArchive);
        if ($id != null) {
            $id = Database::escape($id);
            Database::query("update t_site_type set title = '$title', description = '$description', image = '$imageFile', archive = '$siteArchive' where id = '$id'");
        } else {
            Database::query("insert into t_site_type (title,description,image,archive) values ('$title','$description','$image','$archive')");
        }
    }
    
    function deleteSiteType ($id) {
        $id = Database::escape($id);
        Database::query("delete from t_site_type where id = '$id'");
    }
    
    function getSiteTypes () {
        return Database::queryAsArray("select * from t_site_type");
    }
    
}

?>
