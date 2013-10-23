<?php
require_once 'core/plugin.php';
include_once 'modules/products/ordersModel.php';
include_once 'modules/products/productsPageModel.php';

class ShopBillsView extends XModule {

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess() {

        if (Context::hasRole("shop.basket.edit")) {

            switch (parent::getAction()) {

                case "save":
                    parent::param("selectedForm",$_POST['selectedForm']);
                    parent::param("responsibleRole",$_POST['responsibleRole']);
                    parent::param("billTemplate",$_POST['billTemplate']);
                    parent::param("emailSubject",$_POST['emailSubject']);
                    parent::param("mwst",$_POST['mwst']);
                    parent::redirect();
                    break;
                case "delete":
                    OrdersModel::deleteOrder($_GET['id']);
                    parent::redirect();
                    break;
                case "pay":
                    OrdersModel::setOrderStatus($_GET['id'], 3);
                    parent::redirect();
                    break;
                case "unpay":
                    OrdersModel::setOrderStatus($_GET['id'], 1);
                    parent::redirect();
                    break;
                case "cancel":
                    OrdersModel::setOrderStatus($_GET['id'], 4);
                    parent::redirect();
                    break;
                case "finnish":
                    OrdersModel::setOrderStatus($_GET['id'], 3);
                    parent::redirect();
                    break;
                case "order":
                    $table = VirtualDataModel::getTable(parent::param("orderForm"));
                    $orderForm = OrdersModel::getOrderAttribs($table->id, Context::getUserId());
                    if ($orderForm != null) {
                        parent::redirect(array("action" => "createOrder"));
                    }
                    break;
                case "createObject":
                    $order = OrdersModel::getOrder($_GET['id']);
                    $table = VirtualDataModel::getTableById($order->orderform);
                    $objectId = DynamicDataView::createObject($table->name);
                    OrdersModel::setObjectId($order->id, $objectId);
                    if (isset($_SESSION['basket.order.send'])) {
                        parent::redirect(array("action"=>"sendOrder","id"=>$_GET['id']));
                    } else {
                        parent::redirect();
                    }
                    break;
                case "editObject":
                    $order = OrdersModel::getOrder($_GET['id']);
                    $table = VirtualDataModel::getTableById($order->orderform);
                    DynamicDataView::processAction($table->name, parent::link(), parent::link());
                    parent::redirect(array("action"=>"´view","orderId"=>$_GET['id']));
                    break;
                case "saveQuantity":
                    $products = OrdersModel::getOrderProducts($_GET['id']);
                    $quantitys = array();
                    
                    foreach ($products as $product) {
                        echo "product ".$product->productid."<br/>";
                        if (isset($_POST['quantity_' . $product->productid])) {
                            $quantitys[$product->productid] = $_POST['quantity_' . $product->productid];
                            echo "product ".$_POST['quantity_' . $product->productid]."<br/>";
                        }
                    }
                    OrdersModel::updateQuantitys($_GET['id'], $quantitys);
                    parent::redirect(array("action"=>"view","orderId"=>$_GET['id']));
                    break;
                case "send":
                    
                    // get order and product info
                    $orderId = $_GET['id'];
                    $order = OrdersModel::getOrder($orderId);
                    $products = OrdersModel::getOrderProducts($orderId);
                    
                    // set the order status from waiting to confirmed
                    OrdersModel::setOrderStatus($order->id, 1);
                    foreach ($products as $product) {
                        OrdersModel::setOrderProductStatus($product->id, 1);
                    }
                    
                    // create info mail
                    $emailText = parent::param("billTemplate");
                    
                    // list of ordered products
                    $ordersText = "<table width='100%'><tr>
                        <td>Artikel-Nr</td>
                        <td>Bezeichnung</td>
                        <td>Menge</td>
                        <td>Einzelpreis</td>
                        <td>Gesamtpreis
                        </td></tr>";
                    $sum = 0;
                    foreach ($products as $product) {
                        $ordersText .= "<tr>
                            <td>".$product->productid."</td>
                            <td>".$product->titel."</td>
                            <td>".$product->quantity."</td>
                            <td>".$product->price."</td>";
                        $productPrice = $product->price * $product->quantity;
                        $sum += $productPrice;
                        $ordersText .= "<tr>".$productPrice."</td></tr>";

                    }
                    $ordersText .= "</tr><tr><td colspan='4' style='text-align:right;'>sum:</td><td>$sum</td></tr></table>";
                    
                    // order details
                    $detailsText = DynamicDataView::displayObjectAsString($order->orderform, $order->objectid);
                    
                    // user details
                    $user = UsersModel::getUser($order->userid);
                    $userText = DynamicDataView::displayObjectAsString("userAttribs", $user->objectid);
                    
                    // bill details
                    $billText = "<table>
                        <tr><td>Rechnungsnr:</td><td>".$order->id."</td></tr>
                        <tr><td>Datum:</td><td>".$order->orderdate."</td></tr>
                        <tr><td>Kundennr:</td><td>".$order->userid."</td></tr>
                        </table>";
                    
                    // endsum
                    $mwst = ($sum/100) * parent::param("mwst");
                    $rabatt = -((($sum + $mwst) / 100) * $order->rabatt);
                    $finalPrice = $sum + $mwst + $rabatt;
                    $endSum = "<table style='text-align:right;'>
                        <tr><td>Nettobetrag</td><td></td><td>".$sum."</td><tr/>
                        <tr><td>Mwst</td><td>".parent::param("mwst")."%</td><td>".$mwst."</td><tr/>
                        <tr><td>Rabatt</td><td>".$order->rabatt."%</td><td>".$rabatt."</td><tr/>
                        <tr><td>Endbetrag</td><td></td><td>".$finalPrice."</td><tr/>
                    </table>";
                    
                    // replace tokens
                    $emailText = str_replace("&lt;productinfo&gt;", $ordersText, $emailText);
                    $emailText = str_replace("&lt;orderinfo&gt;", $detailsText, $emailText);
                    $emailText = str_replace("&lt;userinfo&gt;", $userText, $emailText);
                    $emailText = str_replace("&lt;endsum&gt;", $endSum, $emailText);
                    $emailText = str_replace("&lt;billinfo&gt;", $billText, $emailText);
                    
                    
                    // send to recipient
                    $email = UsersModel::getUserEmailById($order->userid);
                    EmailUtil::sendHtmlEmail($email, parent::param("emailSubject"), $emailText, parent::param("emailSender"));
                    break;
                    
                case "createUser":
                    $userObjectId = DynamicDataView::createObject("userAttribs");
                    $user = UsersModel::getUserByObjectId($userObjectId);
                    //parent::redirect(array("action"=>"new","selectedUser"=>$user->id));
                    // break;
                    $_GET['id'] = $user->id;
                case "selectUser":
                    // create the order with the selected user
                    $orderId = OrdersModel::createOrder($_GET['id'], array(), parent::param("selectedForm"), parent::param("responsibleRole"));
                    $tableObj = VirtualDataModel::getTableById(parent::param("selectedForm"));
                    $objectId = VirtualDataModel::insertRow($tableObj->name,array());
                    OrdersModel::setObjectId($orderId, $objectId);
                    parent::redirect(array("action"=>"view","selectedUser"=>$_GET['id'],"orderId"=>$orderId));
                    parent::focus();
                    break;
                case "new":
                    parent::focus();
                    break;
                case "createproduct":
                    if (Context::hasRole("products.edit")) {
                        $nextImageId = md5(microtime());
                        $uploadedFile = $_FILES['productimage']['name'];
                        $type = strtolower(substr($uploadedFile,strrpos($uploadedFile,".")+1,3));
                        $targetPath = ResourcesModel::getResourcePath("products", "$nextImageId.$type");
                        if(!move_uploaded_file($_FILES['productimage']['tmp_name'], $targetPath)) {
                            echo "error moving uploaded file!";
                        }
                        ProductsPageModel::createProduct($pageId, "$nextImageId.$type", $this->articleContent, $_POST['articleName'], $_POST['stockAmount'], $_POST['price'], $_POST['minimumAmount'], Context::getLang());
                    }
                    parent::redirect(array("action"=>"addProduct","selectedUser"=>$_GET['selectedUser'],"orderId"=>$_GET['orderId']));
                    break;
                case "deleteproduct":
                    if (Context::hasRole("products.edit")) {
                        ProductsPageModel::deleteProduct($this->productId);
                    }
                    parent::redirect();
                    break;
                case "updateproduct":
                    if (Context::hasRole("products.edit")) {
                        $nextImageId = md5(microtime());
                        $uploadedFile = $_FILES['productimage']['name'];
                        $type = strtolower(substr($uploadedFile,strrpos($uploadedFile,".")+1,3));
                        $targetPath = ResourcesModel::getResourcePath("products", "$nextImageId.$type");
                        if(!move_uploaded_file($_FILES['productimage']['tmp_name'], $targetPath)) {
                            $imageFile = $_POST['oldproductimage'];
                        } else {
                            $imageFile = "$nextImageId.$type";
                        }
                        ProductsPageModel::updateProduct($this->productId, $pageId,$imageFile, $this->articleContent, $_POST['articleName'], $_POST['stockAmount'], $_POST['price'], $_POST['minimumAmount'], Context::getLang());
                    }
                    parent::redirect();
                    break;
                case "selectProduct":
                    $productObj->quantity = $_GET['quantity'];
                    OrdersModel::createOrder($_GET['selectedUser'], array($_GET['id']=>$productObj),parent::param("selectedForm"), parent::param("responsibleRole"));
                    parent::redirect(array("action"=>"view","selectedUser"=>$_GET['selectedUser'],"orderId"=>$_GET['orderId']));
                    break;
            }
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView() {

        if (Context::hasRole("shop.basket.view")) {

            switch (parent::getAction()) {

                case "viewDetails":
                    if (Context::hasRole("shop.basket.details.view")) {
                        $this->printEditOrderDetailsView($_GET['id']);
                    }
                case "editDetails":
                    if (Context::hasRole("shop.basket.details.edit")) {
                        $order = OrdersModel::getOrder($_GET['id']);
                        DynamicDataView::editObject(parent::param("selectedForm"),$order->id,"Order Attributes:",
                        parent::link(array("action"=>"view","orderId"=>$_GET['id']),false), 
                        parent::link(array("action"=>"editObject","id"=>$_GET['id']),false));
                    }
                    break;
                case "editQuantity":
                    if (Context::hasRole("shop.basket.details.edit")) {
                        $this->printEditOrderQuantityView($_GET['id']);
                    }
                    break;
                case "print":
                    $this->printOrderPrintView($_GET['id']);
                    break;
                case "edit":
                    if (Context::hasRole("shop.basket.edit")) {
                        $this->printEditView(parent::getId());
                    }
                    break;
                case "sendOrder":
                    $this->printEditView(parent::getId(),true);
                    break;
                case "addProduct":
                    $this->printSelectProductView();
                    break;
                case "editProduct":
                    $this->printEditProductView();
                    break;
                case "new":
                    $this->printNewView();
                    break;
                case "view":
                    $this->printViewView();
                    break;
                default:
                    if (Context::hasRole("shop.basket.view")) {
                        $userId = Context::getUserId();
                        if (isset($_GET['basket'])) {
                            $userId = $_GET['basket'];
                        }
                        $this->printMainView($userId);
                    }
            }
        }
    }

    /**
     * returns style sheets used by this module
     */
    function getStyles() {
        return array('css/products.css');
    }

    /**
     * returns style sheets used by this module
     */
    function getScripts() {
        return array('js/js.js');
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles() {
        return array("shop.basket.view", "shop.basket.status.edit", "shop.basket.edit", "shop.basket.details.view", "shop.basket.details.edit");
    }

    
    function printMainView ($pageId) {
        Context::addRequiredStyle("resource/js/datatables/css/demo_table_jui.css");
        Context::addRequiredScript("resource/js/datatables/js/jquery.dataTables.min.js");
        if (!Common::isEmpty(parent::param("selectedForm"))) {
            ?>
            <div id="tabs_<?php echo parent::getId(); ?>">
                <ul>
                    <li><a href="#tabs-1">Angebote</a></li>
                    <li><a href="#tabs-2">Offene Rechnungen</a></li>
                    <li><a href="#tabs-3">Bezahlte Rechnungen</a></li>
                    <li><a href="#tabs-4">Storno</a></li>
                    <li><a href="#tabs-5">Mahnungen</a></li>
                </ul>
                <div id="tabs-1">
                    <div class="alignRight">
                        <button class="btn_newBill">New</button>
                        <button class="btn_viewBill">View</button>
                        <button class="btn_sendBill">Send</button>
                        <button class="btn_deleteBill">Delete</button>
                    </div>
                    <hr/>
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="newTable"></table>
                </div>
                <div id="tabs-2">
                    <div class="alignRight">
                        <button class="btn_viewBill">View</button>
                        <button class="btn_payedBill">Payed</button>
                        <button class="btn_cancelBill">Cancel</button>
                    </div>
                    <hr/>
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="openTable"></table>
                </div>
                <div id="tabs-3">
                    <div class="alignRight">
                        <button class="btn_viewBill">View</button>
                        <button class="btn_unpayBill">Unpayed</button>
                    </div>
                    <hr/>
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="payedTable"></table>
                </div>
                <div id="tabs-4">
                    <div class="alignRight">
                        <button class="btn_viewBill">View</button>
                        <button class="btn_deleteBill">Delete</button>
                    </div>
                    <hr/>
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="cancelTable"></table>
                </div>
                <div id="tabs-5">
                    <div class="alignRight">
                        <button class="btn_viewBill">View</button>
                        <button class="btn_sendBill">Send</button>
                        <button class="btn_payedBill">Payed</button>
                        <button class="btn_cancelBill">Cancel</button>
                    </div>
                    <hr/>
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="warnTable"></table>
                </div>
            </div>
            <script>
            $("#tabs_<?php echo parent::getId(); ?>").tabs();
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
            
            echo "var newOrders = ".$this->getOrders(0).PHP_EOL;
            echo "var openOrders = ".$this->getOrders(1).PHP_EOL;
            echo "var payedOrders = ".$this->getOrders(3).PHP_EOL;
            echo "var canceledOrders = ".$this->getOrders(4).PHP_EOL;
            echo "var warnOrders = ".$this->getOrders(5).PHP_EOL;
            ?>
            var ar_columns = [
                {'sTitle':'id'},{'sTitle':'Username'},{'sTitle':'Lastname'},{'sTitle':'Firstname'},{'sTitle':'Price'}
            ];
            var tables = [];
            var selectedTab = 0;
            function renderTable (tabindex) {
                selectedTab = tabindex;
                var data; var tableName;
                switch (selectedTab) {
                    case 0:
                        data = newOrders;
                        tableName = "newTable";
                        break;
                    case 1:
                        data = openOrders;
                        tableName = "openTable";
                        break;
                    case 2:
                        data = payedOrders;
                        tableName = "payedTable";
                        break;
                    case 4:
                        data = canceledOrders;
                        tableName = "cancelTable";
                        break;
                    case 3:
                        data = warnOrders;
                        tableName = "warnTable";
                        break;
                }
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

                $(".btn_viewBill").each(function (index,obj) {
                    $(obj).button().click(function (){
                        var url = "<?php echo parent::link(array("action"=>"view"),false); ?>";
                        callUrl(url,{"orderId":getSelectedRow(tables[selectedTab])[0].childNodes[0].innerHTML});
                    });
                });
                $(".btn_sendBill").each(function (index,obj) {
                    $(obj).button().click(function (){
                        var url = "<?php echo parent::link(array("action"=>"send"),false); ?>";
                        callUrl(url,{"id":getSelectedRow(tables[selectedTab])[0].childNodes[0].innerHTML});
                    });
                });
                $(".btn_payedBill").each(function (index,obj) {
                    $(obj).button().click(function (){
                        var url = "<?php echo parent::link(array("action"=>"pay"),false); ?>";
                        callUrl(url,{"id":getSelectedRow(tables[selectedTab])[0].childNodes[0].innerHTML});
                    });
                });
                $(".btn_cancelBill").each(function (index,obj) {
                    $(obj).button().click(function (){
                        var url = "<?php echo parent::link(array("action"=>"cancel"),false); ?>";
                        callUrl(url,{"id":getSelectedRow(tables[selectedTab])[0].childNodes[0].innerHTML});
                    });
                });
                $(".btn_unpayBill").each(function (index,obj) {
                    $(obj).button().click(function (){
                        var url = "<?php echo parent::link(array("action"=>"unpay"),false); ?>";
                        callUrl(url,{"id":getSelectedRow(tables[selectedTab])[0].childNodes[0].innerHTML});
                    });
                });
                $(".btn_newBill").each(function (index,obj) {
                    $(obj).button().click(function (){
                        var url = "<?php echo parent::link(array("action"=>"new"),false); ?>";
                        callUrl(url);
                    });
                });
                $(".btn_deleteBill").each(function (index,obj) {
                    $(obj).button().click(function (){
                        var url = "<?php echo parent::link(array("action"=>"delete"),false); ?>";
                        callUrl(url,{"id":getSelectedRow(tables[selectedTab])[0].childNodes[0].innerHTML});
                    });
                });
            }
            $("#tabs_<?php echo parent::getId(); ?>").tabs({
                show: function(event, ui) {
                },
                select: function(event, ui) {
                    renderTable(ui.index);
                }
            });
            renderTable(0);
            </script>
        
            <?php

        }
        
    }
    
    function printEditOrderQuantityView($orderId) {
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
                        <button id="btnSave">&Auml;nderungen speichern</button>
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
                    echo "Der Warenkorb ist leer.";
                }
                ?>
        </div>
        <?php
    }
    
    function printOrderPrintView ($orderId) {
        // get order and product info
        $order = OrdersModel::getOrder($orderId);
        $products = OrdersModel::getOrderProducts($orderId);

        // create info mail
        $emailText = parent::param("billTemplate");

        // list of ordered products
        $ordersText = "<table width='100%'><tr>
            <td>Artikel-Nr</td>
            <td>Bezeichnung</td>
            <td>Menge</td>
            <td>Einzelpreis</td>
            <td>Gesamtpreis
            </td></tr>";
        $sum = 0;
        foreach ($products as $product) {
            $ordersText .= "<tr>
                <td>".$product->productid."</td>
                <td>".$product->titel."</td>
                <td>".$product->quantity."</td>
                <td>".$product->price."</td>";
            $productPrice = $product->price * $product->quantity;
            $sum += $productPrice;
            $ordersText .= "<tr>".$productPrice."</td></tr>";

        }
        $ordersText .= "</tr><tr><td colspan='4' style='text-align:right;'>sum:</td><td>$sum</td></tr></table>";

        // order details
        $detailsText = DynamicDataView::displayObjectAsString($order->orderform, $order->objectid);

        // user details
        $user = UsersModel::getUser($order->userid);
        $userText = DynamicDataView::displayObjectAsString("userAttribs", $user->objectid);

        // bill details
        $billText = "<table>
            <tr><td>Rechnungsnr:</td><td>".$order->id."</td></tr>
            <tr><td>Datum:</td><td>".$order->orderdate."</td></tr>
            <tr><td>Kundennr:</td><td>".$order->userid."</td></tr>
            </table>";

        // endsum
        $mwst = ($sum/100) * parent::param("mwst");
        $rabatt = -((($sum + $mwst) / 100) * $order->rabatt);
        $finalPrice = $sum + $mwst + $rabatt;
        $endSum = "<table style='text-align:right;'>
            <tr><td>Nettobetrag</td><td></td><td>".$sum."</td><tr/>
            <tr><td>Mwst</td><td>".parent::param("mwst")."%</td><td>".$mwst."</td><tr/>
            <tr><td>Rabatt</td><td>".$order->rabatt."%</td><td>".$rabatt."</td><tr/>
            <tr><td>Endbetrag</td><td></td><td>".$finalPrice."</td><tr/>
        </table>";

        // replace tokens
        $emailText = str_replace("&lt;productinfo&gt;", $ordersText, $emailText);
        $emailText = str_replace("&lt;orderinfo&gt;", $detailsText, $emailText);
        $emailText = str_replace("&lt;userinfo&gt;", $userText, $emailText);
        $emailText = str_replace("&lt;endsum&gt;", $endSum, $emailText);
        $emailText = str_replace("&lt;billinfo&gt;", $billText, $emailText);

        ?>
        <html>
            <head></head>
            <body onload='window.print();'>
                <?php echo $emailText; ?>
            </body>
        </html>
        <?php
    }
    
    function printEditProductView () {

        $article = null; $productId = null;
        if (!isset($_GET['productid']) || Common::isEmpty($_GET['productid'])) {
            $formAction = "createproduct";
        } else {
            $formAction = "updateproduct";
            $productId = $_GET['productid'];
            $article = ProductsPageModel::getProduct($_GET['productid'], Context::getLang());
        }

        ?>
        <div class="panel">
            <form id="fmProductForm" method="post" enctype="multipart/form-data"  action="<?php echo parent::link(array("action"=>$formAction,"productid"=>$productId,"selectedUser"=>$_GET['selectedUser'],"orderId"=>$_GET['orderId'])); ?>">
                <input type="hidden" name="oldproductimage" value="<?php echo $productId == null ? "" : $article->img; ?>" />
                <table width="100%"><tr><td class="expand nowrap" style="vertical-align: top;"> 
                    <table width="100%"><tr><td class="contract nowrap">
                        <b>W&auml;hlen Sie das Produktbild:</b>
                    </td><td class="expand">
                        <input type="file" class="expand" name="productimage" />
                    </td></tr><tr><td>
                        <b>Name des Produkt:</b>
                    </td><td>
                        <?php
                        InputFeilds::printTextFeild("articleName", $productId == null ? "" :$article->titel, "expand");
                        ?>
                    </td></tr><tr><td>
                        <b>Lagerbestand:</b>
                    </td><td>
                        <?php
                        InputFeilds::printTextFeild("stockAmount", $article == null ? "" :$article->quantity, "expand");
                        ?>
                    </td></tr><tr><td>
                        <b>Price:</b>
                    </td><td>
                        <?php
                        InputFeilds::printTextFeild("price", $article == null ? "" :$article->price, "expand");
                        ?>
                    </td></tr><tr><td>
                        <b>Mindestabnahme:</b>
                    </td><td>
                        <?php
                        InputFeilds::printTextFeild("minimumAmount", $article == null ? "" :$article->minimum, "expand");
                        ?> 
                    </td></tr></table>
                </td><td style="vertical-align: top;" class="contract">
                    <?php
                    if ($article != null) {
                        ?>
                        <img class="productsImage imageLink" src="<?php echo ResourcesModel::createResourceLink("products", $article->img); ?>" alt=""/>
                        <?php
                    }
                    ?>
                </td></tr></table>
                <br/>
                <div class="formFeildLine">
                    <b>Pflegen Sie hier bitte die Beschreibung des Produkts ein:</b>
                </div>
                <div class="formFeild">
                    <?php
                    InputFeilds::printHtmlEditor("articleContent", $productId == null ? "" :$article->text);
                    ?>
                </div>
                <br/>
                <hr/>
                <div class="formFeildButtons" align="right">
                    <button id="btnSave">Speichern</button>
                    <button id="btnCancel">Abbrechen</button>
                </div>
            </form>
        </div>
        <script>
        $("#btnSave").button().click(function () {
            $("#fmProductForm").submit();
        });
        $("#btnCancel").button().click(function (e) {
            callUrl('<?php echo parent::link(array('action'=>'addProduct','selectedUser'=>$_GET['selectedUser'],'orderId'=>$_GET['orderId'])); ?>');
            e.preventDefault();
        });
        </script>
        <?php
    }
    
    function printSelectProductView () {
        Context::addRequiredStyle("resource/js/datatables/css/demo_table_jui.css");
        Context::addRequiredScript("resource/js/datatables/js/jquery.dataTables.min.js");
        $userId = null;
        if (isset($_GET['selectedUser'])) {
            $userId = $_GET['selectedUser'];
        }
        $orderId = null;
        if (isset($_GET['orderId'])) {
            $orderId = $_GET['orderId'];
        }
        $products = ProductsPageModel::getAllProducts();
        $users = UsersModel::getUsers();
        $b_first = true;
        
        ?>
        <div class="alignRight">
            <form>
                Quantity: 
                <input type="text" id="quantity" value="1" />
            </form>
            <button id="btnAdd">Create Product</button>
            <button id="btnEdit">Edit Product</button>
            <button id="btnSelect">Select Product</button>
        </div>
        <hr/>
        <table cellpadding="0" cellspacing="0" border="0" class="display" id="activeUsers"></table>
        
        <script>
        <?php
        // print table header
        echo "var ar_columns = [{'sTitle':'ID'},{'sTitle':'Name'},{'sTitle':'Stock'},{'sTitle':'Price'}];".PHP_EOL;
        // print table data
        echo "var ar_products = [";
        foreach ($products as $user) {
            if (!$b_first)
                echo ",";
            echo "['".Common::htmlEscape($user->id)."','".Common::htmlEscape($user->titel)."','".Common::htmlEscape($user->quantity)."','".Common::htmlEscape($user->price)."']".PHP_EOL;
            $b_first = false;
        }
        echo "];".PHP_EOL;
        ?>
        var productsTable;
        function renderTable (tabindex) {
            var data = ar_products;
            var tableName = "activeUsers";
            productsTable = $('#'+tableName).dataTable({
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
            productsTable.click(function(event) {
                $(productsTable.fnSettings().aoData).each(function (){
                    $(this.nTr).removeClass('row_selected');
                });
                $(event.target.parentNode).addClass('row_selected');
            });
            $("#btnSelect").button().click(function () {
                var url = "<?php echo parent::link(array("action"=>"selectProduct","selectedUser"=>$userId,"orderId"=>$orderId),false); ?>";
                callUrl(url,{"id":getSelectedRow(productsTable)[0].childNodes[0].innerHTML,"quantity":$("#quantity").val()});
            });
            $("#btnAdd").button().click(function () {
                var url = "<?php echo parent::link(array("action"=>"editProduct","selectedUser"=>$userId,"orderId"=>$orderId),false); ?>";
                callUrl(url);
            });
            $("#btnEdit").button().click(function () {
                var url = "<?php echo parent::link(array("action"=>"editProduct","selectedUser"=>$userId,"orderId"=>$orderId),false); ?>";
                callUrl(url,{"productid":getSelectedRow(productsTable)[0].childNodes[0].innerHTML});
            });
        }
        renderTable(0);
        </script>
        <?php
    }
    
    function printNewView () {
        Context::addRequiredStyle("resource/js/datatables/css/demo_table_jui.css");
        Context::addRequiredScript("resource/js/datatables/js/jquery.dataTables.min.js");
        $userId = null;
        if (isset($_GET['selectedUser'])) {
            $userId = $_GET['selectedUser'];
        }
        
        if ($userId == null) {
            // select user
            
            InfoMessages::printInfoMessage("bills.select.user");
            ?>
            <br/>
            <div class="alignRight">
                <button class="btnAdd">Add User</button>
                <button class="btnSelect">Select User</button>
            </div>
            <hr/>
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="activeUsers"></table>
        
            <div id="registerUserDialog" title="Register User">
                <p class="validateTips">Please fill out these attributes, they are the minimum datafeilds that are required to register a user.</p>
                <form method="post" id="registerUserForm" action="<?php echo parent::link(array("action"=>"createUser")); ?>">
                    <?php
                    DynamicDataView::renderCreateObject("userAttribs", parent::link(),parent::link());
                    ?>
                </form>
            </div>
            <script type="text/javascript">
            <?php
            $users = UsersModel::getUsers();
            $b_first = true;
            // print table header
            echo "var ar_columns = [{'sTitle':'ID'},{'sTitle':'Username'},{'sTitle':'Firstname'},{'sTitle':'Lastname'},{'sTitle':'Email'},{'sTitle':'Active','bVisible': false}];".PHP_EOL;
            // print table data
            echo "var ar_users = [";
            foreach ($users as $user) {
                if (!$b_first)
                    echo ",";
                echo "['".Common::htmlEscape($user->id)."','".Common::htmlEscape($user->username)."','".Common::htmlEscape($user->firstname)."','".Common::htmlEscape($user->lastname)."','".Common::htmlEscape($user->email)."','".Common::htmlEscape($user->active)."']".PHP_EOL;
                $b_first = false;
            }
            echo "];".PHP_EOL;
            ?>
            var usersTable;
            function renderTable (tabindex) {
                var data = ar_users;
                var tableName = "activeUsers";
                usersTable = $('#'+tableName).dataTable({
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
                usersTable.click(function(event) {
                    $(usersTable.fnSettings().aoData).each(function (){
                        $(this.nTr).removeClass('row_selected');
                    });
                    $(event.target.parentNode).addClass('row_selected');
                });
                $(".btnSelect").button().click(function () {
                    callUrl("<?php echo parent::link(array("action"=>"selectUser"),false); ?>",{"id":getSelectedRow(usersTable)[0].childNodes[0].innerHTML});
                });
                $(".btnAdd").button().click(function () {
                    $("#registerUserDialog").dialog("open");
                });
            }
            // regist user dialog
            $("#registerUserDialog").dialog({
                autoOpen: false, height:350, width:450, modal: true,
                buttons: {
                    "Ok": function() {
                        $("#registerUserForm").submit();
                    }, "Cancel": function() {
                        $(this).dialog("close");
                    }
                }
            });
            renderTable(0);
            </script>
            <?php
            
            
        }
        
    }
    
    function printViewView () {
        
        $orderId = null;
        if (isset($_GET['orderId'])) {
            $orderId = $_GET['orderId'];
        }
        
        $order = OrdersModel::getOrder($orderId);
        $products = OrdersModel::getOrderProducts($orderId);
        
        $user = UsersModel::getUser($order->userid);
        $selectedUser = $user->id;
        
        $finalPrice = 0;
        $mwst = 0;
        $sum = 0;
        $rabatt = 0;
        ?>
        <div class="panel">
            <div class="alignRight">
                <button class="btnAddProduct">Add Product</button>
                <button class="btnPrint">Ausdrucken</button>
                <button class="btnBack">Zur&uuml;ck</button>
            </div>
            <hr/>
            <h3>Bestellung</h3>
            <table width="100%"><tr><td>
                Artikel-Nr   
            </td><td>
                Bezeichnung
            </td><td>
                Menge
            </td><td>
                Einzelpreis
            </td><td>
                Gesamtpreis
            </td></tr>
                <?php
                foreach ($products as $product) {
                    ?>
                    <tr><td>
                        <?php echo $product->productid; ?>
                    </td><td>
                        <?php echo $product->titel; ?>
                    </td><td>
                        <?php echo $product->quantity; ?>
                    </td><td>
                        <?php echo $product->price; ?>
                    </td><td>
                        <?php 
                        $productPrice = $product->price * $product->quantity;
                        echo $productPrice; 
                        $sum += $productPrice;
                        ?>
                    </td></tr>
                    <?php
                }
                ?>
            </table>
            <?php
            $mwst = ($sum/100) * 19;
            $rabatt = -((($sum + $mwst) / 100) * $order->rabatt);
            $finalPrice = $sum + $mwst + $rabatt;
            ?>
            <div class="alignRight">
                <button class="btnEditQuantity">Menge bearbeiten</button>
            </div>
            <hr/>
            <h3>Summe</h3>
            <table style="text-align:right;"><tr><td>
                Nettobetrag        
            </td><td>
                
            </td><td>
                <?php echo $sum; ?>
            </td><tr/><tr><td>
                Mwst
            </td><td>
                <?php echo parent::param("mwst"); ?>% 
            </td><td>
                <?php echo $mwst; ?>
            </td><tr/><tr><td>
                Rabatt
            </td><td>
                <?php echo $order->rabatt; ?>% 
            </td><td>
                <?php echo $rabatt; ?>
            </td><tr/><tr><td>
                Endbetrag
            </td><td>
                
            </td><td>
                <?php echo $finalPrice; ?>
            </td><tr/></table>
            <hr/>
            <h3>User Attributes</h3>
            <?php
            DynamicDataView::displayObject("userAttribs",$user->objectid);
            ?>
            <hr/>
            <h3>Order Attributes</h3>
            <?php
            DynamicDataView::displayObject($order->orderform,$order->objectid);
            ?>
            <div class="alignRight">
                <button class="btnEditDetails">Bearbeiten</button>
            </div>
            <hr/>
            <div class="alignRight">
                <button class="btnAddProduct">Add Product</button>
                <button class="btnPrint">Ausdrucken</button>
                <button class="btnBack">Zur&uuml;ck</button>
            </div>
            
            <script>
            $(".btnPrint").each(function (index,object) {
                $(object).button().click(function () {
                    callUrl("<?php echo parent::ajaxLink(array("action"=>"print","id"=>$orderId)); ?>");
                });
            });
            $(".btnBack").each(function (index,object) {
                $(object).button().click(function () {
                    callUrl("<?php echo parent::link(); ?>");
                });
            });
            $(".btnAddProduct").each(function (index,object) {
                $(object).button().click(function () {
                    callUrl("<?php echo parent::link(array("action"=>"addProduct","orderId"=>$orderId,"selectedUser"=>$selectedUser),false); ?>");
                });
            });
            $(".btnEditQuantity").button().click(function () {
                    callUrl("<?php echo parent::link(array("action" => "editQuantity", "id" => $orderId),false); ?>");
            });
            $(".btnEditDetails").button().click(function () {
                callUrl("<?php echo parent::link(array("action" => "editDetails", "id" => $orderId),false); ?>");
            });
            </script>
        </div>
        <?php
    }
    
    function printEditView () {
        ?>
        <div class="panel">
            <?php
            $tables = VirtualDataModel::getTables();
            if (count($tables) > 0) {
                $valueNameArray = Common::toMap($tables, "name", "name");
                ?>
                <div class="panel">
                    <h3>Configure Bills View</h3>
                    <form method="post" id="formForm" action="<?php echo parent::link(array("action"=>"save")); ?>">
                        <table width="100%" style="white-space: nowrap;"><tr><td>
                            <b>Formular w&auml;hlen:</b>
                        </td><td class="expand">
                            <?php
                            InputFeilds::printSelect("selectedForm", parent::param("selectedForm"), $valueNameArray);
                            ?>
                        </td><td>
                            <button id="configTable">Konfigurieren</button>
                        </td></tr><tr><td>
                            <b>Responsible role:</b>
                        </td><td colspan="2">
                            <?php
                            
                            $roles = Common::toMap(RolesModel::getCustomRoles(), "id", "name");
                            InputFeilds::printSelect("responsibleRole", parent::param("responsibleRole"), $roles);
                            ?>
                        </td></tr><tr><td>
                            <b>Mwst:</b>
                        </td><td colspan="2">
                            <?php
                            InputFeilds::printTextFeild("mwst",parent::param("mwst"),"expand");
                            ?>
                        </td></tr><tr><td>
                            <b>Email Subject:</b>
                        </td><td colspan="2">
                            <?php
                            InputFeilds::printTextFeild("emailSubject",parent::param("emailSubject"),"expand");
                            ?>
                        </td></tr>
                        </table>
                        <br/>
                        <b>Rechnungs Vorlage: </b>folgende werden ersetzt &lt;userinfo&gt; mit die benutzerdaten &lt;productinfo&gt; mit die bestellte produkten &lt;orderinfo&gt; mit dem bestellungs daten &lt;endsum&gt; mit die endsumme &lt;billinfo&gt; mit die rechnungs daten<br/>
                        <?php
                        InputFeilds::printHtmlEditor("billTemplate", parent::param("billTemplate"));
                        ?>
                        <br/>
                        <hr/>
                        <div class="alignRight">
                            <button id="saveButton">Speichern</button>
                        </div>
                    </form>
                    <script>
                    $('#configTable').button().click(function (event) {
                        callUrl("<?php echo NavigationModel::createStaticPageLink("configTables",array(),false); ?>",{"table":$("#orderForm").val()});
                        event.preventDefault();
                    })
                    $('#saveButton').button().click(function () {
                        $('#formForm').submit();
                    })
                    </script>
                </div>
                <?php
            }
            ?>
        </div>
        <?php
    }
    
    function getOrders ($status) {
        
        $orders = OrdersModel::getOrdersByStatus($status);
        $b_first = true;
        $ret = "[";
        if (!Common::isEmpty($orders)) {
            foreach ($orders as $order) {
                if (!$b_first)
                    $ret .= ",";
                $orderUser = UsersModel::getUser($order->userid);
                
                $ret .= "['".$order->id."'";
                $ret .= ",'".nl2br(Common::htmlEscape($orderUser->username))."'";
                $ret .= ",'".nl2br(Common::htmlEscape($orderUser->lastname))."'";
                $ret .= ",'".nl2br(Common::htmlEscape($orderUser->firstname))."'";
                $ret .= ",'".nl2br(Common::htmlEscape($this->getOrderPrice($order)))."'";
                $ret .= "]";
                $b_first = false;
            }
        }
        $ret .= "];".PHP_EOL;
        return $ret;
    }
    
    function getOrderPrice ($order) {
        $user = UsersModel::getUser($order->userid);
        $products = OrdersModel::getOrderProducts($order->id);
        $finalPrice = 0; $mwst = 0; $sum = 0; $rabatt = 0;
        foreach ($products as $product) {
            $productPrice = $product->price * $product->quantity;
            $sum += $productPrice;
        }
        $mwst = ($sum/100) * 19;
        $rabatt = -((($sum + $mwst) / 100) * $order->rabatt);
        $finalPrice = $sum + $mwst + $rabatt;
        return $finalPrice;
    }
}
?>