<?php

require_once 'core/plugin.php';
require_once 'modules/admin/customFileManagerModule.php';

class UserFilesModule extends CustomFileManagerModule {

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {
        
        switch (parent::getAction()) {
            
            case "save":
                if (Context::hasRole("user.files.edit")) {
                    parent::param("mode", parent::post("mode"));
                    parent::redirect();
                }
                break;
            case "config":
                break;
            default:
                parent::onProcess();
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
                $userId = $this->getModeUserId();
                $user = UsersModel::getUser($userId);
                if (RolesModel::hasModuleRole($userId,"user.files.owner")) {
                    if (empty($user->directoryid)) {
                        $user->directoryid = UsersModel::setupUserDirectory($userId);
                    }
                    parent::onView($user->directoryid);
                }
        }
    }
    
    function getRoles () {
        return array_merge(parent::getRoles(),array("user.files.owner"));
    }
    
    function getStyles () {
        return parent::getStyles();
    }
    
    function getModeUserId () {
        
        $userId = null;
        
        switch (parent::param("mode")) {
            case "selected":
                $userId = Context::getSelectedUserId();
                if (!RolesModel::hasRole($userId, "user.files.owner")) {
                    $userId = null;
                }
                break;
            case "current":
            default:
                if (Context::hasRole("user.files.owner")) {
                    $userId = Context::getUserId();
                }
                break;
        }
        
        return $userId;
    }
    
    function printEditView () {
        ?>
        <div class="panel userFilesEditPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"save")); ?>">
                <table><tr>
                    <td>mode</td>
                    <td>
                        <?php
                        InputFeilds::printSelect("mode", parent::param("mode"), array("current"=>"current user", "selected"=>"selected user"));
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