<?php

class CommentsModel {
    
    static function getComment ($id) {
        $id = mysql_real_escape_string($id);
        $result = Database::query("select * from t_comment where id = '$id'");
        return mysql_fetch_object($result);
    }
    
    static function getComments ($moduleId,$page=0) {
        $moduleId = mysql_real_escape_string($moduleId);
        $page = mysql_real_escape_string($page);
        return Database::queryAsArray("select * from t_comment where moduleid = '$moduleId'");
    }
    
    static function saveComment ($moduleId,$id,$username,$comment,$userId,$email) {
        $comment = mysql_real_escape_string($comment);
        if ($id == null) {
            $moduleId = mysql_real_escape_string($moduleId);
            if ($userId == null) {
                $username = mysql_real_escape_string($username);
                $email = mysql_real_escape_string($email);
                Database::query("insert into t_comment (moduleid,name,comment,email,date)
                    values('$moduleId','$username','$comment','$email',now())");
            } else {
                $userId = mysql_real_escape_string($userId);
                Database::query("insert into t_comment (moduleid,comment,userid,date)
                    values('$moduleId','$comment','$userId',now())");
            }
        } else {
            $id = mysql_real_escape_string($id);
            Database::query("update t_comment set 
                comment = '$comment' 
                where id = '$id'");
        }
    }
    
    static function deleteComment ($id) {
        $id = mysql_real_escape_string($id);
        Database::query("delete from t_comment where id = '$id'");
    }
}

?>