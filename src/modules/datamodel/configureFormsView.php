<?php

require_once('core/plugin.php');

class ConfigureTablesView extends XModule {
    
    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {

        switch (parent::getAction()) {
            case "config":
                DynamicDataView::processAction(isset($_GET['table']) ? $_GET['table'] : "", array(), array("action"=>"process"));
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
        return array("login.edit");
    }

    function printMainView () {
        
        $tables = VirtualDataModel::getTables();
        if (count($tables) > 0) {
            
            $selectedTable = isset($_GET['table']) ? $_GET['table'] : $tables[0]->name;
            $valueNameArray = Common::toMap($tables, "name", "name");
            
            ?>
            <table width="100%" style="white-space: nowrap;"><tr><td>
                <button id="newTable">New Table</button>
            </td><td>
                Select Table: 
            </td><td class="expand">
                <?php
                InputFeilds::printSelect("table", $selectedTable, $valueNameArray);
                ?>
            </td><td>
                <button id="deleteTable">Delete</button>
            </td></tr></table>
            <hr/>
            
            <div id="dialog-form-table" title="Create new table">
                <p class="validateTips">All form fields are required.</p>

                <form>
                <fieldset>
                    <label for="name">Table Name</label>
                    <input type="text" name="name" id="name" class="text ui-widget-content ui-corner-all" />
                </fieldset>
                </form>
            </div>

            
            <?php
            DynamicDataView::configureObject($selectedTable, parent::link(), parent::link(array("action"=>"config")));
            ?>
            <script>
            $("#dialog-form-table").dialog({
                height: 300,
                width: 350,
                modal: true,
                show: "blind",
                hide: "explode",
                buttons: {
                    "Create Table" : function () {
                        callUrl("<?php echo parent::link(array("action"=>"newTable"),false); ?>");
                    }
                }
            });
            $('#newTable').button().click(function (e) {
                $("#dialog-form-table").dialog( "open" );
                this.preventDefault();
            });
            $('#deleteTable').button().click(function () {
                callUrl("<?php echo parent::link(array("action"=>"delete"),false); ?>",{"table" : $('#table').val()});
            });
            $('#table').change(function () {
                callUrl("<?php echo parent::link(array(),false); ?>",{"table" : $('#table').val()});
            });
            </script>
            <?php
            
        } else {
            
        }
        
        
        ?>
        
        <?php
    }

}


?>