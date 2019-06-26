<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of navigationController
 *
 * @author vbms
 */
class NavigationController {
     
    static function selectPage () {
        
        Context::setModuleId(null);
        $page = null;
        
        if (isset($_GET['moduleid'])) {
            Context::setModuleId($_GET['moduleid']);
            $page = PagesModel::getPageByModuleId($_GET['moduleid'],Context::getLang());
            NavigationModel::addToHistory();
        } else if (isset($_GET['pageid'])) {
            $page = PagesModel::getPage($_GET['pageid'],Context::getLang());
            NavigationModel::addToHistory();
            NavigationModel::clearSecureLinks();
        } else if (isset($_GET['p']) && isset($_GET['n'])) {
            $page = PagesModel::getPage($_GET['p'],Context::getLang(),true,$_GET['n']);
            NavigationModel::addToHistory();
            NavigationModel::clearSecureLinks();
        } else if (isset($_GET['static'])) {
            $page = PagesModel::getStaticPage($_GET['static'], Context::getLang());
            Context::setModuleId($page->codeid);
            NavigationModel::addToHistory();
        } else if (isset($_GET['moduleStatic'])) {
            $page = PagesModel::getModuleInstanceStaticPage($_GET['static'], $_GET["parentModuleId"], $_GET["templateId"], Context::getLang());
            Context::setModuleId($page->codeid);
            NavigationModel::addToHistory();
        } else if (isset($_GET['service'])) {
            Context::setService($_GET['service']);
        } else if (isset($_GET['templatePreview'])) {
            $page = PagesModel::getTemplatePreviewPage($_GET['templatePreview']);
        }/* else if (Context::isAdminMode()) {
            $page = PagesModel::getStaticPage(Context::isAdminMode(), Context::getLang());
            Context::setModuleId($page->codeid);
            NavigationModel::addToHistory();
        }*/
        
        /*
        // parse url request
        switch () {
        
        }
        
        */
        
        
        if (Context::getSiteId() == null) {
            $page = PagesModel::getStaticPage("unregistered", Context::getLang());
        } else if (!isset($_GET['service']) && $page == null) {
            // default to welcome page
            $page = PagesModel::getWelcomePage(Context::getLang());
            // if no welcome page take user to login
            if ($page == null) {
                $page = PagesModel::getStaticPage("login", Context::getLang());
            }
            // if no login page take user to setup
            if ($page == null) {
                $page = PagesModel::getStaticPage("startup", Context::getLang());
            }
        }
        
        return $page;
    }
     
}

?>
