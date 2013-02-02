<?php

class ExportView extends XModule {
    
    function onProcess () {
        
        switch (parent::getAction()) {
            case "download":
                break;
            case "back":
                break;
        }
    }
    
    function onView () {
        
        switch (parent::getAction()) {
            case "preview":
                $this->renderPreview();
                break;
            default:
                $this->renderConfigure();
        }
    }
    
    function renderConfigure () {
        
        $columns = DataModel::getColumns($tableId);
        $cols = array();
        
        if ($extTableName != null && $extTableColumns != null && $extObjectIdColumn != null) {
            foreach ($extTableColumns as $extColumn) {
                $cols[$extColumn]->name = $extColumn;
            }
        }
        
        foreach ($columns as $col) {
            $cols[$col->name]->name = $col->name;
        }
        
        switch (isset($_GET['ddmAction']) ? $_GET['ddmAction'] : null) {
            case "doExport":
                
                InfoMessages::printInfoMessage("ddm.export.stats");
                ?>
                <br/>
                
                <?php
                break;
            default:
                
                InfoMessages::printInfoMessage("ddm.export.config");
                ?>
                <br/>
                <form method="post" action="<?php echo NavigationModel::modifyLink($continueLink,array("ddmAction"=>"exportDownload","tableId"=>$tableId,"extTableName"=>$extTableName,"extObjectId"=>$extObjectIdColumn)); ?>">
                    <div class="toolButtonDiv">
                        <input type="submit" value="Download" />
                        <input type="button" value="Cancel" onclick="callUrl('<?php echo $backlink; ?>');" />
                    </div>
                    <input type="hidden" name="columnNames" value="<?php echo implode(",",array_keys($cols)); ?>">
                    <hr/><br/>
                    <table width="100%"><tr><td class="contract">
                           Attribute
                        </td><td style="width:50%; white-space:nowrap;">
                           Column Name
                        </td><td style="width:50%; white-space:nowrap;">
                           Csv Column Name
                        </td><td colspan="3" align="center" class="contract">
                           Tools
                        </td></tr>
                        <?php
                        $arrayKeys = array_keys($cols);
                        $cntKeys = count($arrayKeys);
                        for ($i=0; $i<$cntKeys; $i++) {
                            $name = Common::htmlEscape($cols[$arrayKeys[$i]]->name);
                            ?>
                            <tr><td>
                                <?php echo $i; ?>
                            </td><td>
                                <?php InputFeilds::printSelect("column_".$name, $i, array_keys($cols)); ?>
                            </td><td>
                                <input type="textbox" name="name_<?php echo $name; ?>" value="<?php echo $name; ?>" class="expand" />
                            </td><td>
                                <input type="checkbox" name="<?php echo "include_".$name; ?>" value="1" checked="true" />
                            </td><td>
                                <a href="">
                                    <img src="resource/img/moveup.png" alt="" />
                                </a>
                            </td><td>
                                <a href="">
                                    <img src="resource/img/movedown.png" alt="" />
                                </a>
                            </td></tr>
                            <?php
                        }
                        ?>
                    </table>
                    <br/><hr/>
                    <div class="toolButtonDiv">
                        <input type="submit" value="Download" />
                        <input type="button" value="Cancel" onclick="callUrl('<?php echo $backlink; ?>');" />
                    </div>
                </form>
                <?php
                
                break;
        }
        
    }
    
    function renderPreview () {
        
    }
}


?>