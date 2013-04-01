<?php
require_once 'core/plugin.php';
include_once 'modules/products/ordersModel.php';
include_once 'modules/products/productsPageModel.php';

class ShopBasketView extends XModule {

    const shipping_total = 1;
    const shipping_highest = 2;

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess() {
        
        switch (parent::getAction()) {

            case "update":
                if (Context::hasRole("shop.basket.edit")) {
                    parent::param("emailText",$_POST["emailText"]);
                    parent::param("emailSubject",$_POST["emailSubject"]);
                    parent::param("emailSender",$_POST["emailSender"]);
                    parent::param("submitMessage",$_POST["submitMessage"]);
                    parent::param("shippingMode",$_POST["shippingMode"]);
                    parent::redirect();
                }
                break;
            case "delete":
                if (Context::hasRole("shop.basket.details.edit")) {
                    OrdersModel::deleteOrderProduct($_GET['order'],$_GET['id']);
                    parent::redirect();
                }
                break;
            case "confirm":
                if (Context::hasRole("shop.basket.details.edit")) {
                    OrdersModel::setOrderStatus($_GET['id'], 2);
                }
                parent::redirect();
                break;
            case "cancel":
                if (Context::hasRole("shop.basket.details.edit")) {
                    OrdersModel::setOrderStatus($_GET['id'], 4);
                }
                parent::redirect();
                break;
            case "finnish":
                if (Context::hasRole("shop.basket.status.edit")) {
                    OrdersModel::setOrderStatus($_GET['id'], 3);
                    parent::redirect();
                }
                break;
            case "order":
                if (Context::hasRole("shop.basket.details.edit")) {
                    $table = VirtualDataModel::getTable(parent::param("orderForm"));
                    $orderForm = OrdersModel::getOrderAttribs($table->id, Context::getUserId());
                    if ($orderForm != null) {
                        parent::redirect(array("action" => "createOrder"));
                    }
                }
                break;
            case "createObject":
                if (Context::hasRole("shop.basket.details.edit")) {
                    $order = OrdersModel::getOrder($_GET['id']);
                    $table = VirtualDataModel::getTableById($order->orderform);
                    $objectId = DynamicDataView::createObject($table->name);
                    OrdersModel::setObjectId($_GET['id'], $objectId);
                    if (isset($_SESSION['basket.order.send'])) {
                        parent::redirect(array("action"=>"sendOrder","id"=>$_GET['id']));
                    } else {
                        parent::redirect();
                    }
                }
                break;
            case "editObject":
                if (Context::hasRole("shop.basket.details.edit")) {
                    $order = OrdersModel::getOrder($_GET['id']);
                    $table = VirtualDataModel::getTableById($order->orderform);
                    DynamicDataView::processAction($table->name, parent::link(), parent::link());
                    if (isset($_SESSION['basket.order.send'])) {
                        parent::redirect(array("action"=>"sendOrder","id"=>$_GET['id']));
                    } else {
                        parent::redirect();
                    }
                }
                break;
            case "saveQuantity":
                if (Context::hasRole("shop.basket.details.edit")) {
                    $products = OrdersModel::getOrderProducts($_GET['id']);
                    $quantitys = array();
                    foreach ($products as $product) {
                        if (isset($_POST['quantity_' . $product->productid])) {
                            $quantitys[$product->productid] = $_POST['quantity_' . $product->productid];
                        }
                    }
                    OrdersModel::updateQuantitys($_GET['id'], $quantitys);
                    parent::redirect();
                }
                break;
            case "sendOrder":
                if (Context::hasRole("shop.basket.details.edit")) {
                    $products = OrdersModel::getOrderProducts($_GET['id']);
                    $order = OrdersModel::getOrder($_GET['id']);

                    if (Common::isEmpty($order->objectid)) {
                        if (Context::isLoggedIn()) {
                            $_SESSION['basket.order.send'] = $_GET['id'];
                            parent::redirect(array("action"=>"editDetails","id"=>$_GET['id']));
                        } else {
                            NavigationModel::addStaticNextAction("shopBasket");
                            NavigationModel::redirectStaticModule("login");
                        }
                        break;
                    } else {
                        unset($_SESSION['basket.order.send']);

                        // send info mail
                        $emailText = parent::param("emailText");

                        $ordersText = "<ul>";
                        foreach ($products as $product) {
                            $quantity = Common::htmlEscape($product->quantity);
                            $productName = Common::htmlEscape($product->titel);
                            $ordersText .= "<li>$quantity x $productName</li>";
                        }
                        $ordersText .= "</ul>";

                        //
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

                        $orderLink = "<a href='".NavigationModel::getSitePath().NavigationModel::createStaticPageLink("shopBasket", array("basket" => Context::getUserId()), false)."'>Click Here!</a>";

                        $emailText = str_replace("&lt;orderText&gt;", $ordersText, $emailText);
                        $emailText = str_replace("&lt;detailText&gt;", $detailsText, $emailText);
                        $emailText = str_replace("&lt;viewLink&gt;", $orderLink, $emailText);

                        if ($order->distributorid == null) {
                            // send to role group
                            $emails = UsersModel::getUsersEmailsByCustomRoleId($order->roleid);
                            foreach ($emails as $email) {
                                EmailUtil::sendHtmlEmail($email, parent::param("emailSubject"), $emailText, parent::param("emailSender"));
                            }
                        } else {
                            // send to user
                            if (!empty($order->distributorid)) {
                                $email = UsersModel::getUserEmailById($order->distributorid);
                                EmailUtil::sendHtmlEmail($email, parent::param("emailSubject"), $emailText, parent::param("emailSender"));
                            } else {
                                echo "Error: Could not sent email to distributor.";
                            }
                        }
                        
                        // redirect user to pay
                        NavigationModel::redirectStaticModule("payment",array("id"=>$_GET['id']));
                    }
                }
                break;
            case "orderSent":
                break;
            case "editDetails":
                parent::focus();
                break;
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
                    break;
                case "editDetails":
                    if (Context::hasRole("shop.basket.details.edit")) {
                        $this->printEditOrderDetailsView($_GET['id']);
                    }
                    break;
                case "editQuantity":
                    if (Context::hasRole("shop.basket.details.edit")) {
                        $this->printEditOrderQuantityView($_GET['id']);
                    }
                    break;
                case "edit":
                    if (Context::hasRole("shop.basket.edit")) {
                        $this->printEditView(parent::getId());
                    }
                    break;
                case "orderSent":
                    $this->printOrderDone();
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

    static function getTranslations () {
        return array(
                "en" => array(
                    "cart.total"            => "Total: ",
                    "cart.price"            => "Price",
                    "cart.shipping"         => "Shipping",
                    "cart.quantity"         => "Quantity",
                    "cart.products"         => "Products",
                    "cart.tools"            => "Tools",
                    "cart.status"           => "Status",
                    "cart.status.edit"      => "Order is being edited",
                    "cart.status.confirm"   => "Waiting for confirmation",
                    "cart.status.done"      => "Order Confirmed",
                    "cart.status.decline"   => "Order declined",
                    "cart.delete"           => "Delete Order",
                    "cart.save"             => "Save changes",
                    "cart.cancel"           => "Cancel",
                    "cart.empty"            => "Your shopping basket is empty!",
                    "cart.finnished"        => "Thank you for your order, your order is being confirmed!",
                    "cart.send"             => "Send Order",
                    "cart.edit.quantity"    => "Change Quantities",
                    "cart.sent"             => "Thank you for your order, to view your orders status go to the shopping basket!",
                    "cart.delete.confirm"   => "Do you really want to delete this product from the order?"
                ),
                "de" => array(
                    "cart.total"            => "Total: ",
                    "cart.price"            => "Price",
                    "cart.shipping"         => "Versand",
                    "cart.quantity"         => "Menge",
                    "cart.products"         => "Products",
                    "cart.tools"            => "Tools",
                    "cart.status"           => "Status",
                    "cart.status.edit"      => "Bestellung wird bearbeitet",
                    "cart.status.confirm"   => "Warten auf Bestätigung",
                    "cart.status.done"      => "Bestellung bestätigt",
                    "cart.status.decline"   => "Bestellung abgelehnt",
                    "cart.delete"           => "Delete Order",
                    "cart.save"             => "Änderungen speichern",
                    "cart.cancel"           => "Abbrechen",
                    "cart.empty"            => "Der Warenkorb ist leer.",
                    "cart.finnished"        => "Vielen Dank für Ihre Bestellung. Ihre Bestellung wird bearbeitet!",
                    "cart.send"             => "Zur Kasse",
                    "cart.edit.quantity"    => "Menge bearbeiten",
                    "cart.sent"             => "Herzlichen Dank f&uuml;r Ihre Bestellung. Zur Kontrolle Ihrer Bestellung, bitte auf den Warenkorb klicken!",
                    "cart.delete.confirm"   => "Wollen Sie wirklich das Produkt vom Warenkorb entfernen?"
                )
            );
    }

    function printEditView ($moduleId) {
        ?>
        <div class="panel">
            <form method="post" action="<?php echo parent::link(array("action"=>"update")); ?>">
                <table width="100%" style="white-space: nowrap;" ><tr><td class="contract">
                    <b>Shipping Mode: </b>
                </td><td class="expand">
                    <?php
                    InputFeilds::printSelect("shippingMode", parent::param("shippingMode"), array(self::shipping_total=>"Total shipping",self::shipping_highest=>"Only Highest shipping"));
                    ?>
                </td></tr><tr><td class="contract">
                    <b>Email Subject: </b>
                </td><td class="expand">
                    <?php
                    InputFeilds::printTextFeild("emailSubject", parent::param("emailSubject"), "expand");
                    ?>
                </td></tr><tr><td class="contract">
                    <b>Email Sender: </b>
                </td><td class="expand">
                    <?php
                    InputFeilds::printTextFeild("emailSender", parent::param("emailSender"), "expand");
                    ?>
                </td></tr><tr><td colspan="2" style="white-space: normal;">
                    <br/>
                    <b><?php echo Common::htmlEscape('Here you can configure the text in the order email. "<orderText>" will be replaced with a description of the ordered products, "<detailText>" will be replaced with the content or the orderform, "<viewLink>" will be replaced with a link to the shopping basket view.'); ?></b>
                </td></tr><tr><td class="expand" colspan="2">
                    <?php
                    InputFeilds::printHtmlEditor("emailText", parent::param("emailText"));
                    ?>
                </td></tr><tr><td>
                    <b>Submit Message:</b>
                </td><td class="expand" colspan="2">
                    <?php
                    InputFeilds::printTextArea("submitMessage", parent::param("submitMessage"));
                    ?>
                </td></tr></table>
                <hr/>
                <div style="text-align:right;">
                    <button id="saveButton">Save</button>
                    <button id="cancelButton">Cancel</button>
                </div>
            </form>
            <script>
            $('#configTable').button().click(function (event) {
                callUrl("<?php echo NavigationModel::createStaticPageLink("configTables",array(),false); ?>",{"table":$("#orderForm").val()});
                event.preventDefault();
            })
            $('#saveButton').button().click(function (event) {
                $('#ordersConfigForm').submit();
            })
            $('#cancelButton').button().click(function (event) {
                callUrl('<?php echo parent::link(); ?>');
                event.preventDefault();
            })
            </script>
        </div>
        <?php
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
                            <td style="width:30%"><b><?php echo parent::getTranslation("cart.quantity"); ?></b></td>
                            <td style="width:40%"><b><?php echo parent::getTranslation("cart.products"); ?></b></td>
                            <td style="width:30%"><b><?php echo parent::getTranslation("cart.status"); ?></b></td>
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
                                        $status = parent::getTranslation("cart.status.edit");
                                        break;
                                    case "1":        // unconfirmed
                                        $img = "Clock.png";
                                        $status = parent::getTranslation("cart.status.confirm");
                                        break;
                                    case "2":        // confirmed
                                        $img = "Tick.png";
                                        $status = parent::getTranslation("cart.status.done");
                                        break;
                                    case "3":        // declined
                                        $img = "Block.png";
                                        $status = parent::getTranslation("cart.status.decline");
                                        break;
                                }
                                echo "<img src='resource/img/" . $img . "' alt='' titel='Delete Order' /> " . $status;
                                echo "</td></tr>";
                            }
                            ?>
                    </table>
                    <hr/>
                    <div style="text-align: right;">
                        <button id="btnSave"><?php echo parent::getTranslation("cart.save"); ?></button>
                        <button id="btnCancel"><?php echo parent::getTranslation("cart.cancel"); ?></button>
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
                    echo parent::getTranslation("cart.empty");
                }
                ?>
        </div>
        <?php
    }

    function printEditOrderDetailsView($orderId) {

        $order = OrdersModel::getOrder($orderId);
        ?>
        <div class="panel">
        <?php
        $table = VirtualDataModel::getTableById($order->orderform);
        if ($order->objectid == null) {
            ?>
            <form id="objectDetailsForm" method="post" action="<?php echo parent::link(array("action"=>"createObject", "id"=>$orderId)); ?>">
                <div style="text-align: right;">
                    <button class="btnSave"><?php echo parent::getTranslation("cart.send"); ?></button>
                    <button class="btnCancel"><?php echo parent::getTranslation("cart.cancel"); ?></button>
                </div>
                <?php
                DynamicDataView::renderCreateObject($table->name, parent::link(), parent::link(array("action" => "createObject", "id" => $orderId)));
                ?>
                <div style="text-align: right;">
                    <button class="btnSave"><?php echo parent::getTranslation("cart.send"); ?></button>
                    <button class="btnCancel"><?php echo parent::getTranslation("cart.cancel"); ?></button>
                </div>
            </form>
            <script>
            $(".btnSave").each(function(key,value){
                $(value).button().click(function(e){
                    if (validateForm(<?php echo DynamicDataView::renderValidateJs($table->name); ?>,'<?php echo parent::param("submitMessage")?>')) {
                        $("#objectDetailsForm").submit();
                    } else {
                        e.preventDefault();
                        return false;
                    }
                });
            });
            $(".btnCancel").each(function(key,value){
                $(value).button().click(function(){
                    callUrl("<?php echo parent::link(); ?>");
                });
            });
            </script>
            <?php
        } else {
            DynamicDataView::editObject($table->name, $order->objectid, "", $order->orderform, parent::link(array("action" => "editObject", "id" => $orderId)), parent::link(array("action" => "editObject", "id" => $orderId)));
        }
        ?>
        </div>
        <?php
    }
    
    function printOrderDone() {
        ?>
        <div id="dialog-message" title="Vielen Dank">
            <p>
                <span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
                <?php echo parent::getTranslation("cart.finnished"); ?>
            </p>
        </div>
        <script>
        $("#dialog-message").dialog({
            modal: true, buttons: {
                Ok: function() {
                    $( this ).dialog( "close" );
                    // callUrl("<?php echo NavigationModel::createStaticPageLink("shopBasket"); ?>");
                }
            }
        });
        $("#dialog-message").show();
        </script>
        <?php
    }

    function printMainView($userId) {
        $orders = OrdersModel::getOrdersByUser($userId);
        ?>
        <div class="panel">
            <?php
            if (!Common::isEmpty($orders)) {
                $orderGroups = array();
                foreach ($orders as $order) {
                    $name;
                    if (!empty($order->distributorid) && ($order->distributorid != null)) {
                        $distributor = UsersModel::getUser($order->distributorid);
                        $name = $distributor->username;
                    } else {
                        $role = RolesModel::getCustomRoleById($order->roleid);
                        $name = $role->name;
                    }
                    if (!isset($orderGroups[$name])) {
                        $orderGroups[$name] = array();
                    }
                    if (!isset($orderGroups[$name][$order->orderstatus])) {
                        $orderGroups[$name][$order->orderstatus] = array();
                    }
                    if (!isset($orderGroups[$name][$order->orderstatus][$order->orderid])) {
                        $orderGroups[$name][$order->orderstatus][$order->orderid] = array();
                    }
                    $orderGroups[$name][$order->orderstatus][$order->orderid][] = $order;
                    $orderIds[$name] = $order->orderid;
                }
                ?>
                <div id="shopBasketAccordion">
                    <?php
                    foreach ($orderGroups as $key => $value) {

                        $statusCode = 0;
                        ?>
                        <h3><a href="#"><?php /* echo Common::htmlEscape($key); */ ?></a></h3>
                        <div>
                            <?php
                            
                            $valueKeys = array_keys($value);
                            $valueKeysLen = count($valueKeys);
                            for ($i=0; $i<4; $i++) {
                                if (!isset($value[$i])) {
                                    continue;
                                }
                                $status = $i;
                                $orders = $value[$i];
                                switch ($status) {
                                    case "0":        // unconfirmed
                                        $img = "Pencil.png";
                                        $statusDesc = parent::getTranslation("cart.status.edit");
                                        break;
                                    case "1":        // unconfirmed
                                        $img = "Clock.png";
                                        $statusDesc = parent::getTranslation("cart.status.confirm");
                                        break;
                                    case "2":        // confirmed
                                        $img = "Tick.png";
                                        $statusDesc = parent::getTranslation("cart.status.done");
                                        break;
                                    case "3":        // declined
                                        $img = "Present.png";
                                        $statusDesc = parent::getTranslation("cart.status.decline");
                                        break;
                                }
                                echo "<h3>$statusDesc</h3>".PHP_EOL;
                                ?>
                                <table width="100%"><tr><td class="expand">
                                    <?php
                                    
                                    foreach ($orders as $orderId => $order) {
                                        ?>
                                        <table width="100%" class="shopBasketTable">
                                        <tr>
                                            <td class="contract"><b><?php echo parent::getTranslation("cart.quantity"); ?></b></td>
                                            <td style="width:20%"><b><?php echo parent::getTranslation("cart.products"); ?></b></td>
                                            <td style="width:20%"></td>
                                            <td style="width:20%"><b><?php echo parent::getTranslation("cart.price"); ?></b></td>
                                            <td style="width:20%"><b><?php echo parent::getTranslation("cart.shipping"); ?></b></td>
                                            <td style="width:20%"><b><?php echo parent::getTranslation("cart.status"); ?></b></td>
                                            <?php
                                            if ($status == "0") {
                                                ?>
                                                <td class="contract"><b><?php echo parent::getTranslation("cart.tools"); ?></b></td>
                                                <?php
                                            }
                                            ?>
                                        </tr>
                                        <?php
                                        $priceTotal = 0;
                                        $shippingMax = 0;
                                        $shippingTotal = 0;
                                        foreach ($order as $product) {
                                            //
                                            $priceTotal += $product->price * $product->quantity;
                                            $shippingTotal += $product->shipping * $product->quantity;
                                            if ($product->shipping > $shippingMax) {
                                                $shippingMax = $product->shipping;
                                            }
                                            //
                                            $img = "";
                                            $statusText = "";
                                            switch ($product->status) {
                                                case "0":        // unconfirmed
                                                    $img = "edit.png";
                                                    $statusText = parent::getTranslation("cart.status.edit");
                                                    break;
                                                case "1":        // unconfirmed
                                                    $img = "Clock.png";
                                                    $statusText = parent::getTranslation("cart.status.confirm");
                                                    break;
                                                case "2":        // confirmed
                                                    $img = "Tick.png";
                                                    $statusText = parent::getTranslation("cart.status.done");
                                                    break;
                                                case "3":        // declined
                                                    $img = "Block.png";
                                                    $statusText = parent::getTranslation("cart.status.decline");
                                                    break;
                                            }
                                            ?>
                                            <tr>
                                                <td class='nowrap' style='text-align:right;'><b><?php echo $product->quantity; ?> x </b></td>
                                                <td><?php echo $product->titel; ?></td>
                                                <td><img class="cartProductImage" src="<?php echo ResourcesModel::createResourceLink("products", $product->img); ?>" alt=""/></td>
                                                <td><?php echo number_format($product->price * $product->quantity, 2).Config::getCurrency(); ?></td>
                                                <td>
                                                <?php
                                                    if (parent::param("shippingMode") == self::shipping_total) {
                                                        echo number_format($product->shipping * $product->quantity, 2) .Config::getCurrency();
                                                    }
                                                ?>
                                                </td>
                                                <td class='nowrap'><img src="resource/img/<?php echo $img; ?>" alt="" titel="<?php echo $statusText; ?>" /><?php echo $statusText; ?></td>
                                                <?php
                                                if ($status == "0") {
                                                    ?>
                                                    <td><img src="resource/img/delete.png" onclick="doIfConfirm('<?php echo parent::getTranslation("cart.delete.confirm"); ?>','<?php echo parent::link(array("action" => "delete", "id" => $product->id, "order" => $orderId)); ?>');" alt='' titel='<?php echo parent::getTranslation("cart.delete"); ?>' /></td>
                                                    <?php
                                                }
                                                ?>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td><b><?php echo parent::param("cart.total"); ?></b></td>
                                            <td><b><?php echo $priceTotal.Config::getCurrency(); ?></b></td>
                                            <td><b>
                                            <?php
                                                if (parent::param("shippingMode") == self::shipping_highest) {
                                                    $shippingTotal = $shippingMax;
                                                }
                                                echo number_format($shippingTotal, 2).Config::getCurrency();
                                            ?>
                                            </b></td>
                                            <td><b><?php echo number_format($shippingTotal + $priceTotal, 2).Config::getCurrency(); ?></b></td>
                                            <td></td>
                                        </tr>
                                        </table>
                                        <hr/>
                                        <div style="text-align: right;">
                                            <?php
                                            if ($status == "0") {
                                                ?>
                                                <button class="btnSendOrder_<?php echo $orderId; ?>"><?php echo parent::getTranslation("cart.send"); ?></button>
                                                <button class="btnEditQuantity_<?php echo $orderId; ?>"><?php echo parent::getTranslation("cart.edit.quantity"); ?></button>
                                                <script>
                                                $(".btnSendOrder_<?php echo $orderId; ?>").button().click(function () {
                                                    callUrl("<?php echo parent::link(array("action" => "sendOrder", "id" => $orderId),false); ?>");
                                                });
                                                $(".btnEditQuantity_<?php echo $orderId; ?>").button().click(function () {
                                                    callUrl("<?php echo parent::link(array("action" => "editQuantity", "id" => $orderId),false); ?>");
                                                });
                                                </script>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </td></tr></table>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    if (parent::getAction() == "sendOrder") {
                        ?>
                        <div id="orderSentModal" title="Order Sent">
                            <p><?php echo parent::getTranslation("cart.sent"); ?></p>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <script>
                $("#shopBasketAccordion").accordion({
                    autoHeight: false,
                    navigation: true
                });
                <?php
                if (parent::getAction() == "sendOrder") {
                    ?>
                    $("#orderSentModal").dialog({
                        modal: true,
                        buttons: {
                            Ok: function() {
                                $(this).dialog("close");
                            }
                        }
                    });
                    <?php
                }
                ?>
                </script>
                <?php
            } else {
                echo parent::getTranslation("cart.empty");
            }
            ?>
        </div>
        <?php
    }

    function printOrderForm($moduleId) {
        ?>
        <div class="panel">
            <form method="post" action="<?php echo parent::link(array("action" => "createOrder")); ?>">

                <?php
                if (parent::param("choseUser")) {
                    $valueNameArray = array();
                    $users = UsersModel::getUsersByCustomRoleId(parent::param("roleGroup"));
                    if ($users != null) {
                        foreach ($users as $user) {
                            $valueNameArray[$user->id] = $user->username;
                        }
                    }
                    echo "Distributor ";
                    InputFeilds::printSelect("distributor", null, $valueNameArray);
                    echo "<hr/>";
                }
                DynamicDataView::renderCreateObject(parent::param("orderForm"), parent::link(), parent::link());
                ?>
                <hr/>
                <input type="submit" value="Absenden"/>
            </form>
        </div>
        <?php
    }

}
?>
