<?php

include_once 'core/plugin.php';

class PiwikModel {
    
    static $authToken = null;
    static $piwikUrlPath = "/modules/statistics/piwik/";
    static $piwikUrl = "index.php?module=API&format=JSON";
    
    static function getCmsCustomerUserName ($cmsCustomerId) {
        return "cmsuser_".$cmsCustomerId;
    }
    
    static function callRemoteMethod ($name,$args) {
        $urlPath = NavigationModel::getSitePath().self::$piwikUrlPath;
        $url = self::$piwikUrl."&method=".$name."&token_auth=".self::getAdminAuthToken();
        foreach ($args as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $index => $val) {
                    $url .= "&".urlencode($key)."[$index]=".urlencode($val);
                }
            } else {
                $url .= "&".urlencode($key)."=".urlencode($value);
            }
        }
        $result = Http::getContent($urlPath.$url);
        return json_decode($result);
    }
    
    static function getAdminAuthToken () {
        if (empty(self::$authToken)) {
            $userLogin = Config::getPiwikUsername();
            $md5Password = md5(Config::getPiwikPassword());
            
            $urlPath = NavigationModel::getSitePath().self::$piwikUrlPath;
            $url = self::$piwikUrl."&method=UsersManager.getTokenAuth"
                    ."&userLogin=$userLogin&md5Password=$md5Password";
            $result = Http::getContent($urlPath.$url);
            $obj = json_decode($result);
            self::$authToken = $obj->value;
        }
        return self::$authToken;
    }
    
    static function getSite ($siteId) {
        $obj = self::callRemoteMethod("SitesManager.getSiteFromId", array("idSite"=>$siteId));
        if (is_array($obj) && isset($obj[0])) {
            $obj = $obj[0];
        } else {
            $obj = $obj->value;
        }
        return $obj;
    }
    
    static function createSite ($siteName, $urls) {
        $obj = self::callRemoteMethod("SitesManager.addSite", array("siteName"=>$siteName,"urls"=>$urls));
        return $obj->value;
    }
    
    static function getSiteUrls ($siteId) {
        $obj = self::callRemoteMethod("SitesManager.getSiteUrlsFromId", array("idSite"=>$siteId));
        return  $obj;
    }
    
    static function updateSite ($siteId, $siteName, $urls) {
        return self::callRemoteMethod("SitesManager.updateSite", array("idSite"=>$siteId,"siteName"=>$siteName,"urls"=>$urls));
    }
    
    static function deleteSite ($siteId) {
        return self::callRemoteMethod("SitesManager.deleteSite", array("idSite"=>$siteId));
    }
    
    static function addDomain ($siteId, $domain) {
        return self::callRemoteMethod("SitesManager.addSiteAliasUrls", array("idSite"=>$siteId,"urls"=>$domain));
    }
    
    static function removeDomain ($siteId, $domain) {
        if (strpos($domain, "http://") !== 0) {
            $domain = "http://".$domain;
        }
        $site = self::getSite($siteId);
        $urls = self::getSiteUrls($siteId);
        //todo add alias urls
        foreach ($urls as $key => $url) {
            if ($url === $domain) {
                unset($urls[$key]);
                break;
            }
        }
        return self::updateSite($siteId, $site->name, $urls);
    }
    
    static function setUserSites ($userName, $siteIds) {
        return self::callRemoteMethod("UsersManager.setUserAccess", array("userLogin"=>$userName,"access"=>"view","idSites"=>$siteIds));
    }
    
    static function getUserSites ($userName) {
        $objs = self::callRemoteMethod("UsersManager.getSitesAccessFromUser", array("userLogin"=>$userName));
        $sites = array();
        foreach ($objs as $obj) {
            $sites []= $obj->site;
        }
        return $sites;
    }
    
    static function createUser ($userName, $password, $email) {
        return self::callRemoteMethod("UsersManager.addUser", array("userLogin"=>$userName,"password"=>$password,"email"=>$email));
    }
    
    static function getUser ($userName) {
        return self::callRemoteMethod("UsersManager.getUser", array("userLogin"=>$userName));
    }
    
    static function updateUser ($userName, $password, $email) {
        return self::callRemoteMethod("UsersManager.updateUser", array("userLogin"=>$userName,"password"=>$password,"email"=>$email));
    }
    
    static function deleteUser ($userName) {
        return self::callRemoteMethod("UsersManager.deleteUser", array("userLogin"=>$userName));
    }
    
}

?>