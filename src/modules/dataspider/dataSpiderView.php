<?php

require_once 'core/plugin.php';
include_once 'modules/dataspider/dataSpiderModel.php';

class DataSpiderView extends XModule {

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {
        
        
        switch (parent::getAction()) {
            case "startSpider":
                if (Context::hasRole("spider.start")) {
                    DataSpiderModel::start();
                }
                break;
            case "":
                break;
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {
        
        switch (parent::getAction()) {
            case "startSpider":
                break;
            default:
                $this->printMainView(parent::getId());
        }
    }

    /**
     * called when page is destroyed
     */
    function destroy ($pageid) {

    }

    /**
     * called when module is installed
     */
    function install () {

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
        return array("spider.configure","spider.start","spider.view");
    }

    /**
     * returns search results for given text
     */
    function search ($searchText, $lang) {
        $wysiwygPageModel = new WysiwygPageModel();
        $searchResults = $wysiwygPageModel->search($searchText,Context::getLang());
        return $searchResults;
    }


    function getRequestVars () {
        if (isset($_GET['action']))
            $this->action = $_GET['action'];
    }

    function printMainView ($moduleId) {

        ?>
        <div class="panel">
            <button onclick="callUrl('<?php echo parent::link(array("action"=>"startSpider"),false); ?>');">Start Spider</button>
        </div>
        <?php
    }

    function printEditView ($pageId) {
        
        ?>
        <?php
    }
}

?>