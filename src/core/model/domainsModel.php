<?php

class DomainsModel {
    
    static function getDomains ($siteId = null) {
        if ($siteId != null) {
            $siteId = mysql_real_escape_string($siteId);
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
        $sqlDomain = mysql_real_escape_string($cleanDomain);
        return Database::queryAsObject("select d.url, d.siteid from t_domain d where d.url = '$sqlDomain'");
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
    
    static function createDomain ($url,$siteId = null) {
        if ($siteId == null) {
            $siteId = Context::getSiteId();
        }
        $cleanUrl = self::cleanDomainName($url);
        $site = SiteModel::getSite($siteId);
        PiwikModel::addDomain($site->piwikid, $cleanUrl);
        $sqlUrl = mysql_real_escape_string($cleanUrl);
        $siteId = mysql_real_escape_string($siteId);
        Database::query("insert into t_domain (url,siteid) values ('$sqlUrl','$siteId')");
        $result = Database::queryAsObject("select last_insert_id() as id from t_domain");
        return $result->id;
    }
    
    static function deleteDomain ($id) {
        $domain = self::getDomain($id);
        $site = SiteModel::getSite($domain->siteid);
        PiwikModel::removeDomain($site->piwikid, $domain->url);
        $id = mysql_real_escape_string($id);
        Database::query("delete from t_domain where id = '$id'");
    }
}

?>