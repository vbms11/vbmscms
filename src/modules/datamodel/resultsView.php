<?php

require_once ('core/plugin.php');

class ResultsView extends XModule {
    
    function onProcess () {
        
        switch (parent::getAction()) {
            case "data":
                parent::param("orderForm",$_POST["orderForm"]);
                break;
            case "delete":
                VirtualDataModel::deleteRow(parent::param("orderForm"), $_GET['id']);
                break;
            case "save":
                parent::param("orderForm",$_POST["orderForm"]);
                parent::redirect();
                break;
            default:
        }
    }
    
    function onView() {
        
        switch (parent::getAction()) {
            case "edit":
                $this->printEditView();
                break;
            default:
                $this->renderResults();
        }
    }
    
    function printEditView () {
        $tables = VirtualDataModel::getTables();
        if (count($tables) > 0) {
            $valueNameArray = Common::toMap($tables, "name", "name");
            ?>
            <form method="post" id="formForm" action="<?php echo parent::link(array("action"=>"save")); ?>">
                <table width="100%" style="white-space: nowrap;"><tr><td>
                    Select Order Form: 
                </td><td class="expand">
                    <?php
                    InputFeilds::printSelect("orderForm", parent::param("orderForm"), $valueNameArray);
                    ?>
                </td><td>
                    <button id="configTable">Configure</button>
                </td></tr></table>
                <br/>
                <hr/>
                <div style="text-align:right;">
                    <button id="saveButton">Save</button>
                </div>
            </form>
            <script>
            $('#configTable').button().click(function (e) {
                callUrl("<?php echo NavigationModel::createStaticPageLink("configTables",array(),false); ?>",{"table":$("#orderForm").val()});
                e.preventDefault();
            })
            $('#saveButton').button().click(function () {
                $('#formForm').submit();
            })
            </script>
            <?php
        }
    }
    
    function renderResults () {
        
        ?>
        <div class="toolButtonDiv">
            <button class="btnImport">Import</button>
            <button class="btnExport">Export</button>
            <button class="btnDelete">Delete</button>
        </div>
        <table cellpadding="0" cellspacing="0" border="0" class="display" id="tblResults"></table>
        <script type="text/javascript">
        <?php
        // print table header
        echo "var ar_columns = [";
        $first = true;
        $columns = VirtualDataModel::getColumns(parent::param("orderForm"));
        echo "{'sTitle':'id'}";
        foreach ($columns as $column) {
            echo ",{'sTitle':'".$column->name."'}";
        }
        echo "];".PHP_EOL;
        
        
        $b_first = true;
        $data = VirtualDataModel::getAllRowsAsArray(parent::param("orderForm"));
        echo "var ar_data = [";
        if ($data != null) {
            foreach ($data as $order) {
                if (!$b_first)
                    echo ",";
                echo "['";
                echo isset($order['objectid']) ? $order['objectid'] : "";
                echo "'";
                foreach ($columns as $column) {
                    echo ",'".Common::htmlEscape(trim(isset($order[$column->name]) ? $order[$column->name] : ""))."'";
                }
                echo "]";
                $b_first = false;
            }
            
        }
        echo "];".PHP_EOL;

        ?>
        var selectedTab = 0;
        oTable = $('#tblResults').dataTable({
            "sScrollY": "200px",
            "bScrollCollapse": true,
            "bPaginate": false,
            "bJQueryUI": true,
            "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
            "aaData": ar_data,
            "aoColumns": ar_columns
        });
        oTable.click(function(event) {
            $(oTable.fnSettings().aoData).each(function (){
                $(this.nTr).removeClass('row_selected');
            });
            $(event.target.parentNode).addClass('row_selected');
        });
        $(".btnImport").button().click(function () {
            callUrl("<?php echo parent::link(array("action"=>"import"),false); ?>",{"id":selectedTab});
        });
        $(".btnExport").button().click(function () {
            callUrl("<?php echo parent::link(array("action"=>"export"),false); ?>",{"id":selectedTab});
        });
        $(".btnDelete").button().click(function () {
            callUrl("<?php echo parent::link(array("action"=>"delete"),false); ?>",{"id":selectedTab});
        });
        </script>
        <?php
    }
    
}
?>