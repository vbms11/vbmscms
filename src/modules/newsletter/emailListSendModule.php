<?php

require_once 'core/plugin.php';
require_once 'modules/newsletter/emailListModel.php';

class EmailListSendModule extends XModule {

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {

        switch (parent::getAction()) {

            case "sendEmails":
                $totalEmails = EmailListModel::getCountEmails();
                $_SESSION['emailList.sent.count'] = 0;
                $_SESSION['emailList.sent.total'] = $totalEmails;
                $_SESSION['emailList.email.sender'] = parent::post("emailSender");
                $_SESSION['emailList.email.title'] = parent::post("emailTitle");
                $_SESSION['emailList.email.message'] = parent::post("emailText");
                $_SESSION['emailList.email.sent'] = 0;
                
                break;
            
            case "doSendEmails":
                
                $emailsPage = parent::get("page");
                $emailsToSend = 100;
                $emails = EmailListModel::getEmails();
                $countEmails = count($emails);
                
                $i = 0;
                for ($i = $emailsPage * $emailsToSend; $i < $countEmails && $i < ($emailsPage * $emailsToSend) + $emailsToSend; $i++) {
                    $email = $emails[$i]->email;
                    try {
                        
                        EmailUtil::sendEmail($email, $_SESSION['emailList.email.title'], $_SESSION['emailList.email.message'], $_SESSION['emailList.email.sender']);
                        $_SESSION['emailList.email.sent']++;
                    } catch (Exception $e) {
                    }
                }
                
                $progress = (($i) / count($emails)) * 100;
                Context::setReturnValue($progress);
                break;
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {
        
        switch (parent::getAction()) {
            case "sendEmails":
                $this->printSendingEmailsView();
                break;
            case "sendReport":
                $this->printSendReportView();
                break;
            default:
                $this->printMainView();
        }
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("emailSent.edit");
    }
    
    function getStyles () {
	return array("css/emailList.css");
    }
    
    function printSendReportView () {
        ?>
        <div class="panel emailSendPanel">
            <h1><?php echo parent::getTranslation("emailSend.report.title"); ?></h1>
            <p>Email has been sent to <?php echo $_SESSION['emailList.email.sent']; ?> addresses!</p>
        </div>
        <?php
    }
    
    function printSendingEmailsView () {
        ?>
        <div class="panel emailSendPanel">
            <h1><?php echo parent::getTranslation("emailSend.sending.title"); ?></h1>
            <div id="progressbar"></div>
            <script>
            $( "#progressbar" ).progressbar({
                value: 0
            });
            var currentEmailBatch = 0;
            function scheduleNextEmailBatch (content) {
                var progress = parseFloat(content);
                $( "#progressbar" ).progressbar({
                    value: progress
                });
                if (progress < 100) {
                    currentEmailBatch++;
                    window.setTimeout("sendNextEmailBatch()",50);
                } else {
                    callUrl("<?php echo parent::link(array("action"=>"sendReport")); ?>");
                }
            }
            function sendNextEmailBatch () {
                $.ajax({
                    "url": "<?php echo parent::ajaxLink(array("action"=>"doSendEmails")) ?>&page="+currentEmailBatch,
                    "context": document.body,
                    "success": function(data){
                        scheduleNextEmailBatch(data);
                    }
                });
            }
            sendNextEmailBatch();
            </script>
        </div>
        <?php
    }
    
    function printMainView () {
        
        ?>
        <div class="panel emailSendPanel">
            <h1><?php echo parent::getTranslation("emailSend.form.title"); ?></h1>
            <form method="post" action="<?php echo parent::link(array("action"=>"sendEmails")); ?>">
                <table class="formTable"><tr><td>
                    <?php echo parent::getTranslation("emailSend.form.label.sender"); ?>
                </td><td>
                    <?php echo InputFeilds::printTextFeild("emailSender", Config::getAdminEmail(), "expand", 10); ?>
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("emailSend.form.label.title"); ?>
                </td><td>
                    <?php echo InputFeilds::printTextFeild("emailTitle"); ?>
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("emailSend.form.label.message"); ?>
                </td><td>
                    <?php echo InputFeilds::printTextArea("emailText", '', "expand", 10); ?>
                </td></tr></table>
                <hr/>
                <div class="alignRight">
                    <button type="sumit" class="jquiButton"><?php echo parent::getTranslation("emailSend.form.button"); ?></button>
                </div>
            </form>
        </div>
        <script>
        </script>
        <?php
    }
    
}

?>