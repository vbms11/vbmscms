<?php

class DomainsModel {
    
    static function getDomain ($domainId) {
        $domainId = Database::escape($domainId);
        return Database::queryAsObject("select * from t_domain where id = '$domainId'");
    }
    
    static function getDomains ($siteId = null) {
        if ($siteId != null) {
            $siteId = Database::escape($siteId);
            return Database::queryAsArray("select d.id, d.url, d.siteid, d.domaintrackerscript, s.name, s.sitetrackerscript 
                from t_domain d 
                left join t_site s on d.siteid = s.id 
                where d.siteid = '$siteId'");
        } else {
            return Database::queryAsArray("select * from t_domain");
        }
    }
    
    static function getDomainSite ($domain) {
        $cleanDomain = self::cleanDomainName($domain);
        $sqlDomain = Database::escape($cleanDomain);
        return Database::queryAsObject("select d.url, d.siteid, s.cmscustomerid, s.sitetrackerscript, s.templatepackid, d.domaintrackerscript, s.facebookappid, s.facebooksecret, s.googleclientid, s.googleclientsecret, s.twitterkey, s.twittersecret
            from t_domain d 
            join t_site s on s.id = d.siteid 
            where d.url = '$sqlDomain'");
    }
    
    static function getCurrentSite () {
        $site = DomainsModel::getDomainSite(DomainsModel::getDomainName());
        //if ($site == null) {
        //    DomainsModel::createDomain(DomainsModel::getDomainName());
        //    return DomainsModel::getCurrentSite();
        //}
        return $site;
    }
    
    static function cleanDomainName ($domainName) {
        if (strpos($domainName, "www." === 0)) {
            $domainName = substr($domainName, 4);
        }
        return $domainName;
    }
    
    static function getDomainName () {
        return self::cleanDomainName($_SERVER['HTTP_HOST']);
    }
    
    static function getSubDomainUrl ($siteName) {
        return $siteName.".".Config::getCmsMainDomain();
    }
    
    static function createDomain ($url, $siteId = null, $domainTrackerScript = '') {
        if ($siteId == null) {
            $siteId = Context::getSiteId();
        }
        $cleanUrl = self::cleanDomainName($url);
        $site = SiteModel::getSite($siteId);
        $sqlUrl = Database::escape($cleanUrl);
        $siteId = Database::escape($siteId);
        $domainTrackerScript = Database::escape($domainTrackerScript);
        Database::query("insert into t_domain (url,siteid,domaintrackerscript) values ('$sqlUrl','$siteId','$domainTrackerScript')");
        $result = Database::queryAsObject("select max(id) as id from t_domain");
        return $result->id;
    }
    
    static function updateDomain ($domainId, $url, $siteId = null, $domainTrackerScript = '') {
        $domainId = Database::escape($domainId);
        $domainTrackerScript = Database::escape($domainTrackerScript);
        $cleanUrl = self::cleanDomainName($url);
        $sqlUrl = Database::escape($cleanUrl);
        $originalUrl = self::getDomain($domainId);
        $site = SiteModel::getSite($siteId);
        $siteId = Database::escape($siteId);
        Database::query("update t_domain set
            url = '$sqlUrl',
            domaintrackerscript = '$domainTrackerScript'
            where id = '$domainId'");
    }
    
    static function deleteDomain ($id) {
        $id = Database::escape($id);
        Database::query("delete from t_domain where id = '$id'");
    }
}

?>