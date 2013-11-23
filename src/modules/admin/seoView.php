<?php

require_once 'core/plugin.php';

class SeoView extends XModule {
    
    function onProcess () {
        
        switch (parent::getAction()) {
            case "robots.txt":
                $this->renderRobotsTxt();
                break;
            case "sitemap.xml":
                $this->renderSitemapXml();
                break;
            case "feed.rss":
                $this->renderRssXml();
                break;
        }
    }
    
    function onView () {
        
        switch (parent::getAction()) {
            
            default:
                $this->renderMainView();
        }
    }
    
    function renderMainView () {
        
    }
    
    function renderRobotsTxt () {
        echo "User-agent: *".PHP_EOL;
        echo "Allow: /".PHP_EOL;
        echo "dissallow: /core/*".PHP_EOL;
        echo "dissallow: /logs/*".PHP_EOL;
        echo "Sitemap: ".NavigationModel::getSitePath()."sitemap.xml".PHP_EOL;
    }
    
    function renderSitemapXml () {
        echo '<?xml version="1.0" encoding="UTF-8" ?>'.PHP_EOL;
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php
    $pagesInMenus = MenuModel::getPagesInMenu();
    foreach ($pagesInMenus as $menus) {
        $this->printMenuSitemap($menus);
    }
?>
</urlset>
<?php
    }
    
    function printMenuSitemap ($menu) {
        foreach ($menu as $page) {
?>
<url>
    <loc><?php echo NavigationModel::getSitePath().NavigationModel::createPageNameLink($page->page->name,$page->page->id); ?></loc>
    <lastmod><?php echo date('Y-m-dTH:i:sP', strtotime($page->page->modifydate)); ?></lastmod>
    <changefreq>monthly</changefreq>
    <priority>1.0</priority>
</url>
<?php
            if (isset($page->children)) {
                $this->printMenuSitemap ($page->children);
            }
        }
    }

    static function renderRssXml () {
        
        
    }
    
    
}

?>