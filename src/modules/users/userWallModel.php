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
    
    static function getUserWallPost ($wallPostId) {
        
        $wallPostId = mysql_real_escape_string($wallPostId);
        return Database::queryAsObject("select * from t_user_wall_post where id = '$wallPostId'");
    }
    
    static function getUserWallPosts ($userId) {

        $userId = mysql_real_escape_string($userId);
        return Database::queryAsArray("select * from t_user_wall_post where userid = '$userId' order by date desc");
    }

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
            $parentPost = self::getUserWallPost($parent);
            if (empty($parentPost)) {
                $error["parent"] = "Post dose not exist";
            }
        }
        return $errors;
    }

    function createUserWallPost ($userId, $srcUserId, $comment, $parent = null) {

        $userId = mysql_real_escape_string($userId);
        $srcUserId = mysql_real_escape_string($srcUserId);
        $comment = mysql_real_escape_string($comment);
        if ($parent == null) {
            $parentSql = "null";
        } else {
            $parentSql = "'".mysql_real_escape_string($parent)."'";
        }
        Database::query("insert into t_user_wall_post (userid,srcuserid,comment,date,parent)
            values ('$userId','$srcUserId','$comment',now(),$parentSql)");
        $newId = Database::query("select last_insert_id() as id from t_user_wall_post");
        return $newId->id;
    }
     
}

?>
