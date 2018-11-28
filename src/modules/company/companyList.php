<?php

require_once('core/plugin.php');
require_once('modules/company/companyModel.php');
require_once('modules/company/companySearchBaseModule.php');

class CompanyList extends CompanySearchBaseModule {
    
    function onProcess () {
        
        switch (parent::getAction()) {
            case "save":
                parent::blur();
                parent::redirect();
                break;
            case "doImport":
                if ($emails = preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9_.-]+\.[a-zA-Z]{2,7}$/D", $email) != 0) {
                    
                    foreach ($emails as $email) {
                        // create company
                        // add email to company
                        // create company person
                    }
                }
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
            case "import":
                if (Context::hasRole("company.search.import")) {
                    $this->printImportView();
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
        $results = CompanyModel::getAll($resultsPerPage);
        $resultsPerPage = parent::getResultsPerPage();
      	
        ?>
        <h1><?php echo parent::getTranslation("company.search.result.title"); ?></h1>
        <?php
        if (count($results) > 0) {
            ?>
            <p><?php echo parent::getTranslation("company.search.result.description",array("%total%"=>count($results),"%amount%"=>$resultsPerPage < count($results) ? $resultsPerPage : count($results))); ?></p>
            <?php
            parent::tableResults($results);
        } else {
            ?>
            <p><?php echo parent::getTranslation("company.search.result.none"); ?></p>
            <?php
        }
        ?>
        <a href="<?php echo parent::link(array("action"=>"import")); ?>">
            <?php echo parent::translation("companyTable.button.import"); ?>
        </a>
        <?php
    }
    
    function printImportStatus () {
        
        $emailsFound
        $companysAlreadyExisted
        $newCompanys
        $total
    }
    
    function printImportView () {
        
        ?>
        <form action="<?php echo parent::link(array("action"=>"doImport")); ?>" method="post">
        <h1><?php echo parent::getTranslation("company.list.import.title"); ?></h1>
        
        <h1><?php echo parent::getTranslation("company.list.import.description"); ?></h1>
        
        <label for="emails"><?php echo parent::getTranslation("company.list.import.emails.label"); ?></label>
        <textarea name="emails" placeholder="<?php echo parent::getTranslation("company.search.upload"); ?>"></textarea>
        
        
        <label></label><h1><?php echo parent::getTranslation("company.search.result.title"); ?></h1>
    }
}

?>