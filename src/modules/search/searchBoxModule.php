<?php

require_once 'core/plugin.php';

class SearchBoxModule extends XModule {

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {

        switch (parent::getAction()) {
            default:
                $this->printSearchBoxView();
        }
    }
    
    function getStyles () {
        return array("css/search.css");
    }

    static function getTranslations () {
        return array(
            "en" => array(
                "search.button" => "Search"
            ),
            "de" => array(
                "search.button" => "Suche"
            )
        );
    }

    function printSearchBoxView () {
        ?>
        <div class="panel searchBoxPanel">
            <form method="post" id="searchForm" name="searchForm" action="<?php echo NavigationModel::createStaticPageLink("search"); ?>">
                <table cellpadding="0"><tr><td class="contract searchButton">
                    <a href="" onclick="$('#searchForm').submit(); return false;"><?php echo parent::getTranslation("search.button"); ?></a>
                </td><td>
                    <input class="searchFeild" type="text" name="searchText" />
                </td></tr></table>
            </form>
        </div>
        <?php
    }
}

?>