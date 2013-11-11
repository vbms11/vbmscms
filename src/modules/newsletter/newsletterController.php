<?php

include_once('modules/newsletter/newsletterModel.php');

class NewsletterController {

        static function sendNewsletter ($newsletterId,$groups,$title,$sender) {
	// get list of recipients
	$users = UsersModel::getUsersByCustomRole($groups);
	// get content of the newsletter
        $content = self::getNewsletterContent($newsletterId);
	// send newsletter to each recipient
        foreach ($users as $user) {
            $newContent = str_replace("%name%", $user->username, $content);
            $newContent = str_replace("%email%", $user->email, $newContent);
            EmailUtil::sendHtmlEmail($user->email,$title,$newContent,$sender);
        }	
    }

    static function getNewsletterContent($newsletterId) {
        
	$newsletter = self::getNewsletter($newsletterId);
	
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