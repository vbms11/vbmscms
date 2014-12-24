<?php

require_once('core/plugin.php');

class UserInfoModule extends XModule {
    
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
            case "saveUserInfo":
            	
            	$userId = $this->getModeUserId();
            	
	            	if (Context::hasRole("user.profile.owner") && $userId == Context::getUserId()) {
	            	
	            	$messages = UsersModel::validateUserInfo(parent::post("orientation"), parent::post("religion"), parent::post("ethnicity"), parent::post("about"), parent::post("relationship"), parent::post("bodyheight"), parent::post("haircolor"), parent::post("eyecolor"), parent::post("weight"));
	            	if (empty($messages)) {
	            		UsersModel::saveUserInfo($userId, parent::post("orientation"), parent::post("religion"), parent::post("ethnicity"), parent::post("about"), parent::post("relationship"), parent::post("bodyheight"), parent::post("haircolor"), parent::post("eyecolor"), parent::post("weight"));
	            	}
	            	break;
            	}
            	parent::redirect(array("action" => "editInfo"));
        	case "editInfo":
        		parent::focus();
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
            case "editInfo":
            	if (Context::hasRole("user.profile.privateDetails") && Context::getUserId() == $this->getModeUserId()) {
            		$this->printEditInfoView();
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
    	return array("css/userInfo.css");
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
	
    /*	
	todo user_interest user_language
	Interested In: Friends, Serious Relationship
	Languages: Italiano, Tagalog, English
    */
    function printMainView () {
    	
    	$userId = $this->getModeUserId();
        if (!empty($userId)) {
            $user = UsersModel::getUser($userId);
            $userAddress = UserAddressModel::getUserAddressByUserId($userId);
    		?>
	    	<div class="panel userInfoPanel">
	    	 	<?php
	    	 	if ($userId == Context::getUserId()) {
	    	 		?>
	    	 		<div class="userInfoEdit">
		    			<a href="<?php echo parent::link(array("action"=>"editInfo")); ?>">
		    				<?php echo parent::getTranslation("common.edit"); ?>
	    				</a>
		    		</div>
		    		<?php
	    	 	}
	    	 	?>
	    		<div class="userInfoRow">
	    			Last Active: <?php echo $user->lastonline; ?>
	    		</div>
	    		<div class="userInfoRow">
					Profile Views: <?php echo $user->profileviews; ?>
				</div>
				<div class="userInfoRow">
					Member Since: <?php echo $user->registerdate; ?>
				</div>
				<div class="userInfoRow">
					Gender: <?php echo $user->gender; ?>
				</div>
				<div class="userInfoRow">
					Age: <?php echo $user->age; ?>
				</div>
				<div class="userInfoRow">
					Location: <?php echo $userAddress->city.", ".$userAddress->country; ?>
				</div>
				<div class="userInfoRow">
					About: <?php echo $user->about; ?>
				</div>
				<div class="userInfoRow">
					Ethnicity: <?php echo $user->ethnicity; ?>
				</div>
				<div class="userInfoRow">
					Religion: <?php echo $user->religion; ?>
				</div>
				<div class="userInfoRow">
					Orientation: <?php echo $user->orientation; ?>
				</div>
				<div class="userInfoRow">
					Relationship Status: <?php echo $user->relationship; ?>
				</div>
	    		
	    	</div>
    		<?php
    	} 	
    }
    
    function printEditInfoView () {
        
        $userId = $this->getModeUserId();
        ?>
        <div class="panel userEditInfoPanel">
            <?php
            if (!empty($userId)) {
                $user = UsersModel::getUser($userId);
                ?>
                <form method="post" action="<?php echo parent::link(array("action"=>"saveInfo")); ?>">
	                <table class="formTable"><tr><td>
	                    <?php
	                    echo parent::getTranslation("userInfo.label.about");
	                    ?>
	                </td><td>
	                    <?php 
	                    InputFeilds::printTextArea(parent::alias("about"), parent::post("about") == null ? $user->about : parent::post("about")); 
	                    $message = parent::getMessage("about");
	                    if (!empty($message)) {
	                        echo '<span class="validateTips">'.$message.'</span>';
	                    }
	                    ?>
	                </td></tr><tr><td>
	                    <?php
	                    echo parent::getTranslation("userInfo.label.relationship");
	                    ?>
	                </td><td>
	                    <?php 
	                    InputFeilds::printSelect(parent::alias("relationship"), parent::post("relationship") == null ? $user->relationship : parent::post("relationship")); 
	                    $message = parent::getMessage("relationship");
	                    if (!empty($message)) {
	                        echo '<span class="validateTips">'.$message.'</span>';
	                    }
	                    ?>
	                </td></tr><tr><td>
	                    <?php
	                    echo parent::getTranslation("userInfo.label.orientation");
	                    ?>
	                </td><td>
	                    <?php 
	                    InputFeilds::printTextFeild(parent::alias("orientation"),parent::post("orientation") == null ? $user->orientation : parent::post("orientation")); 
	                    $message = parent::getMessage("orientation");
	                    if (!empty($message)) {
	                        echo '<span class="validateTips">'.$message.'</span>';
	                    }
	                    ?>
	                </td></tr><tr><td>
	                    <?php
	                    echo parent::getTranslation("userInfo.label.ethnicity");
	                    ?>
	                </td><td>
	                    <?php 
	                    InputFeilds::printTextFeild(parent::alias("ethnicity"), parent::post("ethnicity") == null ? $user->ethnicity : parent::post("ethnicity")); 
	                    $message = parent::getMessage("ethnicity");
	                    if (!empty($message)) {
	                        echo '<span class="validateTips">'.$message.'</span>';
	                    }
	                    ?>
	                </td></tr><tr><td>
	                    <?php
	                    echo parent::getTranslation("userInfo.label.religion");
	                    ?>
	                </td><td>
	                    <?php 
	                    InputFeilds::printTextFeild(parent::alias("religion"),parent::post("religion") == null ? $user->religion : parent::post("religion")); 
	                    $message = parent::getMessage("religion");
	                    if (!empty($message)) {
	                        echo '<span class="validateTips">'.$message.'</span>';
	                    }
	                    ?>
	                </td></tr></table>
	                
	                <hr/>
	                <div class="alignRight">
	                	<button type="submit" class="jquiButton">
	                		<?php echo parent::getTranslation("common.save"); ?>
	            		</button>
	            		<button type="button" class="jquiButton cancel">
	            			<?php echo parent::getTranslation("common.cancel"); ?>
	            		</button>
	                </div>
                </form>
                <script type="text/javascript">
            	$(".userInfoForm button.cancel").click(function(){
            		callUrl("<?php echo parent::link(); ?>");
            	});
                </script>
                <?php
            }
            
            
            ?>
        </div>
        <?php
        
        
    }
    
}

?>