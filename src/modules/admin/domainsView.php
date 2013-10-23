<?php

require_once 'core/plugin.php';

class DomainsView extends XModule {
    
    function onProcess () {
        
        switch (parent::getAction()) {
            
        }
    }
    
    function onView () {
        
        switch (parent::getAction()) {
            
            default:
                $this->renderMainView();
        }
    }
    
    function renderMainView() {
        Context::addRequiredStyle("resource/js/datatables/css/demo_table_jui.css");
        Context::addRequiredScript("resource/js/datatables/js/jquery.dataTables.min.js");
        ?>
        <div class="panel domainsPanel">
            <table width="100%" class="nowrap"><tr>
		<td class="contract"><h3>Domains: </h3></td>
		<td class="contract"><button>Create Site</button></td>
		<td class="contract">Select Site: </td>
		<td class="expand"><?php InputFeilds::printSelect("site",null,array()); ?></td>
		<td class="contract"><button>Delete Site</button></td>
		<td class="contract"><button>Add Domain</button></td>
		<td class="contract"><button>Remove Domain</button></td>
	    </tr></table>
            </div>
            <div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="domains"></table>
                <hr/>
            </div>
        </div>
        <script type="text/javascript">
        var domains = [
            <?php
            $modules = DomainsModel::getDomains();
            $first = true;
            foreach ($modules as $module) {
                if (!$first)
                    echo ",";
                echo "['".Common::htmlEscape($module->id)."','".Common::htmlEscape($module->url)."']";
                $first = false;
            }
            ?>
        ];
        $(function() {
            var oTable = $('#domains').dataTable({
                "bScrollCollapse": false,
                "sScrollY": 200,
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "iDisplayLength": 10,
                "aLengthMenu": [[10, 20, 40, -1], [10, 20, 40, "All"]],
                "aaData": domains,
                "aoColumns": [
                    {'sTitle':'ID'},
                    {'sTitle':'Url'}]
            });
            $("#domains tbody").click(function(event) {
                $(oTable.fnSettings().aoData).each(function (){
                    $(this.nTr).removeClass('row_selected');
                });
                $(event.target.parentNode).addClass('row_selected');
            });
	    $(".domainsPanel button").each(function(index,object){
	    	$(object).button();
            });
        });
        </script>
        <?php
    }
    
}

?>