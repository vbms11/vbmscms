<?php

include_once('modules/newsletter/listsPageModel.php');
include_once('modules/newsletter/newsletterPageModel.php');

class NewsletterController {

    function sendNewsletter ($newsletterId,$groupId,$title,$sender) {

        $emailListsModel = new EmailListModel();
        $emails = $emailListsModel->getEmailList($groupId);

        $content = $this->getNewsletterContent($newsletterId);

        // the html email header
        $header  = "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html; charset=iso-8859-1\r\n";
        $header .= "From: $sender\r\n";
        $header .= "Reply-To: $sender\r\n";
        $header .= "X-Mailer: PHP ". phpversion();

        foreach ($emails as $email) {
            $newContent = str_replace("%name%", $email->name, $content);
            $newContent = str_replace("%email%", $email->email, $content);
            mail($email->email,$title,$newContent,$header);
        }
    }

    function getNewsletterContent($newsletterId) {

        $newsletterModel = new NewsletterPageModel();
        $newsletter = $newsletterModel->getNewsletter($newsletterId);
        
        $content = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
            <html>
            <head>
                <title></title>
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
                <style>
                    body {
                        background-color: rgb(211,228,242);
                        text-align: center;
                        margin: 10px auto;
                        font-family: Arial, Helvetica, sans-serif;
                        font-size: 11px;
                        color:#333333;
                    }
                    #headerDiv {
                        width: 511px;
                        height: 170px;
                        border-bottom: 1px solid silver;
                    }
                    #topShadow {
                    }
                    #pageShadow {
                        width: 521px;
                        background: url('".NavigationModel::getSitePath()."img/newsletter/bg_content.gif') repeat-y;
                    }
                    #bottomShadow {
                    }
                    #page {
                        margin-left:5px;
                        margin-right:5px;
                    }
                    .logoImage {
                        padding-left:1px;
                        float:left;
                    }
                    #contentDiv {
                        padding: 15px;
                    }
                    .headerText {
                        float:right;
                        padding-top: 120px;
                        padding-right: 20px;
                        color: silver;
                        font-size: 22px;
                    }
                </style>
            </head>
            <body>
                <div align='center'>
                    <div id='topShadow'><img src='".NavigationModel::getSitePath()."img/newsletter/top_border.gif' alt=''/></div>
                    <div id='pageShadow'>
                        <div id='page' align='left'>
                            <div id='headerDiv'>
                                <img class='logoImage' src='".NavigationModel::getSitePath()."img/newsletter/logo.gif' alt=''/>
                                <div class='headerText'>Newsletter</div>
                            </div>
                            <div id='contentDiv'>
                            ";
        $content .= $newsletter->text;
        $content .= "
                            </div>
                        </div>
                    </div>
                    <div id='bottomShadow'><img src='".NavigationModel::getSitePath()."img/newsletter/bottom_border.gif' alt=''/></div>
                </div>
            </body>
            </html>";

        return $content;
    }
}

?>