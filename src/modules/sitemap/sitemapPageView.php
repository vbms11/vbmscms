<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('core/plugin.php');
require_once("core/model/pagesModel.php");


class SitemapPageView extends XModule {

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {
        
        $this->printMainView(parent::getId());
    }

    /**
     * returns style sheets used by this module
     */
    function getStyles () {

    }

    /**
     * returns scripts used by this module
     */
    function getScripts () {

    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("sitemap.edit");
    }

    /**
     * returns search results for given text
     */
    function search ($searchText, $lang) {
        
    }

    function getRequestVars () {
        if (isset($_GET['action']))
            $this->action = $_GET['action'];
    }

    function printMainView ($pageId) {
        ?>
        <div class="panel wysiwygPage">
            <?php
            $pagesInMenus = MenuModel::getPagesInMenu();
            foreach ($pagesInMenus as $menus) {
                $this->printMenu($menus);
            }
            ?>
        </div>
        <?php
    }

    function printMenu ($menu) {
        echo '<ul>';
        foreach ($menu as $page) {
            ?>
            <li><a href="<?php echo NavigationModel::createPageLink($page->page->id); ?>"><?php echo $page->page->name; ?></a></li>
            <?php
            if (isset($page->children)) {
                $this->printMenu ($page->children);
            }
        }
        echo '</ul>';
    }
}

?>