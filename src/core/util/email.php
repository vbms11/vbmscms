<?php

class EmailUtil {

    /*
     * sends a plain text email
     */
    static function sendEmail ($to,$subject,$content,$from) {
        if (!empty($to)) {
            $header  = "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/plain; charset=iso-8859-1\r\n";
            $header .= "From: $from\r\n";
            $header .= "Reply-To: $from\r\n";
            $header .= "X-Mailer: PHP ". phpversion();
            Log::info("sending email: to = '$to' subject = '$subject'");
            mail($to,$subject,$content,$header) or Log::error("error sending mail");
        }
    }

    /*
     * sends a html email
     */
    static function sendHtmlEmail ($to,$subject,$content,$from) {
        // make it a html email
        if (!empty($to)) {
            $header  = "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html; charset=iso-8859-1\r\n";
            $header .= "From: $from\r\n";
            $header .= "Reply-To: $from\r\n";
            $header .= "X-Mailer: PHP ". phpversion();
            Log::info("sending email: to = '$to' subject = '$subject'");
            mail($to,$subject,$content,$header) or Log::error("error sending mail");
        }
        
    }
}
