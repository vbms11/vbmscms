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
            case "editCategory":
                
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

    function printMainView () {
        
        $categorys = CategoryModel::getCategorys(Context::getSiteId());
        
        ?>
        <div class="panel categoryPanel">
            <table>
                <thead>
                    <td>Category Name</td>
                    <td>Usage</td>
                    <td colspan="2">Options</td>
                </thead>
            <?php
            foreach ($categorys as $key => $value) {
                ?>
                <td><?php echo htmlspecialchars($value->name); ?></td>
                <td><?php echo CategoryModel::getUsage($value->id); ?></td>
                <td><a href="<?php echo parent::link(array("action"=>"editCategory","id"=>$value->id)); ?>">Edit</a></td>
                <td><a href="<?php echo parent::link(array("action"=>"deleteCategory","id"=>$value->id)); ?>">Delete</a></td>
                <?php
            }
            ?>
        </div>
        <?php
    }

    function printEditView () {
        
        ?>
        <div class="panel categoryPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"update")); ?>">
                <hr/>
                <div class="alignRight">
                    <button type="button" class="jquiButton btnCancel"><?php echo parent::getTranslation("category.label.cancel"); ?></button>
                </div>
            </form>
        </div>
	<script>
        $(".categoryPanel .btnCancel").each(function (index,object) {
            $(object).click(function () {
                callUrl("<?php echo parent::link(array("action"=>"cancel")); ?>");
            });
	});
	</script>
        <?php
    }
}

?>