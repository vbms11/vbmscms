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
    
    static function validateWallPost ($userId, $srcUserId, $comment, $parent = null) {
        $errors = array();
        if (strlen($comment) > 5000) {
            $errors["comment"] = "Maximum 5000 characters allowed!";
        }
        if ($userId != $srcUserId) {
            // check if users are friends
        }
        // check if parent exists
        if ($parent != null) {
            $parentPost = self::getUserPost($parent);
            if (empty($parentPost)) {
                $error["parent"] = "Post dose not exist";
            }
        }
        return $errors;
    }
    
    static function getUserPost ($wallPostId) {
        
        $wallPostId = mysql_real_escape_string($wallPostId);
        return Database::queryAsObject("select * from t_user_wall_post where id = '$wallPostId'");
    }
    
    static function getUserImagePosts ($imageId) {
        
        return self::getUserPosts(self::type_image, $imageId);
    }
    
    static function getUserWallPosts ($userId) {
        
        return self::getUserPosts(self::type_wall, $userId);
    }
    
    static function getUserPosts ($type, $typeId) {
        
        $type = mysql_real_escape_string($type);
        $typeId = mysql_real_escape_string($typeId);
        return Database::queryAsArray("select * from t_user_wall_post where typeid = '$typeId' and type = '$type' order by date desc");
    }
    
    static function createUserImagePost ($imageId, $srcUserId, $comment, $parent = null) {
        
        return self::createUserPost(self::type_image, $imageId, $srcUserId, $comment, $parent);
    }

    static function createUserWallPost ($userId, $srcUserId, $comment, $parent = null) {
        
        return self::createUserPost(self::type_wall, $userId, $srcUserId, $comment, $parent);
    }
    
    static function createUserPost ($type, $typeId, $srcUserId, $comment, $parent = null) {

        $typeId = mysql_real_escape_string($typeId);
        $srcUserId = mysql_real_escape_string($srcUserId);
        $comment = mysql_real_escape_string($comment);
        if ($parent == null) {
            $parentSql = "null";
        } else {
            $parentSql = "'".mysql_real_escape_string($parent)."'";
        }
        Database::query("insert into t_user_wall_post (typeid,type,srcuserid,comment,date,parent)
            values ('$typeId','$type','$srcUserId','$comment',now(),$parentSql)");
        $newId = Database::query("select last_insert_id() as id from t_user_wall_post");
        return $newId->id;
    }
    
    static function updateUserPost ($postId, $comment) {
        
        $postId = mysql_real_escape_string($postId);
        $comment = mysql_real_escape_string($comment);
        Database::query("update t_user_wall_post set comment = '$comment' where id='$postId'");
    }
    
    static function deleteUserPost ($postId) {
        
        $postId = mysql_real_escape_string($postId);
        Database::query("delete from t_user_wall_post where id = '$postId' or parent = '$postId'");
    }
}

?>
