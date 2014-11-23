<?php

require_once('core/plugin.php');

class UserSettingsModule extends XModule {
    
    const modeCurrentUser = 1;
    const modeSelectedUser = 2;

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {
        switch (parent::getAction()) {
            case "save":
                if (Context::hasRole("user.profile.edit")) {
                    parent::param("mode",$_POST["mode"]);
                }
                parent::blur();
                parent::redirect();
                break;
            case "edit":
                if (Context::hasRole("user.profile.edit")) {
                    parent::focus();
                }
                break;
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {

        switch (parent::getAction()) {
            case "edit":
                if (Context::hasRole("user.profile.edit")) {
                    $this->printEditView();
                }
                break;
            default:
                if (Context::hasRole("user.profile.view")) {
					$this->printMainView();
                }
                break;
        }
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("user.profile.edit","user.profile.view","user.profile.owner","user.profile.privateDetails");
    }
    
    function getStyles () {
    	return array("css/userSettings.css");
    }
    
    function getModeUserId () {
    	$userId = null;
        switch (parent::param("mode")) {
            case self::modeSelectedUser:
                $userId = Context::getSelectedUserId();
                break;
            case self::modeCurrentUser:
                if (Context::hasRole("user.profile.owner")) {
                    $userId = Context::getUserId();
                }
                break;
            default:
        }
        return $userId;
    }
    
    function printEditView () {
        ?>
        <div class="panel userInfoEditPanel">
            <form action="<?php echo parent::link(array("action"=>"save")); ?>" method="post">
                <table class="formTable"><tr><td>
                    <?php echo parent::getTranslation("users.profile.edit.mode"); ?>
                </td><td>
                    <?php InputFeilds::printSelect("mode", parent::param("mode"), array(self::modeCurrentUser => parent::getTranslation("common.user.current"), self::modeSelectedUser => parent::getTranslation("common.user.selected"))); ?>
                </td></tr>
                </table>
                <hr/>
                <div class="alignRight">
                    <button type="submit" class="jquiButton"><?php echo parent::getTranslation("common.save"); ?></button>
                </div>
            </form>
        </div>
        <?php
    }
	
    function printMainView () {
    	
    	$userId = $this->getModeUserId();
    	
    	?>
    	<div class="panel userSettingsPanel">
	    	
	    	<h1><?php echo parent::getTranslation("userSettings.title"); ?></h1>
	    	<p><?php echo parent::getTranslation("userSettings.description"); ?></p>
	    	
	    	<div class="userSettingItem">
		    	<h3><?php echo parent::getTranslation("userSettings.accountDetails.title"); ?></h3>
		    	<p><?php echo parent::getTranslation("userSettings.accountDetails.description"); ?></p>
		    	<hr>
		    	<div class="alignRight">
		    		<a class="jquiButton" href="<?php echo parent::staticLink("userDetails",array("userId"=>$userId)); ?>"><?php echo parent::getTranslation("common.edit"); ?></a>
		    	</div>
	    	</div>
	    	
	    	<div class="userSettingItem">
		    	<h3><?php echo parent::getTranslation("userSettings.address.title"); ?></h3>
		    	<p><?php echo parent::getTranslation("userSettings.address.description"); ?></p>
		    	<hr>
		    	<div class="alignRight">
		    		<a class="jquiButton"><?php echo parent::getTranslation("common.edit"); ?></a>
		    	</div>
	    	</div>
	    	
	    	<div class="userSettingItem">
	    		<h3><?php echo parent::getTranslation("userSettings.userInfo.title"); ?></h3>
		    	<p><?php echo parent::getTranslation("userSettings.userInfo.description"); ?></p>
		    	<hr>
		    	<div class="alignRight">
		    		<a class="jquiButton" href="<?php echo parent::staticLink("userInfo",array("action"=>"editInfo", "userId"=>$userId)); ?>"><?php echo parent::getTranslation("common.edit"); ?></a>
	    		</div>
	    	</div>
    	</div>
    	<?php
    }
    
}

?>