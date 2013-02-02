<?php
require_once 'core/model/menuModel.php';

function printMenu ($menu) {
    foreach ($menu as $page) {
        ?>
        <url>
            <loc><?php echo NavigationModel::getSitePath().NavigationModel::createPageLink($page->page->id); ?></loc>
            <lastmod>2011-3-28</lastmod> 
            <changefreq>monthly</changefreq> 
            <priority>1.0</priority> 
        </url>
        <?php
        if (isset($page->children)) {
            $this->printMenu ($page->children);
        }
    }
}

echo '<?xml version="1.0" encoding="UTF-8" ?>'.PHP_EOL;
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php
    $pagesInMenus = MenuModel::getPagesInMenu();
    foreach ($pagesInMenus as $menus) {
        $this->printMenu($menus);
    }
    ?>
</urlset>
