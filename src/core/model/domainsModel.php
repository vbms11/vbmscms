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
        $domain = mysql_real_escape_string($domain);
        return Database::queryAsObject("select d.url, d.siteid from t_domain d where d.url = '$domain'");
    }
    
    static function getCurrentSite () {
        $site = DomainsModel::getDomainSite(DomainsModel::getDomainName());
        if ($site == null) {
            DomainsModel::createDomain(DomainsModel::getDomainName());
            return DomainsModel::getCurrentSite();
        }
        return $site;
    }
    
    static function getDomainName () {
        return $_SERVER['HTTP_HOST'];
    }
    
    static function getSubDomainUrl ($siteName) {
        return $siteName.".".Config::getCmsMainDomain();
    }
    
    static function createDomain ($url,$siteId = 1) {
        $url = mysql_real_escape_string($url);
        $siteId = mysql_real_escape_string($siteId);
        Database::query("insert into t_domain (url,siteid) values ('$url','$siteId')");
        $result = Database::queryAsObject("select last_insert_id() as id from t_domain");
        return $result->id;
    }
}

?>