<?php

require_once 'modules/newsletter/listsPageModel.php';

class SubscribePageModel {
	
	static function subscribe ($email,$name,$groups) {
		$email = mysql_real_escape_string($email);
        	$name = mysql_real_escape_string($name);
		Database::query("insert into t_newsletter_email(email,name) values('email','name')");
		$emailId = Database::queryAsObject("select last_insert_id as id from t_newsletter_email");
		foreach ($groups as $group) {
			SubscribePageModel::addEmailGroup ($emailId->id, $group);
		}
		return $emailId;
	}
	
	static function confirmSubscribe ($id) {
		$id = mysql_real_escape_string($id);
		Database::query("update t_newsletter_email set confirmed = 1 where id = '$id'");
	}
	
	static function addEmailGroup ($emailId, $groupId) {
		$emailId = mysql_real_escape_string($emailId);
		$groupId = mysql_real_escape_string($groupId);
		Database::query("insert into t_newsletter_emailgroup(emailid,roleid) values('$emailId','$groupId')");
	}

	//TODO below here is old


    function getPage ($pageId, $lang) {
        $lang = mysql_real_escape_string($lang);
        $pageId = mysql_real_escape_string($pageId);
        $result = Database::query("select * from t_newsletter_subscribe where pageid = '$pageId' and lang = '$lang'");
        $obj = mysql_fetch_object($result);
        if ($obj == null) {
            Database::query("insert into t_newsletter_subscribe(pageid,lang,content,emailtext,emailsent,confirmed,emailgroup) values('$pageId','$lang','','','','','')");
            return $this->getPage($pageId, $lang);
        }
        return $obj;
    }

    function updatePage ($pageId, $lang, $text, $emailtext, $emailsent, $confirmed, $group) {
        $lang = mysql_real_escape_string($lang);
        $pageId = mysql_real_escape_string($pageId);
        $text = mysql_real_escape_string($text);
        $emailtext = mysql_real_escape_string($emailtext);
        $emailsent = mysql_real_escape_string($emailsent);
        $confirmed = mysql_real_escape_string($confirmed);
        $group = mysql_real_escape_string($group);
        Database::query("update t_newsletter_subscribe set content = '$text', emailtext = '$emailtext', emailsent = '$emailsent', confirmed = '$confirmed', emailgroup = '$group' where pageid = '$pageId' and lang = '$lang'");
    }

    function sendSubscribeConfirmation ($name, $email, $group, $confirmMessage, $pageid) {
        $hash = $this->makeConfirmationHash();
        $this->addSubscription($name, $email, $group, $hash, $pageid);
        // make the confirm message
        $serverName = $_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']);
        $content = "$confirmMessage<br/>
                <a href=\"http://$serverName/?page=$pageid&action=confirm&code=$hash\">
                http://$serverName/?page=$pageid&action=confirm&code=$hash</a>";
        // make it a html email
        $header  = "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html; charset=iso-8859-1\r\n";
        $header .= "From: dontreply@c-line.de\r\n";
        $header .= "Reply-To: dontreply@c-line.de\r\n";
        $header .= "X-Mailer: PHP ".phpversion();
        // send the confirmation email
        $subject = 'c-line newsletter subscription confimation!';
        mail($email,$subject,$content,$header) or die("error sending mail");
    }

    function sendUnSubscribeConfirmation ($email, $confirmMessage, $pageid) {
        $hash = $this->makeConfirmationHash();
        $this->addUnSubscription("", $email, $group, $hash);
        // make the confirm message
        $serverName = $_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']);
        $content = "$confirmMessage<br/>
                <a href=\"http://$serverName/?page=$pageid&action=confirm&code=$hash\">
                http://$serverName/?page=$pageid&action=confirm&code=$hash</a>";
        // make it a html email
        $header  = "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html; charset=iso-8859-1\r\n";
        $header .= "From: dontreply@c-line.de\r\n";
        $header .= "Reply-To: dontreply@c-line.de\r\n";
        $header .= "X-Mailer: PHP ".phpversion();
        // send the confirmation email
        $subject = 'c-line newsletter unsubscribe confirmation!';
        mail($email,$subject,$content,$header) or die("error sending mail");
    }

    function doSubscribe ($pageId,$hash) {
        $hash = mysql_real_escape_string($hash);
        $pageId = mysql_real_escape_string($pageId);
        $result = Database::query("select name, email, emailgroup from t_newsletter_confirm where hash = '$hash' and pageid = '$pageId'");
        $obj = mysql_fetch_object($result);
        if ($obj != null) {
            $listModel = new EmailListModel();
            $listModel->createInListByEmail($obj->email, $obj->emailgroup, $obj->name);
        }
        Database::query("delete from t_newsletter_confirm where hash = '$hash' and pageid = '$pageId'");
    }
    
    function doUnSubscribe ($pageId,$hash) {
        $hash = mysql_real_escape_string($hash);
        $pageId = mysql_real_escape_string($pageId);
        $result = Database::query("select name, email, emailgroup from t_newsletter_confirm where hash = '$hash' and pageid = '$pageId'");
        $obj = mysql_fetch_object($result);
        if ($obj != null) {
            $listModel = new EmailListModel();
            $listModel->deleteFromEmailGroup($obj->email, $obj->emailgroup);
            Database::query("delete from t_newsletter_confirm where hash = '$hash' and pageid = '$pageId'");
        }
    }

    function addSubscription($name, $email, $group, $hash, $pageId) {
        $name = mysql_real_escape_string($name);
        $email = mysql_real_escape_string($email);
        $group = mysql_real_escape_string($group);
        $pageId = mysql_real_escape_string($pageId);
        Database::query("insert into t_newsletter_confirm(name,email,emailgroup,hash,pageid) values('$name','$email','$group','$hash','$pageId')");
    }

    function addUnSubscription($name, $email, $group, $hash) {
        $name = mysql_real_escape_string($name);
        $email = mysql_real_escape_string($email);
        $group = mysql_real_escape_string($group);
        Database::query("insert into t_newsletter_confirm(name,email,emailgroup,hash) values('$name','$email','$group','$hash')");
    }

    function makeConfirmationHash () {
        while (true) {
            $hash = md5('7h1s 1s a s3cr37 7hat 57op5 pe0pl3 gu3ss1ng ha5he5'.time());
            $result = Database::query("select hash from t_newsletter_confirm where hash = '$hash'");
            $row = mysql_fetch_array($result);
            if ($row == null || $row['hash_c'] == null)
                return $hash;
        }
    }
}

?>