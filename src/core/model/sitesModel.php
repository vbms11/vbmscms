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
    
    static function createSite ($name,$id=null) {
	$insertId = "";
	if (id != null) {
		$insertId = ",'".mysql_real_escape_string($id)."'";
	}
        $name = mysql_real_escape_string($name);
        Database::query("insert into t_site ".(id != null ? "id" : "")." values ('$id'$insertId)");
	return Database::getLastInsertId();
    }
    
    static function createSite ($siteName) {
        $siteName = mysql_real_escape_string($siteName);
        Database::query("insert into t_site (name) values ('$siteName')");
        $result = Database::queryAsObject("select last_insert_id() as id from t_site");
        return $result->id;
    }
}

?>