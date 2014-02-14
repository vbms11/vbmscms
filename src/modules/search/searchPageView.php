<?php

require_once 'core/plugin.php';
require_once 'core/model/searchModel.php';

class SearchPageView extends XModule {

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
                $this->printSearchResultView();
        }
    }

    static function getTranslations () {
        return array(
            "en" => array(
                "search.top"    => "Your Search Result",
                "search.result" => "Your search for '%1%' has %2% results: "
            ),
            "de" => array(
                "search.top"    => "Ihre Suchergebnisse",
                "search.result" => "Ihre Suche nach '%1%' hat %2% Treffer ergeben: "
            ));
    }

    function printSearchResultView () {
        
        $searchText = null;
        if (isset($_POST['searchText']))
            $searchText = $_POST['searchText'];

        $searchResults = array();
        if ($searchText != null) {
            $searchResults = SearchModel::search($searchText);
        }

        ?>
        <div class="panel searchPage">
            <h3><?php echo parent::getTranslation("search.top"); ?></h3><br/>
            <?php
            $resultText = parent::getTranslation("search.result");
            $resultText = str_replace("%1%", $searchText, $resultText);
            $resultText = str_replace("%2%", count($searchResults), $resultText);
            echo $resultText;
            ?>
            <br/>
            <?php
            for ($i=0; $i<count($searchResults); $i++) {
                echo '<hr/>';
                echo ($i+1).'. ';
                echo '<a href="'.$searchResults[$i]->getLink().'">'.$searchResults[$i]->title.'</a><br/>';
                echo $searchResults[$i]->text;
            }
            ?>
            <hr/>
        </div>
        <?php
    }
}

?>