<?php

class SocialNotificationsModel {
    
    static function get ($siteId = null) {
        
        if ($siteId == null) {
            $siteId = Context::getSiteId();
        }
        $siteId = mysql_real_escape_string($siteId);
        
        $result = Database::queryAsObject("select * from t_social_notifications where siteid = '$siteId'");
        if (empty($result)) {
            self::create("", "", "", "", "", "", "", "", "", "", "");
            return self::get();
        }
        
        return $result;
    }
    
    static function create ($messageReceived,$messageReceivedTitle,$friendRequest,$friendRequestTitle,$friendConfirmed,$friendConfirmedTitle,$wallPost,$wallPostTitle,$wallReply,$wallReplyTitle,$senderEmail,$siteId = null) {
        
        $messageReceived = mysql_real_escape_string($messageReceived);
        $friendRequest = mysql_real_escape_string($friendRequest);
        $friendConfirmed = mysql_real_escape_string($friendConfirmed);
        $wallPost = mysql_real_escape_string($wallPost);
        $wallReply = mysql_real_escape_string($wallReply);
        $messageReceivedTitle = mysql_real_escape_string($messageReceivedTitle);
        $friendRequestTitle = mysql_real_escape_string($friendRequestTitle);
        $friendConfirmedTitle = mysql_real_escape_string($friendConfirmedTitle);
        $wallPostTitle = mysql_real_escape_string($wallPostTitle);
        $wallReplyTitle = mysql_real_escape_string($wallReplyTitle);
        $senderEmail = mysql_real_escape_string($senderEmail);
        if ($siteId == null) {
            $siteId = Context::getSiteId();
        }
        $siteId = mysql_real_escape_string($siteId);
        
        Database::query("insert into t_social_notifications 
            (message_received,message_received_title,friend_request,friend_request_title,friend_confirmed,friend_confirmed_title,wall_post,wall_post_title,wall_reply,wall_reply_title,sender_email,siteid) 
            values('$messageReceived','$messageReceivedTitle','$friendRequest','$friendRequestTitle','$friendConfirmed','$friendConfirmedTitle','$wallPost','$wallPostTitle','$wallReply','$wallReplyTitle','$senderEmail','$siteId')");
    }
    
    static function update ($messageReceived,$messageReceivedTitle,$friendRequest,$friendRequestTitle,$friendConfirmed,$friendConfirmedTitle,$wallPost,$wallPostTitle,$wallReply,$wallReplyTitle,$senderEmail,$siteId = null) {
        $messageReceived = mysql_real_escape_string($messageReceived);
        $friendRequest = mysql_real_escape_string($friendRequest);
        $friendConfirmed = mysql_real_escape_string($friendConfirmed);
        $wallPost = mysql_real_escape_string($wallPost);
        $wallReply = mysql_real_escape_string($wallReply);
        $messageReceivedTitle = mysql_real_escape_string($messageReceivedTitle);
        $friendRequestTitle = mysql_real_escape_string($friendRequestTitle);
        $friendConfirmedTitle = mysql_real_escape_string($friendConfirmedTitle);
        $wallPostTitle = mysql_real_escape_string($wallPostTitle);
        $wallReplyTitle = mysql_real_escape_string($wallReplyTitle);
        $senderEmail = mysql_real_escape_string($senderEmail);
        if ($siteId == null) {
            $siteId = Context::getSiteId();
        }
        $siteId = mysql_real_escape_string($siteId);
        
        Database::query("update t_social_notifications set
            message_received = '$messageReceived',
            message_received_title = '$messageReceivedTitle', 
            friend_request = '$friendRequest',
            friend_request_title = '$friendRequestTitle', 
            friend_confirmed = '$friendConfirmed',
            friend_confirmed_title = '$friendConfirmedTitle', 
            wall_post = '$wallPost', 
            wall_post_title = '$wallPostTitle',
            wall_reply = '$wallReply', 
            wall_reply_title = '$wallReplyTitle',
            sender_email = '$senderEmail' 
            where siteid = '$siteId'");
    }
    
    static function delete ($siteId = null) {
        
        if ($siteId == null) {
            $siteId = Context::getSiteId();
        }
        $siteId = mysql_real_escape_string($siteId);
        
        Database::query("delete from t_social_notifications where siteid = '$siteId'");
    }
}

?>