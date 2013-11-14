<?php

require_once 'core/plugin.php';
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
                    parent::redirect();
                    parent::blur();
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
                    $this->printEditView(parent::getId());
                }
                break;
            default:
                $this->printMainView(parent::getId());
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
        $searchResults = WysiwygPageModel::search($searchText,Context::getLang());
        return $searchResults;
    }

    function printMainView ($pageId) {

        $wysiwygPage = WysiwygPageModel::getWysiwygPage($pageId,Context::getLang());
        ?>
        <div class="panel wysiwygPanel">
		<?php
		if (!Common::isEmpty(trim($wysiwygPage->content))) {
			echo $wysiwygPage->content;
		} else {
			echo "<br/>";
		}
            	?>
        </div>
        <?php
    }

    function printEditView ($pageId) {

        $article = WysiwygPageModel::getWysiwygPage($pageId, Context::getLang());
        ?>
        <div class="panel wysiwygPanel">
            <form name="articleForm" method="post" action="<?php echo parent::link(array("action"=>"update")); ?>">
                <div class="formFeildLine">
                    <b>Diese Seite mit dem Editor &auml;ndern</b>
                </div>
                <br/>
                <div class="formFeild">
                    <?php
                    InputFeilds::printHtmlEditor("articleContent", $article->content);
                    ?>
                </div>
                <hr noshade/>
                <div class="alignRight">
                    <button type="submit">Speichern</button>
                    <button type="submit" onclick="callUrl('<?php echo parent::link(array("action"=>"cancel")); ?>'); return false;">Abbrechen</button>
                </div>
            </form>
        </div>
	<script>
	$(".wysiwygPanel .alignRight button").each(function (index,object) {
		$(object).button();
	});
	</script>
        <?php
    }
}

?>