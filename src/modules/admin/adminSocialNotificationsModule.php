<?php

require_once 'core/plugin.php';

class AdminSocialNotificationsModule extends XModule {
    
    function onProcess () {
        
        switch (parent::getAction()) {
            case "update":
                if (Context::hasRole("adminSocialNotifications.edit")) {
                    SocialNotificationsModel::update(
                        parent::post("messageReceived"), 
                        parent::post("messageReceivedTitle"), 
                        parent::post("friendRequest"), 
                        parent::post("friendRequestTitle"), 
                        parent::post("friendConfirmed"), 
                        parent::post("friendConfirmedTitle"), 
                        parent::post("wallPost"), 
                        parent::post("wallPostTitle"), 
                        parent::post("wallReply"), 
                        parent::post("wallReplyTitle"), 
                        parent::post("senderEmail"));
                    parent::redirect();
                    break;
            }
        }
    }
    
    function onView () {
        
        switch (parent::getAction()) {
            default:
                if (Context::hasRole("adminSocialNotifications.edit")) {
                    $this->renderMainTabs();
                }
        }
    }
    
    function getStyles () {
        return array("css/socialNotifications.css");
    }
    
    function getRoles () {
        return array("adminSocialNotifications.edit");
    }
    
    function renderMainTabs () {
        ?>
        <div class="panel adminSocialNotificationsPanel">
            <div class="adminSocialNotificationsTabs">
                <ul>
                    <li><a href="#adminSocialNotificationsTab"><?php echo parent::getTranslation("adminSocialNotifications.tab.label"); ?></a></li>
                </ul>
                <div id="adminSocialNotificationsTab">
                    <?php $this->renderMainView(); ?>
                </div>
            </div>
        </div>
        <script type="text/javascript">
        $(".adminSocialNotificationsTabs").tabs();
        </script>
        <?php
    }
    
    function renderMainView() {
        
        ?>
        <h1><?php echo parent::getTranslation("adminSocialNotifications.title"); ?></h1>
        <p><?php echo parent::getTranslation("adminSocialNotifications.description"); ?></p>
        <?php
        
        $socialNotifications = SocialNotificationsModel::get();
        
        ?>
        <form method="post" action="<?php echo parent::link(array("action"=>"update")); ?>">
            
            <h3><?php echo parent::getTranslation("adminSocialNotifications.senderEmail.title"); ?></h3>
            <p><?php echo parent::getTranslation("adminSocialNotifications.senderEmail.description"); ?></p>
            <?php
            InputFeilds::printTextFeild("senderEmail",$socialNotifications->sender_email);
            ?>
            
            <h3><?php echo parent::getTranslation("adminSocialNotifications.messageReceived.title"); ?></h3>
            <p><?php echo parent::getTranslation("adminSocialNotifications.messageReceived.subject"); ?></p>
            <?php
            InputFeilds::printTextFeild("messageReceivedTitle",$socialNotifications->message_received_title);
            ?>
            <p><?php echo parent::getTranslation("adminSocialNotifications.messageReceived.description"); ?></p>
            <?php
            InputFeilds::printHtmlEditor("messageReceived",$socialNotifications->message_received);
            ?>
            
            <h3><?php echo parent::getTranslation("adminSocialNotifications.friendRequest.title"); ?></h3>
            <p><?php echo parent::getTranslation("adminSocialNotifications.friendRequest.subject"); ?></p>
            <?php
            InputFeilds::printTextFeild("friendRequestTitle",$socialNotifications->friend_request_title);
            ?>
            <p><?php echo parent::getTranslation("adminSocialNotifications.friendRequest.description"); ?></p>
            <?php
            InputFeilds::printHtmlEditor("friendRequest",$socialNotifications->friend_request);
            ?>
            
            <h3><?php echo parent::getTranslation("adminSocialNotifications.friendConfirmed.title"); ?></h3>
            <p><?php echo parent::getTranslation("adminSocialNotifications.friendConfirmed.subject"); ?></p>
            <?php
            InputFeilds::printTextFeild("friendConfirmedTitle",$socialNotifications->friend_confirmed_title);
            ?>
            <p><?php echo parent::getTranslation("adminSocialNotifications.friendConfirmed.description"); ?></p>
            <?php
            InputFeilds::printHtmlEditor("friendConfirmed",$socialNotifications->friend_confirmed);
            ?>
            
            <h3><?php echo parent::getTranslation("adminSocialNotifications.wallPost.title"); ?></h3>
            <p><?php echo parent::getTranslation("adminSocialNotifications.wallPost.subject"); ?></p>
            <?php
            InputFeilds::printTextFeild("wallPostTitle",$socialNotifications->wall_post_title);
            ?>
            <p><?php echo parent::getTranslation("adminSocialNotifications.wallPost.description"); ?></p>
            <?php
            InputFeilds::printHtmlEditor("wallPost",$socialNotifications->wall_post);
            ?>
            
            <h3><?php echo parent::getTranslation("adminSocialNotifications.wallReply.title"); ?></h3>
            <p><?php echo parent::getTranslation("adminSocialNotifications.wallReply.subject"); ?></p>
            <?php
            InputFeilds::printTextFeild("wallReplyTitle",$socialNotifications->wall_reply_title);
            ?>
            <p><?php echo parent::getTranslation("adminSocialNotifications.wallReply.description"); ?></p>
            <?php
            InputFeilds::printHtmlEditor("wallReply",$socialNotifications->wall_reply);
            ?>
            
            <hr/>
            <div class="alignRight">
                <button class="jquiButton"><?php echo parent::getTranslation("common.save"); ?></button>
            </div>
        </form>
        <?php
    }
    
}

?>