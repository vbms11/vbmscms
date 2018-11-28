<?php

require_once('core/plugin.php');
require_once('modules/company/companyModel.php');

class CompanyProfileModule extends XModule {
    
    const modeCurrentCompany = 1;
    const modeSelectedCompany = 2;

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {
        switch (parent::getAction()) {
            case "save":
                if (Context::hasRole("company.profile.edit")) {
                    parent::param("mode",parent::post("mode"));
                }
                parent::blur();
                parent::redirect();
                break;
            case "edit":
                if (Context::hasRole("company.profile.edit")) {
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
                if (Context::hasRole("company.profile.edit")) {
                    $this->printEditView();
                }
                break;
            default:
                if (Context::hasRole("company.profile.view")) {
                    $this->printMainView();
                }
                break;
        }
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("company.profile.edit","company.profile.view");
    }
    
    function getStyles() {
        return array("css/companyProfile.css");
    }
    
    function printEditView () {
        ?>
        <div class="panel companyProfileEditPanel">
            <form action="<?php echo parent::link(array("action"=>"save")); ?>" method="post">
                <table class="formTable"><tr><td>
                    <?php echo parent::getTranslation("company.profile.edit.mode"); ?>
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
        <div class="panel usersProfilePanel">
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
                $companyName = htmlentities($company->name);
                ?>
                <div class="companyProfileName">
                    <?php echo $companyName." (".$company->employees.")"; ?>
                </div>
                <div class="companyProfileMenu">
                    <div>
                        <a href="<?php echo parent::link('companyFiles', array('companyId' => $companyId), true, false); ?>">
                            <?php echo parent::getTranslation("companyProfile.files"); ?>
                        </a>
                    </div>
                    <div>
                        <a href="<?php echo parent::link("companyEmployees",array("companyId"=>$companyId), true, false); ?>">
                            <?php echo parent::getTranslation("companyProfile.workers"); ?>
                        </a>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    }
}

?>