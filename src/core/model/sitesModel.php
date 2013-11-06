<?php

class SiteModel {

    
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
    
    static function createSite ($name, $cmsCustomerId, $description) {
	$name = mysql_real_escape_string($name);
        $description = mysql_real_escape_string($description);
        $cmsCustomerId = mysql_real_escape_string($cmsCustomerId);
        Database::query("insert into t_site (name,cmscustomerid,description) values ('$name','$cmsCustomerId','$description')");
	$result = Database::queryAsObject("select last_insert_id() as newid from t_site");
        return $result->newid;
    }
    
    static function byCmscustomerid ($cmsCustomerId) {
        $cmsCustomerId = mysql_real_escape_string($cmsCustomerId);
        return Database::queryAsArray("select * from t_site where cmscustomerid = '$cmsCustomerId'");
    }
    
}

?>