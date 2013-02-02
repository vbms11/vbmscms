<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'core/common.php';
require_once 'core/plugin.php';
require_once 'modules/newsletter/newsletterPageModel.php';
require_once 'modules/newsletter/listsPageModel.php';
require_once 'modules/newsletter/newsletterController.php';
require_once 'core/util/tinyMce.php';

class NewsletterPageView extends XModule {

    public $action;
    public $id;
    public $name;
    public $text;
    public $sender;
    public $title;
    public $group;
    public $newsletterModel;

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {

        $this->getRequestVars();

        if (Context::hasRole("newsletter.edit")) {

            switch ($this->action) {
                case "update":
                    $text = $_GET['text'];
                    $text = str_replace("src=\"/files/", "src=\"".NavigationModel::getSitePath()."files/", $this->text);
                    NewsletterPageModel::updateNewsletter($_GET['id'],$this->name,$this->text);
                    parent::redirect(array("id"=>$_GET['id']));
                    parent::blur();
                    break;
                case "create":
                    $this->text = str_replace("src=\"/files/", "src=\"".NavigationModel::getSitePath()."files/", $this->text);
                    $newId = NewsletterPageModel::createNewsletter($this->name,$this->text);
                    parent::redirect(array("id"=>$newId));
                    break;
                case "dosend":
                    NewsletterController::sendNewsletter($_POST['selectednewsletter'],$_POST['group'],$_POST['title'],$_POST['sender']);
                    parent::redirect(array("sent"=>"1"));
                    parent::blur();
                    break;
                case "delete":
                    NewsletterPageModel::deleteNewsletter($_GET['id']);
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

        $this->getRequestVars();

        if (Context::hasRole("newsletter.edit")) {

            switch (parent::getAction()) {
                case "new":
                    $this->editNewsletter(parent::getId(),null);
                    break;
                case "editNewsletter":
                    $this->editNewsletter(parent::getId(),$_GET['id']);
                    break;
                default:
                    $this->printMainView(parent::getId());
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
    
    /**
     * returns search results for given text
     */
    function search ($searchText, $lang) {

    }


    function getRequestVars () {
        $this->action = null; if (isset($_GET['action'])) $this->action = $_GET['action'];
        $this->id = null; if (isset($_GET['id'])) $this->id = $_GET['id'];
        $this->name = null; if (isset($_POST['name'])) $this->name = $_POST['name'];
        $this->text = null; if (isset($_POST['text'])) $this->text = $_POST['text'];
        $this->sender = null; if (isset($_POST['sender'])) $this->sender = $_POST['sender'];
        $this->title = null; if (isset($_POST['title'])) $this->title = $_POST['title'];
        $this->group = null; if (isset($_POST['group'])) $this->group = $_POST['group'];
    }

    function printMainView ($pageId) {

        $newsletters = NewsletterPageModel::getNewsletters();

        ?>
        <div class="panel newsletterPanel">
        <?php

        if (count($newsletters) != 0) {

            if (!isset($_GET['id']))
            $selectedNewsletter = $newsletters[0];
            else {
                for ($i=0; $i<count($newsletters); $i++)
                if ($newsletters[$i]->id == $_GET['id'])
                $selectedNewsletter = $newsletters[$i];
            }
            ?>
        <div id="newsletterTabs">
        <ul>
            <li><a href="#tabs-1">Edit Newsletter</a></li>
            <?php
            if (Context::hasRole("newsletter.send")) {
                ?>
            <li><a href="#tabs-2">Send Newsletter</a></li>
            <?php
        }
        ?>
        </ul>
        <div id="tabs-1">

            <table class="newsletterButtons" width="100%"><tr><td>
                        <a href="<?php echo parent::link(array("action"=>"editNewsletter","id"=>$selectedNewsletter->id)); ?>">Newsletter editieren</a>
                    </td><td>
                        <a href="<?php echo parent::link(array("action"=>"new")); ?>">Neuen Newsletter erstellen</a>
                    </td><td>
                        Newsletter ausw&auml;hlen
                    </td><td class="expand">
                        <select name="selectednewsletter" onchange="callUrl('<?php echo parent::link(); ?>',{'id':this.value})" class="expand">
                            <?php
                            for ($i=0; $i<count($newsletters); $i++) {
                                ?>
                            <option value="<?php echo $newsletters[$i]->id ?>" <?php if ($newsletters[$i]->id==$this->id) echo "selected='true'" ?>><?php echo $newsletters[$i]->name ?></option>
                            <?php
                        }
                        ?>
                        </select>
                    </td><td>
                        <img src="resource/img/delete.png" class="imageLink" alt="" onclick="doIfConfirm('Wollen Sie wirklich diese Newsletter l&ouml;schen?','<?php echo parent::link(array("action"=>"delete","id"=>$selectedNewsletter->id)); ?>');" />
            </td></tr></table>
            <hr/>
            <div class="newsletterPreview">
                <?php
                echo $selectedNewsletter->text;
                ?>
            </div>

        </div>
        <?php
        if (Context::hasRole("newsletter.send")) {
            ?>
        <div id="tabs-2">



        <form method="post" action="<?php echo parent::link(array("action"=>"dosend")); ?>">

        <table width="100%">
            <tr><td class="contract nowrap">
                    Newsletter ausw&auml;hlen
                </td><td class="expand">
                    <select name="selectednewsletter" class="expand">
                        <?php
                        for ($i=0; $i<count($newsletters); $i++) {
                            ?>
                        <option value="<?php echo $newsletters[$i]->id ?>" <?php if ($newsletters[$i]->id==$this->id) echo "selected='true'" ?>><?php echo $newsletters[$i]->name ?></option>
                        <?php
                    }
                    ?>
                    </select>
                </td></tr><tr><td class="contract nowrap">
                        Betreff:
                    </td><td class="expand">
                        <?php InputFeilds::printTextFeild("subject","","expand"); ?>
                </td></tr><tr><td class="contract nowrap">
                        Absenderadresse:
                    </td><td class="expand">
                        <?php InputFeilds::printTextFeild("sender","","expand"); ?>
                </td></tr><tr><td colspan="2">
                        <br/>
                        Empf&auml;nger rollen gruppe:
                </td></tr><td colspan="2">
                <?php
                $roles = Common::toMap(RolesModel::getCustomRoles(),"id","name");
                InputFeilds::printMultiSelect("groups",$roles,array());
                ?>
        </td></tr></table>
        <hr/>
        <div class="alignRight sendButtons">
            <button type="submit">Jetzt versenden</button>
        </div>
        <script>
            $(".sendButtons button").each(function(index,object){
                $(object).button();
            });
        </script>
        </form>
        </div>
        <?php
        }
        ?>
        </div>
        <?php
        } else {
        ?>
        <a href="<?php echo parent::link(array("action"=>"new")); ?>">Neuen Newsletter erstellen</a>
        <?php
        }

        if (isset($_GET['sent'])) {
            ?>
            <div id="newsletterSentDialog" title="newsletterSent">
                <p>The newsletter has been sent!</p>
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

        ?>
        </div>

        <script>
            $(".newsletterButtons a").each(function (index,object) {
                $(object).button();
            });
            $("#newsletterTabs").tabs();
        </script>
        <?php
    }

    function editNewsletter ($pageId,$id) {

        $formAction = "create";
        if ($id != null) {
            $newsletter = NewsletterPageModel::getNewsletter($id);
            $formAction = "update";
        }
        
        ?>
        <div class="panel newsletterPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>$formAction,"id"=>($id == null ? "" : $newsletter->id))); ?>">
                <div class="formFeildLine">
                    <b>Der Name des Newsletters</b>
                </div>
                <br/>
                <div class="formFeild">
                    <input type="text" class="textbox" name="name" value="<?php echo ($id == null ? "" : $newsletter->name); ?>"/>
                </div>
                <br/>
                <div class="formFeildLine">
                    <b>Diesen Newsletter mit dem Editor designen %name% wird mit den name den empf&auml;nger ersetzt und %email% mit den email Adresse</b>
                </div>
                <br/>
                <div class="formFeild">
                    <?php
                    InputFeilds::printHtmlEditor("text", ($id == null ? "" : $newsletter->text));
                    ?>
                </div>
                <hr noshade/>
                <div class="formFeildButtons" align="right">
                    <button type="submit" class="button">Speichern</button>
                    <button type="submit" class="button" style="margin-left:6px;" onclick="history.back(); return false;">Abbrechen</button>
                </div>
            </form>
            <script>
            $(".newsletterPanel button, .newsletterPanel a").each(function (index,object) {
                $(object).button();
            });
            </script>
        </div>
        <?php
    }
}

?>