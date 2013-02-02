<?php

class NewsletterPageModel {

    static function getNewsletters () {
        return Database::queryAsArray("select id, name, text from t_newsletter");
    }

    static function getNewsletter ($id) {
        $id = mysql_real_escape_string($id);
        return Database::queryAsObject("select id, name, text from t_newsletter where id = '$id'");
    }

    static function createNewsletter ($name,$text) {
        $name = mysql_real_escape_string($name);
        $text = mysql_real_escape_string($text);
        Database::query("insert into t_newsletter(name,text) values('$name','$text')");
        $obj = Database::queryAsObject("select last_insert_id() as newid from t_newsletter");
        return $obj->newid;
    }

    static function updateNewsletter ($id, $name, $text) {
        $id = mysql_real_escape_string($id);
        $name = mysql_real_escape_string($name);
        $text = mysql_real_escape_string($text);
        Database::query("update t_newsletter set name = '$name', text = '$text' where id = '$id'");
    }

    static function deleteNewsletter ($id) {
        $id = mysql_real_escape_string($id);
        Database::query("delete from t_newsletter where id = '$id'");
    }

    static function sendNewsletter ($newsletterId,$groups,$title,$sender) {
	// get list of recipients
	$emails = UsersModel::getUsersByCustomRole($groups);
	// get content of the newsletter
        $content = NewsletterPageModel::getNewsletterContent($newsletterId);
	// send newsletter to each recipient
        foreach ($users as $user) {
            $newContent = str_replace("%name%", $user->username, $content);
            $newContent = str_replace("%email%", $user->email, $newContent);
            EmailUtil::sendHtmlEmail($user->email,$title,$newContent,$sender);
        }	
    }

    static function getEmailsInGroups ($groups) {
	return Database::queryAsArray("select e.id, e.email, e.name from t_newsletter_email e join t_newsletter_emailgroup g on g.userid = e.id where confirmed = 1");
    }

    static function getNewsletterContent($newsletterId) {
	$newsletter = getNewsletter($newsletterId);
	
	$content = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
            <html>
            <head>
                <title></title>
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
            </head>
	    <body>";
        $content .= $newsletter->text;
        $content .= "</body></html>";

	return $content;
    }

}


?>