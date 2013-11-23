<?php

require_once('core/plugin.php');

class FormsView extends XModule {
    
    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {

        switch (parent::getAction()) {
            case "save":
                parent::param("orderForm",$_POST["orderForm"]);
                parent::param("submitMessage",$_POST["submitMessage"]);
                parent::param("roleGroup",$_POST['roleGroup']);
                parent::param("sendEmail",$_POST['sendEmail']=="1" ? "1" : "0");
                parent::param("emailUser",$_POST['emailUser']);
                parent::param("emailText",$_POST['emailText']);
                parent::param("emailSubject",$_POST['emailSubject']);
                parent::param("emailSender",$_POST['emailSender']);
                parent::param("captcha",$_POST['captcha']=="1" ? "1" : "0");
                parent::redirect();
                break;
            case "createObject":
                
                if (parent::param("captcha") == "1" && Captcha::validateInput("captcha") != true) {
                    parent::redirect(array("action"=>"captchaWrong"));
                    break;
                }
                
                $orderId = DynamicDataView::createObject(parent::param("orderForm"));
                
		if (parent::param("sendEmail") == "1") {

			// send info mail
                	$emailText = parent::param("emailText");
                
                	$detailsText = "<table>";
                	$columns = VirtualDataModel::getColumns(parent::param("orderForm"));
                	$objectAttribs = VirtualDataModel::getRowByObjectIdAsArray(parent::param("orderForm"), $orderId);
                	$rowNamesValues = array();
                	$oddColl = true;
                	foreach ($columns as $column) {
                    		if ($column->edittype == VirtualDataModel::$dm_type_boolean) {
                        		$detailsText .= "<tr ".($oddColl ? "style='background-color:rgb(240,240,240);'" : "")."><td style='text-align:right;'> </td><td>".Common::htmlEscape($objectAttribs[$column->name])." - ".Common::htmlEscape($column->name)."</td></tr>";
                    		} else {
                        		$detailsText .= "<tr ".($oddColl ? "style='background-color:rgb(240,240,240);'" : "")."><td style='text-align:right;'>".Common::htmlEscape($column->name).": </td><td>".Common::htmlEscape($objectAttribs[$column->name])."</td></tr>";
                    		}
                    		$oddColl = !$oddColl;
                	}
                	$detailsText .= "</table>";

                	$emailText = str_replace("&lt;detailText&gt;", $detailsText, $emailText);
                	
                	// send to role group
                    	$emails = UsersModel::getUsersEmailsByCustomRoleId(parent::param("roleGroup"));
                    	foreach ($emails as $email) {
                        	EmailUtil::sendHtmlEmail($email, parent::param("emailSubject"), $emailText, parent::param("emailSender"));
                    	}
		}
                break;
            case "edit":
                parent::focus();
                break;
            default:
                break;
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {

        switch (parent::getAction()) {
            case "edit":
                $this->printEditView();
                break;
            case "captchaWrong":
                $this->printCaptchaWrong();
		break;
            case "createObject":
		$this->printObjectCreated();
            default:
                $this->printMainView();
                break;
        }
    }
    /**
     * called when module is installed
     */
    function install () {

    }

    /**
     * returns style sheets used by this module
     */
    function getStyles () {

    }

    /**
     * returns scripts used by this module
     */
    function getScripts () {
        return array("js/datamodel.js");
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("dm.forms.edit");
    }
    
    function printCaptchaWrong () {
        ?>
        <div class="panel">
            <h3>Captcha Code Wrong:</h3>
            <b>Sorry you entered the wrong security code!</b>
        </div>
        <?php
    }
    
    function printObjectCreated () {
        ?>
        <div id="pnlObjectCreated" title="Mitteilung">
            <?php echo Common::htmlEscape(parent::param("submitMessage")); ?>
        </div>
        <script>
        $("#pnlObjectCreated").dialog({
            autoOpen: true,
            height: 300,
            width: 350,
            modal: true,
            buttons: {
                "OK": function() {
                    $(this).dialog("close");
                }
            }
        });
        </script>
        <?php
    }
    
    function printEditView () {
        $tables = VirtualDataModel::getTables();
        if (count($tables) > 0) {
            $valueNameArray = Common::toMap($tables, "name", "name");
            ?>
            <div class="panel">
                <h3>Configure Data View</h3>
                <form method="post" id="formForm" action="<?php echo parent::link(array("action"=>"save")); ?>">
                    <table width="100%" style="white-space: nowrap;"><tr><td>
                        <b>Select Form:</b>
                    </td><td class="expand">
                        <?php
                        InputFeilds::printSelect("orderForm", parent::param("orderForm"), $valueNameArray);
                        ?>
                    </td><td>
                        <button id="configTable">Configure</button>
                    </td></tr><tr><td>
                        <b>Send Email:</b>
                    </td><td class="expand" colspan="2">
                        <?php
                        InputFeilds::printCheckbox("sendEmail", parent::param("sendEmail"));
                        ?>
                    </td></tr><tr><td>
                        <b>Captcha:</b> 
                    </td><td class="expand" colspan="2">
                        <?php
                        InputFeilds::printCheckbox("captcha", parent::param("captcha"));
                        ?>
                    </td></tr><tr><td>
                        <b>Submit Message:</b> 
                    </td><td class="expand" colspan="2">
                        <?php
                        InputFeilds::printTextArea("submitMessage", parent::param("submitMessage"));
                        ?>
                    </td></tr></table>
                    <br/>
                    
                    <div id="notificationEmailDiv">
                        <hr/>
                        <h3>Configure Notification Email</h3>
                        <table width="100%" style="white-space: nowrap;"><tr><td>
                            <b>Rolegroup that receives email:</b>
                        </td><td class="expand">
                            <?php
                            InputFeilds::printSelect("roleGroup", parent::param("roleGroup"), Common::toMap(RolesModel::getCustomRoles(),"id","name"));
                            ?>
                        </td></tr><tr><td>
                            <b>Email Subject:</b>
                        </td><td class="expand">
                            <?php
                            InputFeilds::printTextFeild("emailSubject", parent::param("emailSubject"));
                            ?>
                        </td><tr><td>
                            <b>Email Sender:</b>
                        </td><td class="expand">
                            <?php
                            InputFeilds::printTextFeild("emailSender", parent::param("emailSender"));
                            ?>
                        </td></tr><tr><td colspan="2" style="white-space: normal;">
                            <br/><b><?php echo Common::htmlEscape('Here you can configure the text or the order email. "<detailText>" will be replaced with the content or the orderform.'); ?></b><br/>
                        </td></tr><tr><td class="expand" colspan="2">
                            <?php
                            InputFeilds::printHtmlEditor("emailText", parent::param("emailText"));
                            ?>
                        </td></tr></table>
                    </div>
                    <hr/>
                    <div style="text-align:right;">
                        <button id="saveButton">Save</button>
                    </div>
                </form>
            </div>

            <script>
            $('#configTable').button().click(function (e) {
                callUrl("<?php echo NavigationModel::createStaticPageLink("configTables",array(),false); ?>",{"table":$("#orderForm").val()});
                e.preventDefault();
            })
            $('#saveButton').button().click(function () {
                $('#formForm').submit();
            })
            $('#sendEmail').click(function(){
                $('#notificationEmailDiv').slideToggle("slow");
            });
            </script>
            <?php
        }
    }
    
    function printMainView () {
        
        $form = parent::param("orderForm");
        if (!Common::isEmpty($form)) {
            
            ?>
            <div class="panel">
                <form method="post" action="<?php echo parent::link(array("action"=>"createObject")); ?>">
                    <?php
                    DynamicDataView::renderCreateObject($form, parent::link(), parent::link());
                    echo "<hr/>";
                    if (parent::param("captcha") == "1") {
                        InputFeilds::printCaptcha("captcha");
                        echo "<hr/>";
                    }
                    ?>
                    <div style="text-align:right;">
                        <button class="jquiButton" type="submit" onclick="return validateForm(<?php echo DynamicDataView::renderValidateJs($form); ?>);">Absenden</button>
                    </div>
                </form>
            </div>
            <?php
            
        }
    }

}


?>