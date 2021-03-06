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
        
        $this->printMainView();
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

    function printMainView () {
        ?>
        <div class="panel siteMapPanel">
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
	if (count($menu) > 0) {        
	echo '<ul>';
        foreach ($menu as $page) {
            ?>
            <li><a href="<?php echo NavigationModel::createPageNameLink($page->page->name, $page->page->id); ?>">
		<?php echo htmlentities($page->page->name); ?>
            </a>
            <?php
            if (isset($page->children)) {
                $this->printMenu ($page->children);
            }
            ?>            
            </li>
            <?php          
        }
        echo '</ul>';
	}
    }
}

?>
