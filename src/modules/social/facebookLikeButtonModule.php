<?php

require_once 'core/plugin.php';

class FacebookLikeButtonModule extends XModule {

    function onProcess () {
        
        switch (parent::getAction()) {
            case "save":
                if (Context::hasRole("social.edit")) {
                    parent::param("layout",parent::post("layout"));
                    parent::param("fbaction",parent::post("fbaction"));
                    parent::param("showFaces",parent::post("showFaces"));
                    parent::param("showShare",parent::post("showShare"));
                    parent::param("colorScheme",parent::post("colorScheme"));
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
        <div class="panel facebookLikeButtonPanel">
            <fb:like href="<?php echo $currentUrl; ?>" layout="<?php echo parent::param("layout"); ?>" action="<?php echo parent::param("fbaction"); ?>" show_faces="<?php echo parent::param("showFaces"); ?>" share="<?php echo parent::param("showShare"); ?>"></fb:like>
        </div>
        <?php
    }

    function printEditView () {
        ?>
        <div class="panel facebookLikeButtonEditPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"save")); ?>">
                <table class="formTable"><tr><td>
                    <?php echo parent::getTranslation("facebookComments.edit.colorScheme"); ?>
                </td><td>
                    <?php InputFeilds::printSelect("colorScheme", parent::param("colorScheme"), array("light"=>"light","dark"=>"dark")); ?>
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("facebookComments.edit.layout"); ?>
                </td><td>
                    <?php InputFeilds::printSelect("layout", parent::param("layout"), array("standard"=>"standard", "button_count"=>"button_count", "box_count"=>"box_count")); ?>
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("facebookComments.edit.showFaces"); ?>
                </td><td>
                    <?php InputFeilds::printSelect("showFaces", parent::param("showFaces"), array("true"=>"true", "false"=>"false")); ?>
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("facebookComments.edit.showShare"); ?>
                </td><td>
                    <?php InputFeilds::printSelect("showShare", parent::param("showShare"), array("true"=>"true", "false"=>"false")); ?>
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("facebookComments.edit.action"); ?>
                </td><td>
                    <?php InputFeilds::printSelect("fbaction", parent::param("fbaction"), array("like"=>"like", "recommend"=>"recommend")); ?>
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