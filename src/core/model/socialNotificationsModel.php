<?php

class SocialNotificationsModel {
    
    static function get ($siteId = null) {
        
        if ($siteId == null) {
            $siteId = Context::getSiteId();
        }
        $siteId = Database::escape($siteId);
        
        $result = Database::queryAsObject("select * from t_social_notifications where siteid = '$siteId'");
        if (empty($result)) {
            self::create("", "", "", "", "", "", "", "", "", "", "");
            return self::get();
        }
        
        return $result;
    }
    
    static function create ($messageReceived,$messageReceivedTitle,$friendRequest,$friendRequestTitle,$friendConfirmed,$friendConfirmedTitle,$wallPost,$wallPostTitle,$wallReply,$wallReplyTitle,$senderEmail,$siteId = null) {
        
        $messageReceived = Database::escape($messageReceived);
        $friendRequest = Database::escape($friendRequest);
        $friendConfirmed = Database::escape($friendConfirmed);
        $wallPost = Database::escape($wallPost);
        $wallReply = Database::escape($wallReply);
        $messageReceivedTitle = Database::escape($messageReceivedTitle);
        $friendRequestTitle = Database::escape($friendRequestTitle);
        $friendConfirmedTitle = Database::escape($friendConfirmedTitle);
        $wallPostTitle = Database::escape($wallPostTitle);
        $wallReplyTitle = Database::escape($wallReplyTitle);
        $senderEmail = Database::escape($senderEmail);
        if ($siteId == null) {
            $siteId = Context::getSiteId();
        }
        $siteId = Database::escape($siteId);
        
        Database::query("insert into t_social_notifications 
            (message_received,message_received_title,friend_request,friend_request_title,friend_confirmed,friend_confirmed_title,wall_post,wall_post_title,wall_reply,wall_reply_title,sender_email,siteid) 
            values('$messageReceived','$messageReceivedTitle','$friendRequest','$friendRequestTitle','$friendConfirmed','$friendConfirmedTitle','$wallPost','$wallPostTitle','$wallReply','$wallReplyTitle','$senderEmail','$siteId')");
    }
    
    static function update ($messageReceived,$messageReceivedTitle,$friendRequest,$friendRequestTitle,$friendConfirmed,$friendConfirmedTitle,$wallPost,$wallPostTitle,$wallReply,$wallReplyTitle,$senderEmail,$siteId = null) {
        $messageReceived = Database::escape($messageReceived);
        $friendRequest = Database::escape($friendRequest);
        $friendConfirmed = Database::escape($friendConfirmed);
        $wallPost = Database::escape($wallPost);
        $wallReply = Database::escape($wallReply);
        $messageReceivedTitle = Database::escape($messageReceivedTitle);
        $friendRequestTitle = Database::escape($friendRequestTitle);
        $friendConfirmedTitle = Database::escape($friendConfirmedTitle);
        $wallPostTitle = Database::escape($wallPostTitle);
        $wallReplyTitle = Database::escape($wallReplyTitle);
        $senderEmail = Database::escape($senderEmail);
        if ($siteId == null) {
            $siteId = Context::getSiteId();
        }
        $siteId = Database::escape($siteId);
        
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
        $siteId = Database::escape($siteId);
        
        Database::query("delete from t_social_notifications where siteid = '$siteId'");
    }
}

?>