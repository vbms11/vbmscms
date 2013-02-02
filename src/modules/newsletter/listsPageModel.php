<?php

class EmailListModel {
    
    static function getEmailGroups () {
    	return Common::toMap(RolesModel::getCustomRoles(),"id","name");
    }

    static function getEmailList ($roleId) {
        $roleId = mysql_real_escape_string($roleId);
        return Database::queryAsArray("select e.id, e.email, e.name, e.confirmed, eg.roleid from t_newsletter_email e join t_newsletter_emailgroup eg on eg.emailid = e.id where eg.roleid = '$roleId'");
    }

    static function getEmail ($id) {
        $id = mysql_real_escape_string($id);
        return Database::queryAsObject("select * from t_newsletter_email where id = '$id'");
    }

    static function updateEmail ($id, $email, $name) {
        $id = mysql_real_escape_string($id);
        $email = mysql_real_escape_string($email);
        $name = mysql_real_escape_string($name);
        Database::query("update t_newsletter_email set email = '$email', name = '$name' where id = '$id'");
    }

    static function createEmail ($email, $name) {
        $email = mysql_real_escape_string($email);
        $name = mysql_real_escape_string($name);
	$results = Database::queryAsArray("select id from t_newsletter_email email = '$email'");
        if (count($results) == 0) {
		Database::query("insert into t_newsletter_email(email,name) values('$email','$name')");
		$newObj = Database::queryAsObject("select last_insert_id() as id from t_newsletter_email");
		return $newObj->id;
	} else {
		return $results[0]->id;
	}
    }
    
    static function addEmailToGroup ($emailId,$roleId) {
	$emailId = mysql_real_escape_string($emailId);
	$roleId = mysql_real_escape_string($roleId);
        Database::query("insert into t_newsletter_emailgroup(emailid,roleid) values('$emailId','$roleId')");
    }
    
    static function deleteFromEmailGroup ($emailId,$roleId) {
        $emailId = mysql_real_escape_string($emailId);
	$roleId = mysql_real_escape_string($roleId);
        Database::query("delete from t_newsletter_emailgroup where emailid = '$emailId' and roleid = '$roleId'");
    }
}

?>