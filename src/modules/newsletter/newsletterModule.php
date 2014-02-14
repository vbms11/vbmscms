<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'core/plugin.php';
require_once 'modules/newsletter/newsletterModel.php';
require_once 'modules/newsletter/newsletterController.php';

class NewsletterModule extends XModule {

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {

        if (Context::hasRole("newsletter.edit")) {

            switch (parent::getAction()) {
                case "update":
                    $text = str_replace("src=\"/files/", "src=\"".NavigationModel::getSitePath()."files/", parent::post('text'));
                    NewsletterModel::updateNewsletter(parent::get('id'),parent::post('name'),$text);
                    parent::redirect(array("id"=>parent::get('id')));
                    parent::blur();
                    break;
                case "create":
                    $text = str_replace("src=\"/files/", "src=\"".NavigationModel::getSitePath()."files/", parent::post('text'));
                    $newId = NewsletterModel::createNewsletter(parent::post("name"),$text);
                    parent::redirect(array("id"=>$newId));
                    break;
                case "dosend":
                    NewsletterController::sendNewsletter(parent::post('selectednewsletter'),parent::post('groups'),parent::post('subject'),parent::post('sender'));
                    parent::redirect(array("sent"=>"1"));
                    parent::blur();
                    break;
                case "delete":
                    NewsletterModel::deleteNewsletter(parent::get('id'));
                    parent::redirect();
                    parent::blur();
                    break;
                case "new":
                    parent::focus();
                    break;
                case "edit":
                    parent::blur();
                    break;
                case "send":
                    parent::blur();
                    break;
            }
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {
        
        if (Context::hasRole("newsletter.edit")) {

            switch (parent::getAction()) {
                case "new":
                    $this->editNewsletter(null);
                    break;
                case "editNewsletter":
                    $this->editNewsletter(parent::get('id'));
                    break;
                default:
                    $this->printMainView();
            }
        }
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("newsletter.edit","newsletter.send");
    }
    
    function getStyles () {
	return array("css/newsletter.css");
    }
    
    static function getTranslations() {
        return array(
            "en" => array(
                "newsletter.button.create" => "Create Newsletter",
                "newsletter.delete.confirm" => "Are you sure that you want to delete this newsletter",
                "newsletter.button.edit" => "Edit Newsletter",
                "newsletter.dialog.sent.message" => "The newsletter has been sent!",
                "newsletter.dialog.sent.title" => "Newsletter Sent",
                "newsletter.tab.edit" => "Edit Newsletter",
                "newsletter.tab.send" => "Send Newsletter",
                "newsletter.label.select" => "Select Newsletter",
                "newsletter.label.subject" => "Email Subject",
                "newsletter.label.address" => "Email Sender",
                "newsletter.label.groups" => "Recipient Groups",
                "newsletter.label.name" => "Newsletter Name",
                "newsletter.label.newsletter" => "Diesen Newsletter mit dem Editor designen %name% wird mit den name den empf&auml;nger ersetzt und %email% mit den email Adresse",
                "newsletter.button.cancel" => "Cancel",
                "newsletter.button.save" => "Save",
                "newsletter.button.send" => "Send Newsletter"
            ), "de" => array(
                "newsletter.button.create" => "Create Newsletter",
                "newsletter.delete.confirm" => "Are you sure that you want to delete this newsletter",
                "newsletter.button.edit" => "Edit Newsletter",
                "newsletter.dialog.sent.message" => "The newsletter has been sent!",
                "newsletter.dialog.sent.title" => "Newsletter Sent",
                "newsletter.tab.edit" => "Edit Newsletter",
                "newsletter.tab.send" => "Send Newsletter",
                "newsletter.label.select" => "Select Newsletter",
                "newsletter.label.subject" => "Email Subject",
                "newsletter.label.address" => "Email Sender",
                "newsletter.label.groups" => "Recipient Groups",
                "newsletter.label.name" => "Newsletter Name",
                "newsletter.label.newsletter" => "Diesen Newsletter mit dem Editor designen %name% wird mit den name den empf&auml;nger ersetzt und %email% mit den email Adresse",
                "newsletter.button.cancel" => "Cancel",
                "newsletter.button.save" => "Save",
                "newsletter.button.send" => "Send Newsletter"
            )
        );
    }

    function printMainView () {

        $newsletters = NewsletterModel::getNewsletters();
        
        $selectedNewsletter = null;
        if (!empty($newsletters)) {
            if (parent::get('id') == null) {
                $selectedNewsletter = current($newsletters);
            } else {
                for ($i=0; $i<count($newsletters); $i++) {
                    if ($newsletters[$i]->id == parent::get('id')) {
                        $selectedNewsletter = $newsletters[$i];
                    }
                }
            }
        }
        
        ?>
        <div class="panel newsletterPanel">
            <div id="newsletterTabs">
                <ul>
                    <li><a href="#tabs-1"><?php echo parent::getTranslation("newsletter.tab.edit"); ?></a></li>
                    <?php
                    if (Context::hasRole("newsletter.send") && !empty($newsletters)) {
                        ?>
                        <li><a href="#tabs-2"><?php echo parent::getTranslation("newsletter.tab.send"); ?></a></li>
                        <?php
                    }
                    ?>
                </ul>
                <div id="tabs-1">
                    <?php
                    $this->renderPreviewNewsletter($newsletters,$selectedNewsletter);
                    ?>
                </div>
                <?php
                if (Context::hasRole("newsletter.send") && !empty($newsletters)) {
                    ?>
                    <div id="tabs-2">
                        <?php
                        $this->renderSendNewsletterForm($newsletters);
                        ?>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
            if (parent::get('sent') != null) {
                $this->newsletterSentDialog();
            }
            ?>
        </div>
        <script>
        $("#newsletterTabs").tabs();
        </script>
        <?php
    }
    
    function newsletterSentDialog () {
        ?>
        <div id="newsletterSentDialog" title="<?php echo parent::getTranslation("newsletter.dialog.sent.title"); ?>">
            <p><?php echo parent::getTranslation("newsletter.dialog.sent.message"); ?></p>
        </div>
        <script>
            $("#newsletterSentDialog").dialog({
                autoOpen: true, modal: true,
                height: 250, width: 350,
                show: "fade", hide: "explode",
                buttons: {
                "ok": function() {
                    $("#newsletterSentDialog").dialog("close");
                }
            }});
        </script>
        <?php
    }
    
    function renderPreviewNewsletter ($newsletters, $selectedNewsletter) {
        ?>
        <div class="priviewNewsletterPanel">
            <?php
            if (!empty($newsletters)) {
                ?>
                <table width="100%" style="white-space:nowrap"><tr><td>
                    <a href="<?php echo parent::link(array("action"=>"editNewsletter","id"=>$selectedNewsletter->id)); ?>"><?php echo parent::getTranslation("newsletter.button.edit"); ?></a>
                </td><td>
                    <a href="<?php echo parent::link(array("action"=>"new")); ?>"><?php echo parent::getTranslation("newsletter.button.create"); ?></a>
                </td><td>
                    <?php echo parent::getTranslation("newsletter.label.select"); ?>
                </td><td class="expand">
                    <select name="selectednewsletter" onchange="callUrl('<?php echo parent::link(); ?>',{'id':this.value})" class="expand">
                        <?php
                        for ($i=0; $i<count($newsletters); $i++) {
                            ?>
                            <option value="<?php echo $newsletters[$i]->id ?>" 
                                <?php if ($newsletters[$i]->id == parent::get("id")) echo "selected='true'" ?>>
                                    <?php echo $newsletters[$i]->name ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                </td><td>
                    <img src="resource/img/delete.png" class="imageLink" alt="" onclick="doIfConfirm('<?php echo parent::getTranslation("newsletter.delete.confirm"); ?>','<?php echo parent::link(array("action"=>"delete","id"=>$selectedNewsletter->id)); ?>');" />
                </td></tr></table>
                <hr/>
                <div class="newsletterPreview">
                    <?php
                    echo $selectedNewsletter->text;
                    ?>
                </div>
                <?php
            } else {
                ?>
                <a href="<?php echo parent::link(array("action"=>"new")); ?>"><?php echo parent::getTranslation("newsletter.button.create"); ?></a>
                <?php
            }
            ?>
        </div>
        <script>
        $(".priviewNewsletterPanel a").each(function (index,object) {
            $(object).button();
        });
        </script>
        <?php
    }
    
    function renderSendNewsletterForm ($newsletters) {
        ?>
        <form method="post" action="<?php echo parent::link(array("action"=>"dosend")); ?>">
            <table class="formTable">
            <tr><td>
                <?php echo parent::getTranslation("newsletter.label.select"); ?>
            </td><td>
                <select name="selectednewsletter" class="expand">
                    <?php
                    for ($i=0; $i<count($newsletters); $i++) {
                        ?>
                        <option value="<?php echo $newsletters[$i]->id ?>" <?php if ($newsletters[$i]->id==parent::get("id")) echo "selected='true'" ?>><?php echo $newsletters[$i]->name ?></option>
                        <?php
                    }
                    ?>
                </select>
            </td></tr><tr><td>
                <?php echo parent::getTranslation("newsletter.label.subject"); ?>
            </td><td>
                <?php InputFeilds::printTextFeild("subject","","expand"); ?>
            </td></tr><tr><td>
                <?php echo parent::getTranslation("newsletter.label.address"); ?>
            </td><td>
                <?php InputFeilds::printTextFeild("sender","","expand"); ?>
            </td></tr><tr><td>
                <?php echo parent::getTranslation("newsletter.label.groups"); ?>
            </td><td>
                <?php
                $roles = Common::toMap(RolesModel::getCustomRoles(),"id","name");
                InputFeilds::printMultiSelect("groups",$roles,array());
                ?>
            </td></tr></table>
            <hr/>
            <div class="alignRight sendButtons">
                <button type="submit"><?php echo parent::getTranslation("newsletter.button.send"); ?></button>
            </div>
            <script>
            $(".sendButtons button").each(function(index,object){
                $(object).button();
            });
            </script>
        </form>
        <?php
    }

    function editNewsletter ($id) {

        $formAction = "create";
        if ($id != null) {
            $newsletter = NewsletterModel::getNewsletter($id);
            $formAction = "update";
        }
        
        ?>
        <div class="panel newsletterPanel">
            <div id="newsletterTabs">
                <ul>
                    <li><a href="#editNewsletterTab"><?php echo parent::getTranslation("newsletter.tab.edit"); ?></a></li>
                </ul>
                <div id="editNewsletterTab">
                    <form method="post" action="<?php echo parent::link(array("action"=>$formAction,"id"=>($id == null ? "" : $newsletter->id))); ?>">
                        <table class="formTable"><tr><td>
                            <?php echo parent::getTranslation("newsletter.label.name"); ?>
                        </td><td>
                            <input type="text" class="textbox" name="name" value="<?php echo ($id == null ? "" : $newsletter->name); ?>"/>
                        </td></tr><tr><td colspan="2">
                            <?php echo parent::getTranslation("newsletter.label.newsletter"); ?>
                        </td></tr><tr><td colspan="2">
                            <?php
                            InputFeilds::printHtmlEditor("text", ($id == null ? "" : $newsletter->text));
                            ?>
                        </td></tr></table>
                        <hr/>
                        <div class="alignRight">
                            <button type="submit"><?php echo parent::getTranslation("newsletter.button.save"); ?></button>
                            <button type="button" class="btn_cancel"><?php echo parent::getTranslation("newsletter.button.cancel"); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
        $("#editNewsletterTab .alignRight button").each(function (index,object) {
            $(object).button();
        });
        $("#editNewsletterTab .alignRight .btn_cancel").click(function(){
            callUrl("<?php echo parent::link(); ?>");
        });
        $("#newsletterTabs").tabs();
        </script>
        <?php
    }
}

?>