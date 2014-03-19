<?php

require_once 'core/plugin.php';

class FacebookCommentsModule extends XModule {

    function onProcess () {
        
        switch (parent::getAction()) {
            case "save":
                if (Context::hasRole("social.edit")) {
                    parent::param("colorScheme",parent::post("colorScheme"));
                    parent::param("commentsAmount",parent::post("commentsAmount"));
                    parent::blur();
                    parent::redirect();
                }
                break;
            case "edit":
                parent::focus();
                break;
            case "cancel":
                parent::blur();
        }
    }

    function onView () {
        
        switch (parent::getAction()) {
            case "edit":
                if (Context::hasRole("social.edit")) {
                    $this->printEditView();
                }
                break;
            default:
                $this->printMainView();
        }
    }

    function getRoles () {
        return array("social.edit");
    }
    
    function printMainView () {
        $page = Context::getPage();
        $currentUrl = NavigationModel::getSitePath()."/".NavigationModel::createPageNameLink($page->name, $page->id);
        ?>
        <div class="panel facebookCommentsPanel">
            <fb:comments href="<?php echo $currentUrl; ?>" numposts="<?php echo parent::param("commentsAmount"); ?>" colorscheme="<?php echo parent::param("colorScheme"); ?>"></fb:comments>
        </div>
        <?php
    }

    function printEditView () {
        ?>
        <div class="panel facebookCommentsEditPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"save")); ?>">
                <table class="formTable"><tr><td>
                    <?php echo parent::getTranslation("facebookComments.edit.colorScheme"); ?>
                </td><td>
                    <?php InputFeilds::printSelect("colorScheme", parent::param("colorScheme"), array("light"=>"light","dark"=>"dark")); ?>
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("facebookComments.edit.commentsAmount"); ?>
                </td><td>
                    <?php InputFeilds::printSpinner("commentsAmount", parent::param("commentsAmount")); ?>
                </td></tr></table>
                <hr/>
                <div class="alignRight">
                    <button type="submit" class="jquiButton"><?php echo parent::getTranslation("common.save"); ?></button>
                    <button type="button" class="jquiButton" onclick="callUrl('<?php echo parent::link(array("action"=>"cancel")); ?>');"><?php echo parent::getTranslation("common.cancel"); ?></button>
                </div>
            </form>
        </div>
        <?php
    }
}

?>