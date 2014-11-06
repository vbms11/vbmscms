<?php

require_once 'core/plugin.php';
require_once 'core/model/backupModel.php';

class BackupView extends XModule {
    
    function onProcess() {
        
        switch (parent::getAction()) {
            case "create":
                if (Context::hasRole("backup.create")) {
                    BackupModel::createBackup();
                }
                break;
            case "load":
                if (Context::hasRole("backup.load")) {
                    BackupModel::loadBackup($_GET['id']);
                }
                break;
            case "delete":
                if (Context::hasRole("backup.delete")) {
                    BackupModel::deleteBackup($_GET['id']);
                }
                break;
        }
    }
    
    function onView () {
        
        switch (parent::getAction()) {
            case "create":
                if (Context::hasRole("backup.create")) {
                    
                }
                //break;
            case "load":
                if (Context::hasRole("backup.load")) {
                    
                }
                //break;
            case "edit":
            default:
                $this->renderMainView();
        }
    }
    
    function getRoles () {
        return array("backup.create","backup.load","backup.delete");
    }
    
    function renderMainView () {
        Context::addRequiredStyle("resource/js/datatables/css/demo_table_jui.css");
        Context::addRequiredScript("resource/js/datatables/js/jquery.dataTables.min.js");
        ?>
        <div class="panel">
            <div class="formActionsToolbar">
                <?php
                if (Context::hasRole("backup.create"))
                    echo '<button id="btnCreate">Create Backup</button> ';
                if (Context::hasRole("backup.load"))
                    echo '<button id="btnLoad">Load Backup</button> ';
                if (Context::hasRole("backup.delete"))
                    echo '<button id="btnDelete">Delete Backup</button> ';
                ?>
            </div>
            <h3>Backups:</h3>
            <div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="messages"></table>
                <hr/>
            </div>
        </div>
        <script type="text/javascript">
        var userMessages = [
            <?php
            $first = true;
            $backups = BackupModel::getBackups();
            foreach ($backups as $backup) {
                if (!$first)
                    echo ",";
                echo "['".Common::htmlEscape($backup->id)."','".Common::htmlEscape($backup->name)."','".Common::htmlEscape($backup->date)."']";
                $first = false;
            }
            ?>
        ];
        var oTable = $('#messages').dataTable({
            "bScrollCollapse": false,
            "sScrollY": 200,
            "bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayLength": 10,
            "aLengthMenu": [[10, 20, 40, -1], [10, 20, 40, "All"]],
            "aaData": userMessages,
            "aoColumns": [
                {'sTitle':'ID',"sClass": "contract"},
                {'sTitle':'Name',"sClass": "expand"},
                {'sTitle':'Date',"sClass": "contract"}]
        });
        $("#messages tbody").click(function(event) {
            $(oTable.fnSettings().aoData).each(function (){
                $(this.nTr).removeClass('row_selected');
            });
            $(event.target.parentNode).addClass('row_selected');
        });
        $("#btnDelete").click(function(event) {
            callUrl('<?php echo parent::link(array("action"=>"delete"), false); ?>',{"id":getSelectedRow(oTable)[0].childNodes[0].innerHTML});
            
        });
        $("#btnLoad").click(function(event) {
            var emailId = getSelectedRow(oTable)[0].childNodes[0].innerHTML;
            callUrl('<?php echo parent::link(array("action"=>"load"), false); ?>',{"id":getSelectedRow(oTable)[0].childNodes[0].innerHTML});
        });
        $("#btnCreate").click(function(event) {
            callUrl('<?php echo parent::link(array("action"=>"create"), false); ?>');
        });
        </script>
        <?php
    }
}

?>