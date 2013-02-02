<?php

class DomainsModel {
    
    static function getDomains () {
        return Database::queryAsArray("select * from t_domain");
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
    
    static function createDomain ($url,$siteId = 1) {
        $url = mysql_real_escape_string($url);
        $siteId = mysql_real_escape_string($siteId);
        Database::query("insert into t_domain (url,siteid) values ('$url','$siteId')");
    }
    
    static function createSite ($siteName) {
        $siteName = mysql_real_escape_string($siteName);
        Database::query("insert into t_domain (name) values ('$siteName')");
        $result = Database::queryAsObject("select last_insert_id() as id from t_domain");
        return $result->id;
    }
}

?>