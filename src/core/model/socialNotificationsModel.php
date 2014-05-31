<?php

class SocialNotificationsModel {
    
    static function get ($siteId = null) {
        
        if ($siteId == null) {
            $siteId = Context::getSiteId();
        }
        $siteId = mysql_real_escape_string($siteId);
        
        $result = Database::queryAsObject("select * from t_social_notifications where siteid = '$siteId'");
        if (empty($result)) {
            self::create("", "", "", "");
            return self::get();
        }
        
        return $result;
    }
    
    static function create ($messageReceived,$friendRequest,$friendConfirmed,$wallPost,$siteId = null) {
        
        $messageReceived = mysql_real_escape_string($messageReceived);
        $friendRequest = mysql_real_escape_string($friendRequest);
        $friendConfirmed = mysql_real_escape_string($friendConfirmed);
        $wallPost = mysql_real_escape_string($wallPost);
        if ($siteId == null) {
            $siteId = Context::getSiteId();
        }
        $siteId = mysql_real_escape_string($siteId);
        
        Database::query("insert into t_social_notifications (message_received,friend_request,friend_confirmed,wall_post,siteid) values('$messageReceived','$friendRequest','$friendConfirmed','$wallPost','$siteId')");
    }
    
    static function update ($messageReceived,$friendRequest,$friendConfirmed,$wallPost,$siteId = null) {
        $messageReceived = mysql_real_escape_string($messageReceived);
        $friendRequest = mysql_real_escape_string($friendRequest);
        $friendConfirmed = mysql_real_escape_string($friendConfirmed);
        $wallPost = mysql_real_escape_string($wallPost);
        if ($siteId == null) {
            $siteId = Context::getSiteId();
        }
        $siteId = mysql_real_escape_string($siteId);
        
        Database::query("update t_social_notifications set
            message_received = '$messageReceived',
            friend_request = '$friendRequest',
            friend_confirmed = '$friendConfirmed',
            wall_post = '$wallPost'
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