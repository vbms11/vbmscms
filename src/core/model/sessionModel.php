<?php

class SessionModel {
    
    static function createSessionName () {
        $name = null;
        while (true) {
            $name = "guest_".Common::rand(1000,10000000);
            $result = Database::queryAsObject("select 1 from t_session where name = '$name'");
            if (empty($result)) {
                return $name;
            }
        }
    }
    
    static function getUsersOnline () {
        return Database::queryAsArray("select s.sessionid, s.ip, u.id, u.username, s.name from t_session s left join t_user u on s.userid = u.id");
    }
    
    static function pollSession ($sessionId,$sessionKey) {
        $sessionId = mysql_real_escape_string($sessionId);
        $sessionKey = mysql_real_escape_string($sessionKey);
        // check if session exists
        $rSes = Database::queryAsObject("select 1 as sesexist from t_session where sessionid = '$sessionId' and sessionkey = '$sessionKey'");
        // update the last poll time
        if ($rSes != null && $rSes->sesexist == "1") {
            Database::query("update t_session set lastpolltime = now() where sessionid = '$sessionId' and sessionkey = '$sessionKey'");
            return true;
        } else {
            // session not valid
            return false;
        }
    }
    
    static function startSession ($sessionId,$sessionKey,$ip) {
        $sessionId = mysql_real_escape_string($sessionId);
        $sessionKey = mysql_real_escape_string($sessionKey);
        $ip = mysql_real_escape_string($ip);
        $name = SessionModel::createSessionName();
        Database::query("insert into t_session (lastpolltime,sessionid,sessionkey,ip,name) values(now(),'$sessionId','$sessionKey','$ip','$name')");
    }
    
    static function endSession ($sessionId) {
        $sessionId = mysql_real_escape_string($sessionId);
        Database::query("delete from t_session where sessionid = '$sessionId'");
    }
    
    static function setSessionUser ($sessionId, $userId) {
        $sessionId = mysql_real_escape_string($sessionId);
        if ($userId == null) {
            $userIdStr = "null";
            $name = SessionModel::createSessionName();
            $nameStr = "'$name'";
        } else {
            $userIdStr = "'".mysql_real_escape_string($userId)."'";
            $nameStr = "(select username from t_user where id = $userIdStr)";
        }
        Database::query("update t_session set userid = $userIdStr, name = $nameStr, logintime = now() where sessionid = '$sessionId'");
    }
    
    static function cleanOldSessions () {
        Database::query("delete from t_session where lastpolltime < now() - INTERVAL ".$GLOBALS['cmsSessionExpireTime']." MINUTE");
    }
}

?>