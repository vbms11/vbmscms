<?php

class SiteController {
    
    const site_homepage = 1;
    const site_club = 2;
    const site_shop = 4;
    const site_forum = 5;
    const site_calendar = 6;
    
    static function saveSiteType ($siteId, $title, $description, $fileInputName) {
        
        $tmp_name = $_FILES[$fileInputName]["tmp_name"];
        $name = basename($_FILES[$fileInputName]["name"]);
        $path = Resource::getResourcePath("type");
        $randName = null;
        $ext = pathinfo($name)["extension"];
        do {
            $filename = Common::randHash(20,false);
        } while (!is_file("$path/$filename.$ext"));
        $imageFile = "$path/$filename.$ext";
        $siteArchive = "$path/$filename.gz";
        move_uploaded_file($tmp_name, $imageFile);
        self::exportSite($siteId, $siteArchive);
        
        SiteModel::createSiteType($title,$description,$imageFile,$siteArchive);
        SiteModel::deleteSiteType();
        SiteModel::getSiteTypes();
        
        
    }
    
    static function createSite ($name, $description, $siteTemplate, $cmsCustomerId) {
        
        // create inital site
        $siteId = SiteModel::createSite($name, $cmsCustomerId, $description);
        
        // create site user with roles
        $userId = CmsCustomerModel::getCmsCustomerUser($cmsCustomerId)->id;
        UsersModel::createSiteUser($userId, $siteId);
        $customRoles = RolesModel::getCustomRoles();
        foreach ($customRoles as $customRole) {
            RolesModel::saveRole(null, $customRole->id, $userId, $customRole->id, $siteId);
        }
        
        // set template pack
        SiteModel::setTemplatepackidById($siteId, $siteTemplate);
        
        return $siteId;
    }
    
    static function deleteSite ($siteId) {
        
        $serializer = new SiteSerializer($siteId);
        $serializer->deleteSite($siteId);
    }
    
    static function exportSite ($siteId, $archive) {
        
        $serializer = new SiteSerializer($siteId);
        $serializer->exportSite();
        $serializer->createArchive($archive);
    }
    
    static function importSite ($archive) {
        
        $serializer = new SiteSerializer();
        $serializer->loadArchive($archive);
        $serializer->importSite();
    }
    
    static function importSiteCopy ($archive) {
        
        $serializer = new SiteSerializer();
        $serializer->loadArchive($archive);
        $serializer->importCopySite();
    }
    
}