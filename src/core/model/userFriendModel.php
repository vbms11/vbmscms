<?php

/**
 * Description of UserFriendModel
 *
 * @author vbms
 */
class UserFriendModel {
    
    static function isFriend ($userId, $friendUserId) {
        $userId = mysql_real_escape_string($userId);
        $friendUserId = mysql_real_escape_string($friendUserId);
        $result = Database::queryAsObject("select 1 as friend from t_user_friend uf where ((uf.srcuserid = '$userId' and uf.dstuserid = '$friendUserId') or (uf.dstuserid = '$userId' and uf.srcuserid = '$friendUserId')) and uf.confirmed = '1'");
        $ret = false;
        if (empty($result)) {
           $ret = false;
        } else if ($result->friend == "1") {
            $ret = true;
        }
        return $ret;
    }
    
    static function getCountUserFriends ($userId) {
        $userId = mysql_real_escape_string($userId);
        return Database::queryAsArray("select count(*) from t_user_friend where (srcuserid = '$userId' or dstuserid = '$userId') and confirmed = '1'");
    }
    
    static function getUserFriends ($userId) {
        $userId = mysql_real_escape_string($userId);
        return Database::queryAsArray("select uf.*, u.id as friendid, u.username as username from t_user_friend uf join t_user u on (uf.srcuserid = '$userId' and uf.dstuserid = u.id) or (uf.dstuserid = '$userId' and uf.srcuserid = u.id) where (uf.srcuserid = '$userId' or uf.dstuserid = '$userId') and uf.confirmed = '1' order by u.username");
    }
    
    static function getUserFriendRequests ($userId) {
        $userId = mysql_real_escape_string($userId);
        return Database::queryAsArray("select uf.*, u.id as friendid, u.username as username from t_user_friend uf join t_user u on (uf.dstuserid = '$userId' and uf.srcuserid = u.id) where uf.dstuserid = '$userId' and uf.confirmed = '0' order by u.username");
    }
    
    static function getUserFriendRequest ($userId, $friendId) {
        $userId = mysql_real_escape_string($userId);
        $friendId = mysql_real_escape_string($friendId);
        return Database::queryAsObject("select uf.*, u.id as friendid, u.username as username from t_user_friend uf join t_user u on uf.srcuserid = '$userId' and uf.dstuserid = u.id where uf.dstuserid = '$friendId'");
    }
    
    static function getPendingUserFriendRequests ($userId) {
        $userId = mysql_real_escape_string($userId);
        return Database::queryAsArray("select uf.*, u.id as friendid, u.username as username from t_user_friend uf join t_user u on (uf.srcuserid = '$userId' and uf.dstuserid = u.id) where uf.srcuserid = '$userId' and uf.confirmed = '0' order by u.username");
    }
    
    static function confirmUserFriendRequest ($userFriendId) {
        $userFriendId = mysql_real_escape_string($userFriendId);
        Database::query("update t_user_friend set confirmed = '1' where id = '$userFriendId'");
    }
    
    static function createUserFriendRequest ($srcUserId, $dstUserId) {
        $srcUserId = mysql_real_escape_string($srcUserId);
        $dstUserId = mysql_real_escape_string($dstUserId);
        Database::query("insert into t_user_friend (srcuserid,dstuserid,confirmed,createdate) values('$srcUserId','$dstUserId',0,now())");
        $result = Database::queryAsObject("select last_insert_id() as id from t_user_friend");
        return $result->id;
    }
    
    static function deleteUserFriend ($userFriendId) {
        $userFriendId = mysql_real_escape_string($userFriendId);
        Database::query("delete from t_user_friend where id = '$userFriendId'");
    }
}

?>
