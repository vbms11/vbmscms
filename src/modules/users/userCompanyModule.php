<?php

require_once('core/plugin.php');
require_once('modules/company/companyModel.php');

class UserCompanyModule extends XModule {
    
    const modeSelectedUser = 1;
    const modeCurrentUser = 2;
    
    function onProcess () {
        
        switch (parent::getAction()) {
            case "save":
                if (Context::hasRole("userCompany.edit")) {
                    parent::param("mode",parent::post("mode"));
                    parent::blur();
                    parent::redirect();
                }
                break;
            case "edit":
                if (Context::hasRole("userCompany.edit")) {
                    parent::focus();
                }
                break;
            case "doCreateCompany":
                if (Context::hasRole("userCompany.create")) {
                    if (parent::post("save") === parent::alias("save")) {
                        $companyId = CompanyModel::createCompany(parent::post("name"));
                        CompanyModel::addCompanyUser($companyId, Context::getUserId(), CompanyModel::role_boss);
                        parent::redirect("companyProfile",array("companyId"=>$companyId));
                    } else {
                        parent::redirect();
                    }
                } 
                break;
            default:
                if (parent::param("mode") == self::modeSelectedUser && parent::get("userId")) {
                    Context::setSelectedUser(parent::get("userId"));
                } else if (parent::param("mode") == self::modeCurrentUser) {
                    Context::setSelectedUser(Context::getUserId());
                }
                parent::clearMessages();
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {
        
        switch (parent::getAction()) {
            case "edit":
                if (Context::hasRole("userCompany.edit")) {
                    $this->printEditView();
                }
                break;
            case "createCompany":
                if (Context::hasRole("userCompany.create")) {
                    $this->printCreateCompanyView();
                }
                break;
            default:
                if (Context::hasRole(array("userCompany.view"))) {
                    $this->printMainView();
                }
        }
    }
    
    function getRoles () {
        return array("userCompany.edit","userCompany.view","userCompany.create");
    }
    
    function getStyles () {
        return array("css/userCompany.css");
    }
    
    function printEditView () {
        ?>
        <div class="panel userCompanyEditPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"save")); ?>">
                <table class="formTable"><tr><td>
                    <?php echo parent::getTranslation("userCompany.edit.mode"); ?>
                </td><td>
                    <?php InputFeilds::printSelect("mode", parent::param("mode"), array(self::modeCurrentCompany=>"Current User Company",self::modeSelectedCompany=>"Selected User Company")); ?>
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
        <div class="panel userCompanyPanel">
            <?php

            $companys = CompanyModel::getUserCompanys(Context::getSelectedUserId());
            if (!empty($companys)) {

                ?>
                <h1><?php echo parent::getTranslation("userCompany.result.title"); ?></h1>
                <p><?php echo parent::getTranslation("userCompany.result.description"); ?></p>
                <?php

                foreach ($companys as $company) {
                    ?>
                    <table class="resultTable">
                        <thead>
                            <tr><td class="contract">
                                <?php echo parent::getTranslation("userCompany.table.image"); ?>
                            </td><td>
                                <?php echo parent::getTranslation("userCompany.table.companyName"); ?>
                            </td><td>
                                <?php echo parent::getTranslation("userCompany.table.userRole"); ?>
                            </td><td class="contract" colspan="2">
                                <?php echo parent::getTranslation("userCompany.table.tools"); ?>
                            </td></tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($companys as $company) {
                            ?>
                            <tr><td>
                                <?php
                                ?>
                            </td><td>
                                <a href="<?php echo parent::link("companyProfile", array("companyId"=>$company->id)); ?>">
                                    <?php echo htmlentities($company->name); ?>
                                </a>
                            </td><td>
                                <?php echo htmlentities($company->role); ?>
                            </td><td>
                                <a href="<?php echo parent::link("companyProfile", array("companyId"=>$company->id)); ?>">
                                    <img src="<?php echo ""; ?>" alt="<?php echo parent::getTranslation("common.edit") ?>" />
                                </a>
                            </td></tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                    <?php
                }
            } else {
                ?>
                <h1><?php echo parent::getTranslation("userCompany.empty.title"); ?></h1>
                <p><?php echo parent::getTranslation("userCompany.empty.description"); ?></p>
                <?php
            }
            
            ?>
            <hr/>
            <div class="alignRight">
                <a class="jquiButton" href="<?php echo parent::link(array("action"=>"createCompany")); ?>"><?php echo parent::getTranslation("userCompany.button.create"); ?></a>
            </div>
        </div>
        <?php
    }
    
    function printCreateCompanyView () {
        
        ?>
        <div class="panel userCompanyCreatePanel">
            <h1><?php echo parent::getTranslation("userCompany.create.title"); ?></h1>
            <p><?php echo parent::getTranslation("userCompany.create.description"); ?></p>
            <form action="<?php echo parent::link(array("action"=>"doCreateCompany")); ?>" method="post">
                <table class="formTable"><tr>
                    <td><?php echo parent::getTranslation("userCompany.create.name"); ?></td>
                    <td><?php InputFeilds::printTextFeild("name"); ?></td>
                </tr></table>
                <hr/>
                <div class="alignRight">
                    <button class="jquiButton" name="save" value="<?php echo parent::alias("save"); ?>"><?php echo parent::getTranslation("common.save"); ?></button>
                    <button class="jquiButton"><?php echo parent::getTranslation("common.cancel"); ?></button>
                </div>
            </form>
        </div>
        <?php
    }
    
}

?>