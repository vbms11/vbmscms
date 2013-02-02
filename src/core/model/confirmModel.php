<?php

class ConfirmModel {

    static function sendConfirmation ($to, $subject, $content, $from, $moduleId, $args, $expireDays) {

        // register
        $hash = ConfirmModel::makeConfirmationHash();
        ConfirmModel::registerConfirmationAction($hash,$moduleId,$args,$expireDays);
        ConfirmModel::removeExpiredConfirmationActions();

        // build the message
        $serverName = NavigationModel::getSitePath();
        $confirmLink = "<a href=\"$serverName?static=confirm&action=confirm&code=$hash\">Click Here To Confirm</a>";
        $content = str_replace("<link>",$confirmLink,$content);

        // send the message
        EmailUtil::sendHtmlEmail($to,$subject,$content,$from);
    }

    static function registerConfirmationAction ($hash, $moduleId, $args, $expireDays) {
        $hash = mysql_real_escape_string($hash);
        $moduleId = mysql_real_escape_string($moduleId);
        $expireDays = mysql_real_escape_string($expireDays);
        $args = mysql_real_escape_string(serialize($args));
        Database::query("insert into t_confirm(hash,moduleid,expiredate,args) values('$hash','$moduleId','now()+days('$expireDays')','$args')");
    }

	function getConfirm ($hash) {
		$hash = mysql_real_escape_string($hash);
		$confirm = Database::queryAsObject("select * from t_confirm where hash = 'hash'");
		$confirm->args = unserialize($confirm->args);
		return $confirm;
	}
	
    static function removeExpiredConfirmationActions () {
        Database::query("delete from t_confirm where expiredate < now()");
    }

    static function invokeConfirmationAction ($hash) {
        $result = Database::query("select * from t_confirm where hash ='$hash'");
        $obj = mysql_fetch_object($result);
        if ($obj != null) {
            Database::query("delete from t_confirm where hash = '$hash'");
            NavigationModel::redirect($obj->url);
        }
    }
	
    // makes the confirmation hash
    static function makeConfirmationHash () {
        while (true) {
            $hash = Common::randHash();
            $result = Database::query("select hash from t_confirm where hash = '$hash'");
            if (mysql_fetch_object($result) == null)
                return $hash;
        }
    }

}
?>
