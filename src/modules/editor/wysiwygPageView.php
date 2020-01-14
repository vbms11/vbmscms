<?php

include_once 'core/plugin.php';
include_once 'modules/editor/wysiwygPageModel.php';

class WysiwygPageView extends XModule {

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {
        
        if (Context::hasRole("wysiwyg.edit")) {
            
            switch (parent::getAction()) {
                case "update":
                    $content = $_POST['articleContent'];
                    WysiwygPageModel::updateWysiwygPage(parent::getId(),Context::getLang(),$content);
                    PagesModel::updateModifyDate();
                    parent::blur();
                    parent::redirect();
                    break;
                case "edit":
                    parent::focus();
                    break;
                case "cancel":
                    parent::blur();
            }
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {
        
        switch (parent::getAction()) {
            case "edit":
                if (Context::hasRole("wysiwyg.edit")) {
                    $this->printEditView();
                }
                break;
            default:
                $this->printMainView();
        }
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("wysiwyg.edit");
    }

    /**
     * returns search results for given text
     */
    function search ($searchText, $lang) {
        return WysiwygPageModel::search($searchText,$lang);
    }

    function printMainView () {

        $wysiwygPage = WysiwygPageModel::getWysiwygPage(parent::getId(),Context::getLang());
        $content = trim($wysiwygPage->content);
        
        ?>
        <div class="panel wysiwygPanel">
            <?php
            if (empty($content)) {
                echo "<br/>";
            } else {
                echo $wysiwygPage->content;
            }
            ?>
        </div>
        <?php
    }

    function printEditView () {

        $article = WysiwygPageModel::getWysiwygPage(parent::getId(), Context::getLang());
        
        ?>
        <div class="panel wysiwygPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"update")); ?>">
                <div class="formFeildLine">
                    <b><?php echo parent::getTranslation("editor.label.content"); ?></b>
                </div>
                <div class="formFeild">
                    <?php
                    InputFeilds::printHtmlEditor("articleContent", $article->content);
                    ?>
                </div>
                <hr/>
                <div class="alignRight">
                    <button type="submit" class="jquiButton btnSave"><?php echo parent::getTranslation("common.save"); ?></button>
                    <button type="button" class="jquiButton btnCancel"><?php echo parent::getTranslation("editor.label.cancel"); ?></button>
                </div>
            </form>
        </div>
	<script>
        $(".wysiwygPanel .alignRight .btnCancel").each(function (index,object) {
            $(object).click(function () {
                callUrl("<?php echo parent::link(array("action"=>"cancel")); ?>");
            });
	});
	</script>
        <?php
    }
    
    
    /**
     * imports data for this module on a site
     */
    function import (&$siteSerializer) {
        
        foreach ($siteSerializer->getTable("t_wysiwygpage") as $table) {
            WysiwygPageModel::insertWysiwygPage($table->id, $table->moduleid, $table->lang, $table->content, $table->siteid);
        }
    }

    /**
     * copys data for this module and updates parameters to point to the copys id
     */
    function importCopy (&$siteSerializer) {
        
        foreach ($siteSerializer->getTable("t_wysiwygpage") as $table) {
            $moduleId = $siteSerializer->getNewId("t_module_instance",$table->moduleid);
            if ($moduleId == null) {
                continue;
            }
            WysiwygPageModel::createWysiwygPage($moduleId, $table->lang, $table->content, $siteSerializer->siteId);
        }
    }

    /**
     * returns the tables data that this site uses
     */
    function export (&$siteSerializer) {
        
        $siteSerializer->addTable("t_wysiwygpage",WysiwygPageModel::getWysiwygPageBySiteId($siteSerializer->siteId));
    }
}

?>