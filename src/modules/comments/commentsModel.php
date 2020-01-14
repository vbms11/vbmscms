<?php

class CommentsModel {
    
    static function getComment ($id) {
        $id = Database::escape($id);
        return Database::queryAsObject("select * from t_comment where id = '$id'");
    }
    
    static function getComments ($moduleId,$page=0) {
        $moduleId = Database::escape($moduleId);
        $page = Database::escape($page);
        return Database::queryAsArray("select * from t_comment where moduleid = '$moduleId'");
    }
    
    static function saveComment ($moduleId,$id,$username,$comment,$userId,$email) {
        $comment = Database::escape($comment);
        if ($id == null) {
            $moduleId = Database::escape($moduleId);
            if ($userId == null) {
                $username = Database::escape($username);
                $email = Database::escape($email);
                Database::query("insert into t_comment (moduleid,name,comment,email,date)
                    values('$moduleId','$username','$comment','$email',now())");
            } else {
                $userId = Database::escape($userId);
                Database::query("insert into t_comment (moduleid,comment,userid,date)
                    values('$moduleId','$comment','$userId',now())");
            }
        } else {
            $id = Database::escape($id);
            Database::query("update t_comment set 
                comment = '$comment' 
                where id = '$id'");
        }
    }
    
    static function deleteComment ($id) {
        $id = Database::escape($id);
        Database::query("delete from t_comment where id = '$id'");
    }
    
    static function deleteCommentByModuleId ($moduleId) {
        $id = Database::escape($id);
        Database::query("delete from t_comment where moduleid = '$moduleId'");
    }
}

?>