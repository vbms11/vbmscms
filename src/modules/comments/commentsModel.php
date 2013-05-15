<?php

class CommentsModel {
    
    static function getComment ($id) {
        $id = mysql_real_escape_string($id);
        $result = Database::query("select * from t_comment where id = '$id'");
        return mysql_fetch_object($result);
    }
    
    static function getComments ($dataType, $dataId = null) {
        $dataType = mysql_real_escape_string($dataType);
        if ($dataId != null) {
            $dataId = mysql_real_escape_string($dataId);
            return Database::queryAsArray("select * from t_comment where datatype = '$dataType' and dataid = '$dataId'");
        }
        return Database::query("select * from t_comment where datatype = '$dataType'");
    }
    
    static function saveComment ($id,$dataType,$dataId,$userId,$comment) {
        $dataId = mysql_real_escape_string($dataId);
        $userId = mysql_real_escape_string($userId);
        $comment = mysql_real_escape_string($comment);
        $dataType = mysql_real_escape_string($dataType);
        if ($id == null) {
            Database::query("insert into t_comment (datatype,dataid,userid,comment,date)
                values('$dataType',$dataId','$userId','$comment',now())");
        } else {
            $id = mysql_real_escape_string($id);
            Database::query("update t_comment set 
                userid = '$userId',  comment = '$comment', 
                datatype = '$dataType', dataid = '$dataId'
                where id = '$id'");
        }
    }
    
    static function deleteComment ($id) {
        $id = mysql_real_escape_string($id);
        Database::query("delete from t_comment where id = '$id'");
    }
    
    static function deleteCommentByType ($dataType, $dataId = null) {
        $dataType = mysql_real_escape_string($dataType);
        if ($dataId != null) {
            $dataId = mysql_real_escape_string($dataId);
            Database::query("delete from t_comment where datatype = '$dataType' and dataid = '$dataId'");
        } else {
            Database::query("delete from t_comment where datatype = '$dataType'");
        }
    }
}

?>