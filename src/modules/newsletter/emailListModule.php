<?php

require_once 'core/plugin.php';
require_once 'modules/newsletter/emailListModel.php';

class EmailListModule extends XModule {

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {

        switch (parent::getAction()) {

            case "collectEmails":

                $matches = array();
                $pattern = '/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i';
                preg_match_all($pattern,parent::post("emailList"),$matches);
                if (is_array($matches)) {
                    $matches = current($matches);
                }
                $countNewEmails = EmailListModel::insertEmails($matches);
                $_REQUEST['emailList.new.count'] = $countNewEmails;
                break;

        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {
        
        switch (parent::getAction()) {
            default:
                $this->printMainView();
        }
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("emailList.edit");
    }
    
    function getStyles () {
	return array("css/emailList.css");
    }

    function printMainView () {

        $countEmails = EmailListModel::getCountEmails();
        
        ?>
        <div class="panel emailListPanel">
            <?php
            if (isset($_REQUEST['emailList.new.count'])) {
                ?>
                <div class="alignRight"><b>
                    <?php
                    echo $_REQUEST['emailList.new.count']." new emails inserted!";
                    ?>
                </b></div>
                <?php
            }
            ?>
            <form method="post" action="<?php echo parent::link(array("action"=>"collectEmails")); ?>">
                <?php /*
                <div class="alignRight">
                    <?php echo parent::getTranslation("emailList.text.count",true,null,array("%countEmails%"=>$countEmails)); ?>
                </div>
                */ ?>
                <div class="alignRight">
                    Currently <?php echo $countEmails; ?> emails in the database.
                </div>
                <table class="formTable"><tr><td>
                    <?php echo parent::getTranslation("emailList.form.label"); ?>
                </td><td>
                    <?php echo InputFeilds::printTextArea("emailList", 'Paste text with email here!', "expand", 10); ?>
                </td></tr></table>
                <hr/>
                <div class="alignRight">
                    <button type="sumit" class="jquiButton"><?php echo parent::getTranslation("emailList.form.button"); ?></button>
                </div>
            </form>
        </div>
        <script>
        </script>
        <?php
    }
    
}

?>