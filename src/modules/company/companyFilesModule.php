<?php

require_once 'core/plugin.php';
require_once 'modules/admin/customFileManagerModule.php';

class CompanyFilesModule extends CustomFileManagerModule {

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {
        
        switch (parent::getAction()) {
            case "save":
                if (Context::hasRole("company.files.edit")) {
                    parent::param("mode", parent::post("mode"));
                    parent::redirect();
                }
                break;
            case "config":
                break;
            default:
                break;
        }
    }
    
    /**
     * called when page is viewed and html created
     */
    function onView () {

        switch (parent::getAction()) {

            case "edit":

                $this->printEditView();

                break;
            default:
                if (Context::hasRole("company.files.view")) {
                    
                    $companyId = $this->getModeCompanyId();
                    $company = CompanyModel::getCompany($companyId);
                    $this->printMainView($company->directoryid);
                }
        }
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("company.files.edit", "company.files.view", "company.files.owner");
    }
    
    /**
     * returns the id of the company in scope of this mode
     */
    function getModeCompanyId () {
        
        $companyId = null;
        
        switch (parent::param("mode")) {
            case "selected":
                $companyId = Context::getSelection()->companyId;
                break;
            case "current":
            default:
                if (Context::hasRole("company.files.owner")) {
                    $companyId = Context::getSelection()->companyId;
                }
                break;
        }
        
        return $companyId;
    }
    
    /**
     * prints the edit view
     */
    function printEditView () {
        ?>
        <div class="panel companyFilesEditPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"save")); ?>">
                <table><tr>
                    <td>mode</td>
                    <td>
                        <?php
                        InputFeilds::printSelect("mode", parent::param("mode"), array("current"=>"current company", "selected"=>"selected company"));
                        ?>
                    </td>
                </tr></table>
                </tr>
                <div>
                    <button type="submit"><?php echo parent::translation("common.save"); ?></button>
                </div>
            </form>
        </div>
        <?php
    }
    
}

?>