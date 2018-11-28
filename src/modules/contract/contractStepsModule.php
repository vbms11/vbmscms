<?php

/**

process flow steps and actions

do you need a website,


tabs 

in progress contracts that are being worked on,

contracts that being allocated a programmer

companys that were offered a website


**/


include_once 'core/plugin.php';

class ContractsProgressModule extends XModule {

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {
        
        if (Context::hasRole("wysiwyg.edit")) {
            
            switch (parent::getAction()) {
                case "update":
                    break;
                case "edit":
                    parent::focus();
                    break;
                case "cancel":
                    parent::blur();
            }
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {
        
        switch (parent::getAction()) {
            case "edit":
                if (Context::hasRole("wysiwyg.edit")) {
                    $this->printEditView();
                }
                break;
            default:
                $this->printMainView();
        }
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("wysiwyg.edit");
    }

    /**
     * returns search results for given text
     */
    function search ($searchText, $lang) {
    }

    function printMainView () {
        
        $offered = ContractsModel::getContractByStatus(ContractsModel::$offered);
        $assigning = ContractsModel::getContractByStatus(ContractsModel::$assigning);
        $progress = ContractsModel::getContractByStatus(ContractsModel::$progress);
        
        ?>
        <div class="panel contractsProgressPanel ui-tabs">
            <ul>
                <li><a href="#progress">In progress</a></li>
                <li><a href="#assigning">Being assigned</a></li>
                <li><a href="#offered">Offered</a></li>
            </ul>
            <div id="progress">
                <h1></h1>
            </div>
            <div id="assigned">
                
            </div>
            <div id="offered">
                
            </div>
        </div>
        <script>
        </script>
        <?php
    }

    function printEditView () {
    }
}

?>