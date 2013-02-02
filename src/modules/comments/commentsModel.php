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
        $result = Database::query("select * from t_comment where moduleid = '$moduleId'");
        $comments = array();
        while ($obj = mysql_fetch_object($result)) {
            $comments[] = $obj;
        }
        return $comments;
    }
    
    static function saveComment ($moduleId,$id,$username,$comment) {
        $moduleId = mysql_real_escape_string($moduleId);
        $username = mysql_real_escape_string($username);
        $comment = mysql_real_escape_string($comment);
        if ($id == null) {
            Database::query("insert into t_comment (moduleid,name,comment,date)
                values('$moduleId','$username','$comment',now())");
        } else {
            $id = mysql_real_escape_string($id);
            Database::query("update t_comment set 
                name = '$username',  comment = '$comment' 
                where id = '$id'");
        }
    }
    
    static function deleteComment ($id) {
        $id = mysql_real_escape_string($id);
        Database::query("delete from t_comment where id = '$id'");
    }
}

?>