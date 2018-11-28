<?php

require_once('core/plugin.php');
require_once('modules/company/companyModel.php');
require_once('modules/company/companySearchBaseModule.php');

class CompanySearchResultModule extends CompanySearchBaseModule {
    
    function onProcess () {
        
        switch (parent::getAction()) {
            case "save":
                parent::blur();
                parent::redirect();
                break;
            default:
                break;
        }
    }
    
    function onView () {
        
        switch ($this->getAction()) {
            case "edit":
                if (Context::hasRole("company.search.edit")) {
                    $this->printEditView();
                }
                break;
            default:
                if (Context::hasRole("company.search.view")) {
                    $this->printSearchResultsView();
                }
                break;
        }
    }
    
    function getStyles () {
        return array("css/companySearch.css");
    }
    
    function getRoles () {
        return array("company.search.edit","company.search.view");
    }
    
    function printEditView () {
        ?>
        <div class="panel companyProfilePanel">
            <form action="<?php echo parent::link(array("action"=>"save")); ?>" method="post">
                <hr/>
                <div class="alignRight">
                    <button type="submit" class="jquiButton"><?php echo parent::getTranslation("common.save"); ?></button>
                </div>
            </form>
        </div>
        <?php
    }
    
    function printSearchResultsView () {
        $results = CompanyModel::find(parent::post("name"));
        $resultsPerPage = parent::getResultsPerPage();
      	
        ?>
        <h1><?php echo parent::getTranslation("company.search.result.title"); ?></h1>
        <?php
        if (count($results) > 0) {
            ?>
            <p><?php echo parent::getTranslation("company.search.result.description",array("%total%"=>count($results),"%amount%"=>$resultsPerPage < count($results) ? $resultsPerPage : count($results))); ?></p>
            <?php
            parent::listResults($results);
        } else {
            ?>
            <p><?php echo parent::getTranslation("company.search.result.none"); ?></p>
            <?php
        }
    }
}

?>