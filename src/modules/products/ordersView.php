<?php

require_once 'core/plugin.php';
require_once 'modules/products/ordersModel.php';
require_once 'modules/products/productsPageModel.php';
require_once 'modules/products/paymentModule.php';

class OrdersView extends XModule {

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {
        
        if (Context::hasRole("orders.edit")) {

            switch (parent::getAction()) {
                case "saveConfig":
                    parent::param("selectedForm",$_POST["selectedForm"]);
                    parent::param("responsibleRole",$_POST["responsibleRole"]);
                    parent::param("emailText",$_POST["emailText"]);
                    parent::param("emailSubject",$_POST["emailSubject"]);
                    parent::param("emailSender",$_POST["emailSender"]);
                    parent::redirect();
                    break;
                case "update":
                    parent::redirect();
                    break;
                case "delete":
                    OrdersModel::deleteOrder($_GET['id']);
                    parent::redirect(isset($_GET['order']) ? array("action"=>"editOrder","id"=>$_GET['order']) : array());
                    break;
                case "confirm":
                    // create and send email to responsibles 
                    $emailText = parent::param("emailText");
                    // list of ordered products
                    $ordersText = "<ul>";
                    $products = OrdersModel::getOrderProducts($_GET['id']);
                    $order = OrdersModel::getOrder($_GET['id']);
                    
                    foreach ($products as $product) {
                        $quantity = Common::htmlEscape($product->quantity);
                        $productName = Common::htmlEscape($product->titel);
                        $ordersText .= "<li>$quantity x $productName</li>";
                    }
                    $ordersText .= "</ul>";
                    // order details
                    // VirtualDataModel::
                    $detailsText = "<table>";
                    $table = VirtualDataModel::getTableById($order->orderform);
                    $columns = VirtualDataModel::getColumns($table->name);
                    $objectAttribs = VirtualDataModel::getRowByObjectIdAsArray($order->orderform, $order->objectid);
                    $rowNamesValues = array();
                    $oddColl = true;
                    foreach ($columns as $column) {
                        if ($column->edittype == VirtualDataModel::$dm_type_boolean) {
                            $detailsText .= "<tr " . ($oddColl ? "style='background-color:rgb(240,240,240)'" : "") . "><td style='text-align:right;'> </td><td>" . $objectAttribs[$column->name] . " - " . $column->name . "</td></tr>";
                        } else {
                            $detailsText .= "<tr " . ($oddColl ? "style='background-color:rgb(240,240,240)'" : "") . "><td style='text-align:right;'>" . $column->name . ": </td><td>" . $objectAttribs[$column->name] . "</td></tr>";
                        }
                        $oddColl = !$oddColl;
                    }
                    $detailsText .= "</table>";
                    // link to view the order
                    $orderLink = "<a href='".NavigationModel::getSitePath().NavigationModel::createStaticPageLink("shopBasket", array("basket" => Context::getUserId()), false)."'>Click Here</a>";
                    // replace tokens
                    $emailText = str_replace("&lt;orderText&gt;", $ordersText, $emailText);
                    $emailText = str_replace("&lt;detailText&gt;", $detailsText, $emailText);
                    $emailText = str_replace("&lt;viewLink&gt;", $orderLink, $emailText);
                    // send mail
                    $emails = UsersModel::getUsersEmailsByCustomRoleId(parent::param("responsibleRole"));
                    foreach ($emails as $email) {
                        EmailUtil::sendHtmlEmail($email, parent::param("emailSubject"), $emailText, parent::param("emailSender"));
                    }
                    // set the order status
                    OrdersModel::setOrderStatus($_GET['id'],2);
                    parent::redirect();
                    break;
                case "setProductStates":
                    OrdersModel::setOrderProductStatus($_GET['id'],$_GET['status']);
                    parent::redirect(isset($_GET['order']) ? array("action"=>"editOrder","id"=>$_GET['order']) : array());
                    break;
                case "finnish":
                    OrdersModel::setOrderStatus($_GET['id'],3);
                    parent::redirect();
                    break;
                case "edit":
                    parent::focus();
                    break;
                case "editQuantity":
                    parent::focus();
                    break;
                case "saveQuantity":
                    $products = OrdersModel::getOrderProducts($_GET['id']);
                    $quantitys = array();
                    foreach ($products as $product) {
                        if (isset($_POST['quantity_' . $product->productid])) {
                            $quantitys[$product->productid] = $_POST['quantity_' . $product->productid];
                        }
                    }
                    OrdersModel::updateQuantitys($_GET['id'], $quantitys);
                    parent::redirect(array("action"=>"editOrder","id"=>$_GET['id']));
                    break;
            }
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {
        
        if (Context::hasRole("orders.view")) {
            
            switch (parent::getAction()) {
                case "edit":
                    $this->printEditView(parent::getId());
                    break;
                case "editOrder": 
                    $this->printEditOrderView(parent::getId());
                    break;
                case "editQuantity":
                    $this->printEditOrderQuantityView();
                    break;
                default:
                    $this->printMainView(parent::getId());
            }
        }
    }

    /**
     * returns style sheets used by this module
     */
    function getStyles () {
        return array('css/products.css');
    }
    
    /**
     * returns style sheets used by this module
     */
    function getScripts () {
        return array('js/js.js');
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("orders.edit","orders.view","orders.all","orders.confirm","orders.finnish");
    }

    
    function printEditView ($pageId) {
        ?>
        <div class="panel">
            <form method="post" id="editOrdersForm" action="<?php echo parent::link(array("action"=>"saveConfig")); ?>">
                <table width="100%"><tr><td style="white-space: nowrap;">
                    <b>Formular w&auml;hlen: </b>
                </td><td class="expand">
                    <?php
                    $tables = VirtualDataModel::getTables();
                    $valueNameArray = Common::toMap($tables, "name", "name");
                    InputFeilds::printSelect("selectedForm", parent::param("selectedForm"), $valueNameArray);
                    ?>
                </td><td>
                    <button id="configTable">Konfigurieren</button>
                </td></tr><tr><td style="white-space: nowrap;">
                    <b>Responsible Rolegroup </b>
                </td><td colspan="2">
                    <?php
                    $roles = RolesModel::getCustomRoles();
                    $roles = Common::toMap($roles, "id", "name");
                    InputFeilds::printSelect("responsibleRole", parent::param("responsibleRole"), $roles);
                    ?>
                </td></tr><tr><td style="white-space: nowrap;">
                    <b>Email Subject </b>
                </td><td colspan="2">
                    <?php
                    InputFeilds::printTextFeild("emailSubject", parent::param("emailSubject"));
                    ?>
                </td></tr><tr><td style="white-space: nowrap;">
                    <b>Email Sender </b>
                </td><td colspan="2">
                    <?php
                    InputFeilds::printTextFeild("emailSender", parent::param("emailSender"));
                    ?>
                </td></tr><tr><td colspan="3">
                    <b><?php echo Common::htmlEscape('Here you can configure the text in the confirm notification email. "<orderText>" will be replaced with a description of the ordered products, "<detailText>" will be replaced with the content or the orderform, "<viewLink>" will be replaced with a link to the shopping basket view.'); ?></b>
                </td></tr><tr><td colspan="3">
                    <?php
                    InputFeilds::printHtmlEditor("emailText", parent::param("emailText"));
                    ?>
                </td></tr></table>
                <hr/>
                <div style="text-align: right;">
                    <button type="submit" id="btnSave">Speichern</div>
                </div>
            </form>
        </div>
        <script>
        $("#btnSave").button().click(function(){
            $("#editOrdersForm").submit();
        });
        $("#configTable").button();
        </script>
        <?php
    }
    
    function printEditOrderView ($pageId) {
        $order = OrdersModel::getOrder($_GET['id']);
        $user = UsersModel::getUser($order->userid);
        ?>
        <h2>Bestellungsstatus:</h2>
        <div style="height:64px;">
            <?php 
            switch ($order->status) {
                case 1:
                    ?>
                    <div style="float:left;">
                        <img src="resource/img/icons/Clock.png" alt=""/>
                    </div>
                    <div style="float:left; margin: 10px 20px">
                        Diese Bestellung erwartet eine Best&auml;tigung<br/>
                        <?php if (Context::hasRole("orders.confirm")) { 
                            ?><input type="button" id="confirmOrder" value="Bestellung best&auml;tigen" />
                        <?php } ?>
                    </div>
                    <?php 
                    break;
                case 2:
                    ?>
                    <div style="float:left;">
                        <img src="resource/img/icons/Tick.png" alt=""/>
                    </div>
                    <div style="float:left; margin: 10px 20px">
                        Diese Bestellung erwartet eine Fertigstellung<br/>
                        <?php if (Context::hasRole("orders.finnish")) { 
                            ?><input type="button" id="finnishOrder" value="Bestellung Fertigstellen" />
                        <?php } ?>
                    </div>
                    <?php 
                    break;
                case 3:
                    ?>
                    <div style="float:left;">
                        <img src="resource/img/icons/Present.png" alt=""/>
                    </div>
                    <div style="float:left; margin: 10px 20px">
                        Diese Bestellung wurde fertiggestellt.
                    </div>
                    <?php
                    break;
            }
            ?>
        </div>
        
        <h2>Bestellte Produkte:</h2>
        <?php
        $products = OrdersModel::getOrderProducts($_GET['id']);
        ?>
        <table width="100%" class="shopBasketTable">
            <tr>
                <td class="contract"> </td>
                <td style="width:50%"><b>Produkte</b></td>
                <td style="width:50%"><b>Status</b></td>
                <td class="contract" colspan="2"><b>Tools</b></td>
            </td>
            <?php
            $objectId = null;
            $isWaiting = false;
            foreach ($products as $product) {
                echo "<tr><td class='nowrap' style='text-align:right;'><b>".$product->quantity." x </b></td><td style='width:50%;'>";
                echo $product->titel;
                echo "</td><td class='nowrap'>";
                // print the status icon
                $img = "";
                $status = "";
                switch ($product->status) {
                   case "1":        // unconfirmed
                       $img = "Clock.png";
                       $status = "Waiting for confirmation";
                       $isWaiting = true;
                       break;
                   case "2":        // confirmed
                       $img = "Tick.png";
                       $status = "Order Confirmed";
                       break;
                   case "3":        // declined
                       $img = "Block.png";
                       $status = "Order Declined";
                       break;
                }
                echo "<img src='resource/img/".$img."' alt='' titel='Bestellung l�schen' /> ".$status;
                echo "</td><td>";
                echo "<a href='".parent::link(array("action"=>"editQuantity","id"=>$order->id))."' ><img src='resource/img/edit.png' /></a>";
                echo "</td><td>";
                echo "<a href='".parent::link(array("action"=>"setProductStates","id"=>$product->id,"status"=>"1","order"=>$_GET['id']))."' ><img src='resource/img/Clock.png' title='Bestellung unbest�tigten'/></a>";
                echo "</td><td>";
                echo "<a href='".parent::link(array("action"=>"setProductStates","id"=>$product->id,"status"=>"2","order"=>$_GET['id']))."' ><img src='resource/img/Tick.png' title='Bestellung best�tigen'/></a>";
                echo "</td><td>";
                echo "<a href='".parent::link(array("action"=>"setProductStates","id"=>$product->id,"status"=>"3","order"=>$_GET['id']))."' ><img src='resource/img/Block.png' title='Bestellung ablehnen'/></a>";
                echo "</td><td>";
                echo "<img src='resource/img/delete.png' onclick='doIfConfirm(\"Wollen Sie wirklich das Produkt von der Bestellung entfernen?\",\"".parent::link(array("action"=>"delete","id"=>$product->id,"order"=>$_GET['id']))."\");' alt='' titel='Bestellung l�schen' />";
                echo "</td></tr>";
            }
            ?>
        </table>
        <h2>User Infomation:</h2>
        <table><tr>
        <td>Username: </td>
        <td><?php echo $user->username; ?></td>
        </tr><tr>
        <td>First name: </td>
        <td><?php echo $user->firstname; ?></td>
        </tr><tr>
        <td>Last Name: </td>
        <td><?php echo $user->lastname; ?></td>
        </tr><tr>
        <td>E-mail: </td>
        <td><?php echo $user->email; ?></td>
        </tr></table>
        
        <table><tr><td>
            <h2>Bezahlung Methode:</h2>
        </td><td>
            <?php
            switch ($order->paymethod) {
                case PaymentModule::type_creditcard:
                    echo TranslationsModel::getTranslation("payments.payment.creditcard");
                    break;
                case PaymentModule::type_transfer:
                    echo TranslationsModel::getTranslation("payments.payment.transfer");
                    break;
                case PaymentModule::type_paypal:
                    echo TranslationsModel::getTranslation("payments.payment.paypall");
                    break;
                case PaymentModule::type_debit:
                    echo TranslationsModel::getTranslation("payments.payment.debit");
                    break;
            }
            ?>
        </td></tr></table>
        <?php
        echo "<table>";
        $orderAttributes = OrdersModel::getOrderAttributes($order->id);
        foreach ($orderAttributes as $orderAttribute) {
            echo "<tr><td>".TranslationsModel::getTranslation($orderAttribute->name).": </td><td>".($orderAttribute->value)."</td></tr>";
        }
        echo "</table>";
        ?>
        <h2>Bestellung Attribute:</h2>
        <?php
        DynamicDataView::displayObject(parent::param("selectedForm"), $order->objectid);
        ?>
        <br/>
        <hr>
        <input type="button" class="backButton" value="Z&uuml;ruck zu den Bestellungen" />
        
        <div id="checkOrdersDialog" title="Please set Order Status">
            <p class="validateTips">F&uuml;r die Fertigstellung, muss der Status aller Produkte definiert werden.</p>
        </div>
        
        <script>
        $("#checkOrdersDialog").dialog({
            autoOpen: false, modal: true,
            height: 250, width: 350,
            show: "fade", hide: "explode",
            buttons: {
                "Continue": function() {
                    $("#checkOrdersDialog").dialog("close");
                }
            }
        });
        <?php
        if (Context::hasRole("orders.confirm")) { 
            ?>
            $("#confirmOrder").button().click(function() {
                <?php
                if ($isWaiting) {
                    ?>
                    $("#checkOrdersDialog").dialog("open");
                    <?php
                } else {
                    ?>
                    callUrl("<?php echo parent::link(array("action"=>"confirm","id"=>$_GET['id']), false); ?>");
                    <?php
                }
                ?>
            });
            <?php
        }
        if (Context::hasRole("orders.finnish")) { 
            ?>
            $("#finnishOrder").button().click(function() {
                callUrl("<?php echo parent::link(array("action"=>"finnish","id"=>$_GET['id']), false); ?>");
            });
            <?php
        }
        ?>
        $(".backButton").button().click(function() {
            callUrl("<?php echo parent::link(array(), false); ?>");
        });
        </script>
        
        <?php
    }
    
    function printEditOrderQuantityView () {
        $orderId = $_GET['id'];
        $orders = OrdersModel::getOrderProducts($orderId);
        ?>
        <div class="panel">
            <?php
            if (!Common::isEmpty($orders)) {
                ?>
                <form method="post" id="quantityForm" action="<?php echo parent::link(array("action" => "saveQuantity", "id" => $orderId)); ?>">
                    <table width="100%" class="shopBasketTable">
                        <tr>
                            <td style="width:30%"><b>Quantity</b></td>
                            <td style="width:40%"><b>Products</b></td>
                            <td style="width:30%"><b>Status</b></td>
                            </td>
                            <?php
                            foreach ($orders as $order) {
                                echo "<tr><td>";
                                InputFeilds::printTextFeild("quantity_$order->productid", $order->quantity);
                                echo "</b></td><td>";
                                echo "" . $order->titel;
                                echo "</td><td class='nowrap'>";
                                // print the status icon
                                $img = "";
                                $status = "";
                                switch ($order->status) {
                                    case "0":        // unconfirmed
                                        $img = "edit.png";
                                        $status = "Bestellung wird bearbeitet";
                                        break;
                                    case "1":        // unconfirmed
                                        $img = "Clock.png";
                                        $status = "Warten auf Best&auml;tigung";
                                        break;
                                    case "2":        // confirmed
                                        $img = "Tick.png";
                                        $status = "Bestellung best&auml;tigt";
                                        break;
                                    case "3":        // declined
                                        $img = "Block.png";
                                        $status = "Bestellung abgelehnt";
                                        break;
                                }
                                echo "<img src='resource/img/" . $img . "' alt='' titel='Delete Order' /> " . $status;
                                echo "</td></tr>";
                            }
                            ?>
                    </table>
                    <hr/>
                    <div style="text-align: right;">
                        <button id="btnSave">Anderungen speichern</button>
                        <button id="btnCancel">Abbrechen</button>
                    </div>
                    <script>
                        $("#btnSave").each(function(key,value){
                            $(value).button().click(function(){
                                $("#quantityForm").submit();
                            });
                        });
                        $("#btnCancel").each(function(key,value){
                            $(value).button().click(function(){
                                callUrl("<?php echo parent::link(); ?>");
                            });
                        });
                    </script>
                    <?php
                } else {
                    echo "Der Warenkorb ist derzeit leer.";
                }
                ?>
        </div>
        <?php
    }
    
    function printMainView ($pageId) {
        Context::addRequiredStyle("resource/js/datatables/css/demo_table_jui.css");
        Context::addRequiredScript("resource/js/datatables/js/jquery.dataTables.min.js");
        if (!Common::isEmpty(parent::param("selectedForm"))) {
            ?>
            <div id="tabs">
                <ul>
                    <li><a href="#tabs-1">Neue Bestellungen</a></li>
                    <li><a href="#tabs-2">Best&auml;tigte Bestellungen</a></li>
                    <li><a href="#tabs-3">Beendete Bestellungen</a></li>
                </ul>
                <div id="tabs-1">
                    <?php
                    InfoMessages::printInfoMessage("");
                    ?>
                    <h3>Neue Bestellungen:</h3>
                    <div class="usersTableToolbar newOrdersButtons">
                        <button class="btnEdit">Best&auml;tigen / Bestellung editieren</button>
                        <button class="btnExport">Export</button>
                        <?php
                        if (Context::hasRole("orders.confirm")) { 
                            ?>
                            <button class="btnDelete">L&ouml;schen</button>
                            <?php
                        }
                        ?>
                    </div>
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="newOrders"></table>
                </div>
                <div id="tabs-2">
                    <?php
                    InfoMessages::printInfoMessage("");
                    ?>
                    <h3>Best&auml;tigte Bestellungen:</h3>
                    <div class="usersTableToolbar confirmedOrdersButtons">
                        <button class="btnEdit">Edit</button>
                        <button class="btnExport">Export</button>
                        <button class="btnDelete">L&ouml;schen</button>
                    </div>
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="confirmedOrders"></table>
                </div>
                <div id="tabs-3">
                    <?php
                    InfoMessages::printInfoMessage("");
                    ?>
                    <h3>Beendete Bestellungen:</h3>
                    <div class="usersTableToolbar finnishedOrdersButtons">
                        <button class="btnEdit">Edit</button>
                        <button class="btnExport">Export</button>
                        <button class="btnDelete">L&ouml;schen</button>
                    </div>
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="finnishedOrders"></table>
                </div>
            </div>
        
            <script>

            $("#orderType").change(function () {
                callUrl("<?php echo parent::link(array(),false); ?>",{"orderType":$("#orderType").val()});
            });
        
            <?php
            // print table header
            echo "var ar_columns = [";

            $first = true;
            $columns = VirtualDataModel::getColumns(parent::param("selectedForm"));
            echo "{'sTitle':'id'}";
            foreach ($columns as $column) {
                echo ",{'sTitle':'".Common::htmlEscape($column->name)."'}";
            }
            echo "]; ".PHP_EOL;

            echo "var newOrders = ".$this->getOrders(1);
            echo "var confirmedOrders = ".$this->getOrders(2);
            echo "var finnishedOrders = ".$this->getOrders(3);

            ?>
            var tables = [];
            function renderTable (tabindex) {
                var selectedTab = tabindex;
                var data; var tableName;
                switch (selectedTab) {
                    case 0:
                        data = newOrders;
                        tableName = "newOrders";
                        break;
                    case 1:
                        data = confirmedOrders;
                        tableName = "confirmedOrders";
                        break;
                    case 2:
                        data = finnishedOrders;
                        tableName = "finnishedOrders";
                        break;
                }
                if (selectedTab < 3) {
                    if (tables[selectedTab] == undefined) {
                        tables[selectedTab] = $('#'+tableName).dataTable({
                            "sScrollY": 300,
                            "sScrollX": "100%",
                            "sScrollXInner": "110%",
                            "bScrollCollapse": true,
                            "bPaginate": false,
                            "bJQueryUI": true,
                            "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
                            "aaData": data,
                            "aoColumns": ar_columns
                        });
                    } else {
                        // refresh table
                    }
                    tables[selectedTab].click(function(event) {
                        $(tables[selectedTab].fnSettings().aoData).each(function (){
                            $(this.nTr).removeClass('row_selected');
                        });
                        $(event.target.parentNode).addClass('row_selected');
                    });
                    $("."+tableName+"Buttons .btnDelete").button().click(function () {
                        var url = "<?php echo parent::link(array("action"=>"delete"),false); ?>";
                        callUrl(url,{"id":getSelectedRow(tables[selectedTab])[0].childNodes[0].innerHTML});
                    });
                    $("."+tableName+"Buttons .btnEdit").button().click(function () {
                        var url = "<?php echo parent::link(array("action"=>"editOrder"),false); ?>";
                        callUrl(url,{"id":getSelectedRow(tables[selectedTab])[0].childNodes[0].innerHTML});
                    });
                    $("."+tableName+"Buttons .btnExport").button().click(function () {
                        var url = "<?php echo parent::link(array("action"=>"export"),false); ?>";
                        callUrl(url,{"selectedTab":selectedTab});
                    });
                }
            }
            $("#tabs").tabs({
                "show": function(event, ui) {
                },
                "select": function(event, ui) {
                    renderTable(ui.index);
                }
            });
            renderTable(0);
            </script>
        
            <?php

        }
        
    }
    
    function getOrders ($status) {
        $b_first = true;
        // print table data
        $orders = null;
        $table = VirtualDataModel::getTable(parent::param("selectedForm"));
        if (Context::hasRole("orders.all")) {
            $orders = OrdersModel::getOrdersByStatus($status, $table->id);
        } else if (Context::hasRole("orders.view")) {
            $orders = OrdersModel::getOrdersByDistributor(Context::getUserId(),$table->id);
        }
        
        $ret = "[";
        if ($orders != null) {
            $columns = VirtualDataModel::getColumns(parent::param("selectedForm"));
            foreach ($orders as $order) {
                if (!$b_first)
                    $ret .= ",";
                $ret .= "['".$order->id."'";

                $orderObject = VirtualDataModel::getRowByObjectIdAsArray(parent::param("selectedForm"), $order->objectid);
                foreach ($columns as $column) {
                    $ret .= ",'".nl2br(Common::htmlEscape(isset($orderObject[$column->name]) ? trim($orderObject[$column->name]) : ""))."'";
                }
                $ret .= "]";
                $b_first = false;
            }
        }
        $ret .= "];".PHP_EOL;
        return $ret;
    }


}

?>