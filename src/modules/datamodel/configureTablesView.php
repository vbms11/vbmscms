<?php

require_once('core/plugin.php');

class ConfigureTablesView extends XModule {
    
    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {

        switch (parent::getAction()) {
            case "newTable":
                VirtualDataModel::createTable(parent::get("table"));
                parent::redirect(array("action"=>"editForm"));
                break;
            case "delTable":
                VirtualDataModel::deleteTable(parent::get("table"));
                parent::redirect();
                break;
            case "configTable":
                DynamicDataView::processAction(parent::get("table"), parent::link(array(),false), parent::link(array('table'=>parent::get("table")),false));
                break;
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {

        switch (parent::getAction()) {
            case "newForm":
                $this->printNewFormTabs();
                break;
            case "editForm":
                $this->printEditTableView(parent::get("table"));
                break;
            default:
                $this->printListTablesTabs();
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

    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("dm.tables.config");
    }
    
    function printEditTableView ($tableId) {
        
        $table = VirtualDataModel::getTableById($tableId);
        if (!empty($table)) {
            DynamicDataView::configureObject($tableId, parent::link(), parent::link(array("action"=>"configTable","table"=>$tableId)));
        }
    }
    
    
    function printNewFormView () {
        ?>
        <div class="editFormsNewPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"newTable")); ?>">
                <h3><?php echo parent::getTranslation("data.forms.new.title"); ?></h3>
                <table class="formTable"><tr>
                    <td><?php echo parent::getTranslation("data.forms.new.name"); ?></td>
                    <td><input type="text" name="table" /></td>
                </tr></table>
                <hr/>
                <div class="alignRight">
                    <button class="submitButton" type="submit"><?php echo parent::getTranslation("data.forms.new.button.save"); ?></button>
                    <button class="cancelButton" type="button"><?php echo parent::getTranslation("data.forms.new.button.cancel"); ?></button>
                </div>
            </form>
        </div>
        <script>
        $(".editFormsNewPanel .alignRight button").button();
        $(".editFormsNewPanel .alignRight  .cancelButton").click(function(){
            callUrl("<?php echo parent::link(array(),false); ?>");
        })
        </script>
        <?php
    }
    
    function printListTablesView () {
        
        $tables = VirtualDataModel::getTables();
        ?>
        <div class="editFormsListPanel">
            <h3><?php echo parent::getTranslation("data.forms.list.title"); ?></h3>
            <?php
            if (count($tables) > 0) {
                ?>
                <table class="resultTable" width="100%" cellspacing="0"><thead>
                <tr>
                    <td class="contract"><?php echo parent::getTranslation("data.forms.list.table.id"); ?></td>
                    <td class="expand"><?php echo parent::getTranslation("data.forms.list.table.name"); ?></td>
                    <td class="contract" colspan="2"><?php echo parent::getTranslation("data.forms.list.table.tools"); ?></td>
                </tr>
                </thead><tbody>
                <?php
                foreach ($tables as $table) {
                    ?>
                    <tr>
                        <td><?php echo $table->id; ?></td>
                        <td><a href="<?php echo parent::link(array("action"=>"editForm","table"=>$table->id)); ?>"><?php echo Common::htmlEscape($table->name); ?></a></td>
                        <td><a href="<?php echo parent::link(array("action"=>"editForm","table"=>$table->id)); ?>"><img src="resource/img/preferences.png" alt="" /></a></td>
                        <td><img src="resource/img/delete.png" alt="" onclick="doIfConfirm('<?php echo parent::getTranslation("data.forms.list.confirm.delete"); ?>','<?php echo parent::link(array("action"=>"deleteForm","table"=>$table->id),false); ?>');" /></td>
                    </tr>
                    <?php
                }
                ?>
                </tbody></table>
                <?php
            }
            ?>
            <hr/>
            <div class="alignRight">
                <button type="button"><?php echo parent::getTranslation("data.forms.list.button.create"); ?></button>
            </div>
        </div>
        <script type="text/javascript">
        $(".editFormsListPanel .alignRight button").button().click(function () {
            callUrl("<?php echo parent::link(array("action"=>"newForm")); ?>");
        });
        </script>
        <?php
    }
    
    function printListTablesTabs () {
        ?>
        <div class="editFormsPanel">
            <div class="editFormsTabs">
                <ul>
                    <li><a href="#editFormsTab"><?php echo parent::getTranslation("data.forms.tab.list.label"); ?></a></li>
                </ul>
                <div id="editFormsTab">
                    <?php $this->printListTablesView(); ?>
                </div>
            </div>
        </div>
        <script type="text/javascript">
        $(".editFormsPanel .editFormsTabs").tabs();
        </script>
        <?php
    }

    function printNewFormTabs () {
        ?>
        <div class="editFormsPanel">
            <div class="editFormsTabs">
                <ul>
                    <li><a href="#editFormsTab"><?php echo parent::getTranslation("data.forms.tab.list.label"); ?></a></li>
                    <li><a href="#createFormTab"><?php echo parent::getTranslation("data.forms.tab.create.label"); ?></a></li>
                </ul>
                <div id="editFormsTab">
                    <?php $this->printListTablesView(); ?>
                </div>
                <div id="createFormTab">
                    <?php $this->printNewFormView(); ?>
                </div>
            </div>
        </div>
        <script type="text/javascript">
        $(".editFormsPanel .editFormsTabs").tabs({
            active : 1
        });
        </script>
        <?php
    }
}


?>