<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserWallModel
 *
 * @author Administrator
 */
class UserWallModel {
    
    const type_wall = 1;
    const type_image = 2;
    const type_birthday = 3;
    const type_register = 4;
    const type_friend = 5;
    const type_share = 6;
    const type_note = 7;
    const type_pinboard = 8;
    
    static function getUserWallEventsByUserId ($userId) {
        
        $userId = mysql_real_escape_string($userId);
        return Database::queryAsArray("select * from t_user_wall_event where userid = '$userId' order by date desc");
    }
    
    static function getUserWallEventById ($eventId) {
        
        $eventId = mysql_real_escape_string($eventId);
        return Database::queryAsObject("select * from t_user_wall_event where id = '$eventId'");
    }
    
    static function deleteWallEventImageUploadByImageId ($imageId) {
        
        $imageId = mysql_real_escape_string($imageId);
        $eventObj = Database::queryAsObject("select * from t_user_wall_event where typeid = '$imageId' and type = '".self::type_image."'");
        self::deleteWallEventById($eventObj->id);
    }
    
    static function createUserWallEvent ($userId, $type, $typeId = null) {
        
        $userId = mysql_real_escape_string($userId);
        $type = mysql_real_escape_string($type);
        if ($typeId == null) {
            $typeId = "null";
        } else {
            $typeId = "'".mysql_real_escape_string($typeId)."'";
        }
        Database::query("insert into t_user_wall_event (userid,type,typeid) values('$userId','$type',$typeId);");
        $result = Database::queryAsObject("select last_insert_id() as newid from t_user_wall_event");
        return $result->newid;
    }
    
    static function createUserWallEventPost ($userId, $srcUserId, $comment, $eventId = null) {
        
        if ($eventId == null) {
            $eventId = self::createUserWallEvent($userId, self::type_wall);
        }
        self::createUserWallPost($srcUserId, $comment, $eventId);
        
        return $eventId;
    }
    
    static function createUserWallEventImageUpload ($userId, $imageId) {
        
        return self::createUserWallEvent($userId, self::type_image, $imageId);
    }
    
    static function createUserWallEventImageComment ($srcUserId, $comment, $imageUploadEventId) {
        
        self::createUserWallPost($srcUserId, $comment, $imageUploadEventId);
        return $imageUploadEventId;
    }
    
    static function createUserWallEventFriend ($userId, $friendId) {
        
        return self::createUserWallEvent($userId, self::type_friend, $friendId);
    }
    
    static function createUserWallEventBirthday ($userId) {
        
        return self::createUserWallEvent($userId, self::type_birthday);
    }
    
    static function createUserWallEventRegister ($userId) {
        
        return self::createUserWallEvent($userId, self::type_register);
    }
    
    static function createUserWallEventShare ($userId, $eventId) {
        
        return self::createUserWallEvent($userId, self::type_share, $eventId);
    }
    
    static function createUserWallEventNote ($userId, $noteId) {
        
        return self::createUserWallEvent($userId, self::type_note, $noteId);
    }
    
    static function canUserPost ($friendId, $userId = null) {
	if (Context::getUserId() == null) {
		return false;
	}        
	if ($userId == null) {
            $userId = Context::getUserId();
        }
	if ($userId == $friendId) {
            return true;
        }
        return UserFriendModel::isFriend($userId, $friendId);
    }
    
    static function validateWallPost ($userId, $srcUserId, $comment, $eventId = null) {
        $errors = array();
        if (strlen($comment) == 0) {
            $errors["comment"] = "This feild cannot be empty!";
        }
        if (strlen($comment) > 5000) {
            $errors["comment"] = "Maximum 5000 characters allowed!";
        }
        if ($userId != $srcUserId) {
            // check if users are friends
        }
        // check if parent exists
        if ($eventId != null) {
            $parentPost = self::getUserWallEventById($eventId);
            if (empty($parentPost)) {
                $errors["eventId"] = "Post dose not exist";
            }
        }
        return $errors;
    }
    
    static function getUserWallPostById ($wallPostId) {
        
        return self::getUserWallPostsByEventIds(array($wallPostId));
    }
    
    static function getUserWallPostsByEventIds ($eventIds) {
        
        $ids = array();
        foreach ($eventIds as $eventId) {
            $ids = "id = ".mysql_real_escape_string($eventId);
        }
        $idsSql = implode(" or ", $ids);
        return Database::queryAsObject("select * from t_user_wall_post where $idsSql order by date asc");
    }
    
    static function getUserWallPostsByEventId ($eventId) {
        
        $eventId = mysql_real_escape_string($eventId);
        return Database::queryAsArray("select * from t_user_wall_post where eventid = '$eventId' order by date asc");
    }
    
    static function getUserWallImageEventByImageId ($imageId) {
        
        $imageId = mysql_real_escape_string($imageId);
        return Database::queryAsObject("select * from t_user_wall_event where type = '".self::type_image."' and typeid = '$imageId'");
    }
    
    static function createUserWallPost ($srcUserId, $comment, $eventId) {
        
        $srcUserId = mysql_real_escape_string($srcUserId);
        $comment = mysql_real_escape_string($comment);
        $eventIdSql = mysql_real_escape_string($eventId);
        Database::query("insert into t_user_wall_post (srcuserid,comment,date,eventid)
            values ('$srcUserId','$comment',now(),'$eventIdSql')");
        $newId = Database::queryAsObject("select last_insert_id() as id from t_user_wall_post");
        return $newId->id;
    }
    
    static function updateUserPost ($postId, $comment) {
        
        $postId = mysql_real_escape_string($postId);
        $comment = mysql_real_escape_string($comment);
        Database::query("update t_user_wall_post set comment = '$comment' where id = '$postId'");
    }
    
    static function deleteWallEventById ($eventId) {
        
        $eventId = mysql_real_escape_string($eventId);
        Database::query("delete from t_user_wall_event where id = '$eventId'");
        Database::query("delete from t_user_wall_post where eventid = '$eventId'");
    }
    
    static function deleteUserPostById ($postId) {
        
        $post = self::getUserWallPostById($postId);
        
        $postId = mysql_real_escape_string($postId);
        Database::query("delete from t_user_wall_post where id = '$postId'");
        
        $event = self::getUserWallEventById($post->eventid);
        switch ($event->type) {
            case self::type_wall:
                $otherPosts = self::getUserWallPostsByEventId($post->eventid);
                if (empty($otherPosts)) {
                    self::deleteWallEventById($post->eventid);
                }
                break;
        }
    }
}

?>
