<?php

require_once('core/plugin.php');
require_once('modules/company/companyModel.php');

class CompanyEmployeeModule extends XModule {
    
    const modeCurrentCompany = 1;
    const modeSelectedCompany = 2;
    
    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {
        switch (parent::getAction()) {
            case "save":
                if (Context::hasRole("company.employee.edit")) {
                    parent::param("mode",parent::post("mode"));
                }
                parent::blur();
                parent::redirect();
                break;
            case "edit":
                if (Context::hasRole("company.employee.edit")) {
                    parent::focus();
                }
                break;
            default:
                if (parent::get("companyId") == self::modeSelectedCompany) {
                    Context::getSelection()->company = parent::get("companyId");
                } else if (parent::param("mode") == self::modeCurrentCompany) {
                    $company = CompanyModel::getMainUserCompany(Context::getUserId());
                    Context::getSelection()->company = $company->id;
                }
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {

        switch (parent::getAction()) {
            case "edit":
                if (Context::hasRole("company.employee.edit")) {
                    $this->printEditView();
                }
                break;
            default:
                if (Context::hasRole("company.employee.view")) {
                    $this->printMainView();
                }
                break;
        }
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("company.employee.edit","company.employee.view");
    }
    
    function getStyles() {
        return array("css/companyEmployee.css");
    }
    
    function printEditView () {
        ?>
        <div class="panel companyEmployeeEditPanel">
            <form action="<?php echo parent::link(array("action"=>"save")); ?>" method="post">
                <table class="formTable"><tr><td>
                    <?php echo parent::getTranslation("company.employee.edit.mode"); ?>
                </td><td>
                    <?php InputFeilds::printSelect("mode", parent::param("mode"), array(self::modeCurrentCompany => parent::getTranslation("company.current"), self::modeSelectedCompany => parent::getTranslation("company.selected"))); ?>
                </td></tr></table>
                <hr/>
                <div class="alignRight">
                    <button type="submit" class="jquiButton"><?php echo parent::getTranslation("common.save"); ?></button>
                </div>
            </form>
        </div>
        <?php
    }
    
    function printMainView () {
        ?>
        <div class="panel companyEmployeePanel">
            <?php
            $company = $companyId = null;
            switch (parent::param("mode")) {
                case self::modeSelectedCompany:
                    $companyId = Context::getSelection()->company;
                    $company = CompanyModel::getCompany($companyId);
                    break;
                case self::modeCurrentCompany:
                default:
                    $company = CompanyModel::getMainUserCompany(Context::getUserId());
                    $companyId = $company->id;
                    break;
            }
            
            if (!empty($company)) {
                
                $employees = CompanyModel::getCompanyUsers($companyId);
                
                if (empty($employees)) {
                    ?>
                    <h1><?php echo parent::getTranslation("companyEmployee.none.title"); ?></h1>
                    <p><?php echo parent::getTranslation("companyEmployee.none.description"); ?></p>
                    <?php
                } else {
                    ?>
                    <h1><?php echo parent::getTranslation("companyEmployee.title"); ?></h1>
                    <p><?php echo parent::getTranslation("companyEmployee.description"); ?></p>
                    <div class="usersList">
                        <?php
                        foreach ($employees as $employee) {
                            $user = UsersModel::getUser($employee->userid);
                            
                            ?>
                            <div class="userListUserDiv shadow">
                                <div class="userListUserImage">
                                    <a href="<?php echo parent::link('userProfile', array('userId' => $user->id), true, false); ?>" title="<?php echo $user->username; ?>">
                                        <img width="170" height="170" src="<?php echo UsersModel::getUserImageUrl($user->id); ?>" alt="<?php echo $user->username; ?>"/>
                                    </a>
                                </div>
                                <div class="userListUserDetails">
                                    <a href="<?php echo parent::link('userProfile', array('userId' => $user->id), true, false); ?>">
                                        <?php echo $user->username; ?>
                                        <?php echo ' ('.$user->age.')'; ?>
                                    </a>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="clear"></div>
                    </div>
                    <?php
                }
                
                $companyName = htmlentities($company->name);
                ?>
  
                <?php
            }
            ?>
        </div>
        <?php
    }
}

?>