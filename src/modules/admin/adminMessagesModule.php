<?php

require_once 'core/plugin.php';

class AdminMessagesModule extends XModule {
    
    function onProcess () {
        
        switch (parent::getAction()) {
            case "deleteMessage":
                VirtualDataModel::deleteRow(parent::get("table"),parent::get("id"));
                parent::redirect();
                break;
            case "viewMessage":
                VirtualDataModel::setRowViewed(parent::get("table"),parent::get("id"));
                break;
            case "markNew":
                VirtualDataModel::setRowViewed(parent::get("table"),parent::get("id"),'0');
                parent::redirect();
                break;
        }
    }
    
    function onView () {
        
        switch (parent::getAction()) {
            case "viewMessage":
                $this->renderMessageTabs(parent::get("id"),parent::get("table"));
                break;
            default:
                $this->renderMainView();
        }
    }
    
    function renderMessageTabs ($id, $tableName) {
        ?>
        <div class="panel adminMessagesPanel">
            <div class="adminMessagesTabs">
                <ul>
                    <li><a href="#viewMessage"><?php echo parent::getTranslation("admin.messages.tab.view"); ?></a></li>
                </ul>
                <div id="viewMessage">
                    <?php $this->renderMessageView($id, $tableName); ?>
                </div>
            </div>
        </div>
        <script type="text/javascript">
        $(function() {
            $(".adminMessagesTabs").tabs();
        });
        </script>
        <?php
    }
    
    function renderMessageView ($id, $tableName) {
        ?>
        <div class="panel viewMessagePanel">
            <div class="alignRight">
                <button class="btnBack"><?php echo parent::getTranslation("admin.messages.button.back"); ?></button>
                <button class="btnMarkNew"><?php echo parent::getTranslation("admin.messages.button.marknew"); ?></button>
                <button class="btnDelete"><?php echo parent::getTranslation("admin.messages.button.delete"); ?></button>
            </div>
            <hr/>
            <?php
            DynamicDataView::displayObject($tableName, $id);
            ?>
            <hr/>
            <div class="alignRight">
                <button class="btnBack"><?php echo parent::getTranslation("admin.messages.button.back"); ?></button>
                <button class="btnMarkNew"><?php echo parent::getTranslation("admin.messages.button.marknew"); ?></button>
                <button class="btnDelete"><?php echo parent::getTranslation("admin.messages.button.delete"); ?></button>
            </div>
        </div>
        <script>
        $(".viewMessagePanel .btnBack").each(function (index,object) {
            $(object).button().click(function () {
                callUrl("<?php echo parent::link(); ?>");
            });
        });
        $(".viewMessagePanel .btnMarkNew").each(function (index,object) {
            $(object).button().click(function () {
                callUrl("<?php echo parent::link(array("action"=>"markNew","id"=>$id,"table"=>$tableName)); ?>");
            });
        });
        $(".viewMessagePanel .btnDelete").each(function (index,object) {
            $(object).button().click(function () {
                callUrl("<?php echo parent::link(array("action"=>"deleteMessage","id"=>$id,"table"=>$tableName)); ?>");
            });
        });
        </script>
        <?php
    }
    
    function renderMainView() {
        ?>
        <div class="panel adminMessagesPanel">
            <div class="adminMessagesTabs">
                <ul>
                    <li><a href="#newMessages"><?php echo parent::getTranslation("admin.messages.tab.new"); ?></a></li>
                    <li><a href="#pastMessages"><?php echo parent::getTranslation("admin.messages.tab.old"); ?></a></li>
                </ul>
                <div id="newMessages">
                    <?php $this->renderNewMessagesView(); ?>
                </div>
                <div id="pastMessages">
                    <?php $this->renderPastMessagesView(); ?>
                </div>
            </div>
        </div>
        <script type="text/javascript">
        $(function() {
            $(".adminMessagesTabs").tabs({
                active : $.cookie('messagesActiveTab'),
                activate : function( event, ui ){
                    $.cookie( 'messagesActiveTab', ui.newTab.index(),{
                        expires : 10
                    });
                }
            });
        });
        </script>
        <?php
    }
    
    function renderNewMessagesView () {
        $previewLength = 40;
        $tables = VirtualDataModel::getTables();
        ?>
        <div class="panel newMessagesPanel">
            <?php
            foreach ($tables as $table) {
                $rows = VirtualDataModel::getRowsViewed($table->name, '0');
                if (count($rows) > 0) {
                    $cols = VirtualDataModel::getColumns($table->name);
                    ?>
                    <h3><?php echo Common::htmlEscape($table->name); ?></h3>
                    <table class="resultTable" width="100%" cellspacing="0">
                    <thead><tr>
                    <?php
                    foreach ($cols as $col) {
                        ?>
                        <td><?php echo Common::htmlEscape($col->label); ?></td>    
                        <?php
                    }
                    ?>
                    </tr></thead>
                    <tbody>
                    <?php
                    foreach ($rows as $row) {
                        ?>
                        <tr id="row_<?php echo $row['objectid']; ?>_<?php echo $table->name; ?>">
                            <?php
                            foreach ($cols as $col) {
                                ?>
                                <td><?php echo Common::htmlEscape(substr($row[$col->name], 0, $previewLength)); ?></td>    
                                <?php
                            }
                            ?>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                    </table>
                    <?php
                    
                }
            }
            ?>
        </div>
        <script>
        $(".newMessagesPanel .resultTable tbody tr").each(function (index,object) {
            $(object).click(function () {
                var idStr = $(object).attr("id").substring(4);
                var tableStart = idStr.indexOf("_");
                var tableName = idStr.substring(tableStart+1);
                var id = idStr.substring(0,tableStart);
                callUrl("<?php echo parent::link(array("action"=>"viewMessage")); ?>",{"id":id,"table":tableName});
            });
        });
        </script>
        <?php
    }
    
    function renderPastMessagesView () {
        $previewLength = 40;
        $tables = VirtualDataModel::getTables();
        ?>
        <div class="panel pastMessagesPanel">
            <?php
            foreach ($tables as $table) {
                $rows = VirtualDataModel::getRowsViewed($table->name, '1');
                if (count($rows) > 0) {
                    $cols = VirtualDataModel::getColumns($table->name);
                    ?>
                    <h3><?php echo Common::htmlEscape($table->name); ?></h3>
                    <table class="resultTable" width="100%" cellspacing="0">
                    <thead><tr>
                    <?php
                    foreach ($cols as $col) {
                        ?>
                        <td><?php echo Common::htmlEscape($col->label); ?></td>    
                        <?php
                    }
                    ?>
                    </tr></thead>
                    <tbody>
                    <?php
                    foreach ($rows as $row) {
                        ?>
                        <tr id="row_<?php echo $row['objectid']; ?>_<?php echo $table->name; ?>">
                            <?php
                            foreach ($cols as $col) {
                                ?>
                                <td><?php echo Common::htmlEscape(substr($row[$col->name], 0, $previewLength)); ?></td>    
                                <?php
                            }
                            ?>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                    </table>
                    <?php
                    
                }
            }
            ?>
        </div>
        <script>
        $(".pastMessagesPanel .resultTable tbody tr").each(function (index,object) {
            $(object).click(function () {
                var idStr = $(object).attr("id").substring(4);
                var tableStart = idStr.indexOf("_");
                var tableName = idStr.substring(tableStart+1);
                var id = idStr.substring(0,tableStart);
                callUrl("<?php echo parent::link(array("action"=>"viewMessage")); ?>",{"id":id,"table":tableName});
            });
        });
        </script>
        <?php
    }
}

?>