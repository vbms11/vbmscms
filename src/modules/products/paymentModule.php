<?php

require_once 'modules/products/ordersModel.php';

class PaymentModule extends XModule {

    // transfer type
    const type_creditcard   = 1;
    const type_transfer     = 2;
    const type_paypal       = 3;
    const type_debit        = 4;
    // mode
    const mode_test         = 1;
    const mode_live         = 2;
    // shipping
    const shipping_total = 1;
    const shipping_highest = 2;

    function onProcess () {
        
        switch (parent::getAction()) {
            case "update":
                if (Context::hasRole("payment.edit")) {
                    parent::param("time",           $_POST['time']);
                    parent::param("gallery",        $_POST['gallery']);
                    parent::param("animation",      $_POST['animation']);
                    parent::param("emailFrom",      $_POST['emailFrom']);
                    parent::param("paypalUrl",     $_POST['paypalUrl']);
                    parent::param("paypalAccount",  $_POST['paypalAccount']);
                    parent::param("emailSubject",   $_POST['emailSubject']);
                    parent::param("payments.debit.owner",       $_POST["payments_debit_owner"]);
                    parent::param("payments.debit.bankname",    $_POST["payments_debit_bankname"]);
                    parent::param("payments.debit.blz",         $_POST["payments_debit_blz"]);
                    parent::param("payments.debit.number",      $_POST["payments_debit_number"]);
                    parent::param("payments.edit.debit.email",      $_POST["payments_edit_debit_email"]);
                    parent::param("payments.edit.transfer.email",   $_POST["payments_edit_transfer_email"]);
                    parent::param("payments.edit.paypal.email",     $_POST["payments_edit_paypal_email"]);
                    parent::param("payments.edit.creditcard.email", $_POST["payments_edit_creditcard_email"]);
                    parent::blur();
                    parent::redirect();
                }
                break;
            case "edit":
                if (Context::hasRole("payment.edit")) {
                    parent::focus();
                }
                break;
            case "submit":
                $orderId = $_GET['id'];
                $order = OrdersModel::getOrder($orderId);
                $products = OrdersModel::getOrderProducts($orderId);
                $user = UsersModel::getUser($order->userid);
                $orderSent = false;
                $orderPayed = false;

                // order info email
                $emailText = "";
                // product list
                $ordersText = "<ul>";
                foreach ($products as $product) {
                    $quantity = Common::htmlEscape($product->quantity);
                    $productName = Common::htmlEscape($product->titel);
                    $ordersText .= "<li>$quantity x $productName</li>";
                }
                $ordersText .= "</ul>";
                // order details
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
                // order link
                $orderLink = "<a href='".NavigationModel::getSitePath().NavigationModel::createStaticPageLink("shopBasket", array("basket" => Context::getUserId()), false)."'>Click Here!</a>";
                // payment information
                switch ($_GET['type']) {
                    case self::type_creditcard:
                        // save info
                        OrdersModel::addOrderAttribute("payments.creditcard.owner",             $_POST["owner"],    $orderId);
                        OrdersModel::addOrderAttribute("payments.creditcard.validdate.month",   $_POST["month"],    $orderId);
                        OrdersModel::addOrderAttribute("payments.creditcard.validdate.year",    $_POST["year"],     $orderId);
                        OrdersModel::addOrderAttribute("payments.creditcard.type",              $_POST["type"],     $orderId);
                        OrdersModel::addOrderAttribute("payments.creditcard.number",            $_POST["number"],   $orderId);
                        // send email
                        $emailText = parent::param("payments.edit.creditcard.email");
                        $paymentDetails = PaymentModule::getCreditCardText();
                        $orderSent = true;
                        break;
                    case self::type_transfer:
                        // send email
                        $emailText = parent::param("payments.edit.transfer.email");
                        $paymentDetails = PaymentModule::getDebitText();
                        $orderSent = true;
                        break;
                    case self::type_paypal:
                        $req = 'cmd=_notify-validate';
                        foreach ($_POST as $key => $value) {
                            $value = urlencode($value);
                            $req .= "&$key=$value";
                        }
                        // post back to PayPal system to validate
                        $header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
                        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
                        $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
                        $fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);
                        if (!$fp) {
                            // HTTP ERROR
                        } else {
                            fputs ($fp, $header.$req);
                            while (!feof($fp)) {
                                $res = fgets ($fp, 1024);
                                if (strcmp ($res, "VERIFIED") == 0) {
                                    // PAYMENT VALIDATED & VERIFIED!
                                    $emailText = parent::param("payments.edit.paypal.email");
                                    $orderSent = true;
                                    $orderPayed = true;
                                } else if (strcmp ($res, "INVALID") == 0) {
                                    // PAYMENT INVALID & INVESTIGATE MANUALY!
                                }
                            }
                        }
                        fclose ($fp);
                        break;
                    case self::type_debit:
                        // save info
                        OrdersModel::addOrderAttribute("payments.debit.owner",      $_POST["owner"],     $orderId);
                        OrdersModel::addOrderAttribute("payments.debit.bankname",   $_POST["bankname"],  $orderId);
                        OrdersModel::addOrderAttribute("payments.debit.blz",        $_POST["blz"],       $orderId);
                        OrdersModel::addOrderAttribute("payments.debit.number",     $_POST["number"],    $orderId);
                        // send email
                        $emailText = parent::param("payments.edit.debit.email");
                        $detailsText = PaymentModule::getDebitText();
                        $orderSent = true;
                        break;
                }
                if ($orderSent) {
                    // replace placeholders
                    $emailText = str_replace("&lt;orderText&gt;", $ordersText, $emailText);
                    $emailText = str_replace("&lt;detailText&gt;", $detailsText, $emailText);
                    $emailText = str_replace("&lt;viewLink&gt;", $orderLink, $emailText);
                    $detailsText = str_replace("&lt;paymentDetails&gt;", $detailsText, $emailText);
                    // send the email
                    if (!empty($order->roleid)) {
                        // send to role group
                        $emails = UsersModel::getUsersEmailsByCustomRoleId($order->roleid);
                        foreach ($emails as $email) {
                            EmailUtil::sendHtmlEmail($email, parent::param("emailSubject"), $emailText, parent::param("emailSender"));
                        }
                        // send to customer
                        EmailUtil::sendHtmlEmail($user->email, parent::param("emailSubject"), $emailText, parent::param("emailFrom"));
                    }
                    // set order status
                    $status = 1;
                    if ($orderPayed) {
                        $status = 2;
                    }
                    // set the order status to waiting for confirm
                    OrdersModel::setOrderStatus($order->id, $status);
                    foreach ($products as $product) {
                        OrdersModel::setOrderProductStatus($product->id, $status);
                    }
                    // redirect back to the shopping basket
                    NavigationModel::redirectStaticModule("shopBasket",array("action"=>"orderSent"));
                }
                break;
            default:
        }
    }
    
    function onView () {

        switch (parent::getAction()) {
            case "edit":
                $this->renderEditView();
                break;
            default:
                $this->renderMainView();
        }
    }

    function getDebitText () {
        return "<table><tr>
        <td>".parent::getTranslation("payments.debit.owner")."</td><td>".parent::param("payments.debit.owner")."</td>
        </tr><tr>
        <td>".parent::getTranslation("payments.debit.bankname")."</td><td>".parent::param("payments.debit.bankname")."</td>
        </tr><tr>
        <td>".parent::getTranslation("payments.debit.blz")."</td><td>".parent::param("payments.debit.blz")."</td>
        </tr><tr>
        <td>".parent::getTranslation("payments.debit.number")."</td><td>".parent::param("payments.debit.number")."</td>
        </tr></table>";
    }

    function getCreditCardText () {
        return "<table><tr>
        <td>".parent::getTranslation("payments.creditcard.owner")."</td><td>".$_POST["owner"]."</td>
        </tr><tr>
        <td>".parent::getTranslation("payments.creditcard.validdate")."</td><td>".$_POST["month"]."/".$_POST["payments.creditcard.validdate.year"]."</td>
        </tr><tr>
        <td>".parent::getTranslation("payments.creditcard.type")."</td><td>".$_POST["type"]."</td>
        </tr><tr>
        <td>".parent::getTranslation("payments.creditcard.number")."</td><td>".$_POST["number"]."</td>
        </tr></table>";
    }
/*
    static function printPaymentTypeInfo ($orderId) {
        $order = OrdersModel::getOrder($orderId);
        echo "<table><tr><td><h2>".parent::getTranslation("payments.payment.method")."</h2></td><td>";
        switch ($order->paymethod) {
            case self::type_creditcard:
                echo parent::getTranslation("payments.payment.creditcard")."</td></tr></table>";

                break;
            case self::type_transfer:
                echo parent::getTranslation("payments.payment.transfer")."</td></tr></table>";
                break;
            case self::type_paypal:
                echo parent::getTranslation("payments.payment.paypall")."</td></tr></table>";
                break;
            case self::type_debit:
                echo parent::getTranslation("payments.payment.debit")."</td></tr></table>";
                break;
        }

    }
*/
    function getRoles () {
        return array("payment.edit");
    }

    function getScripts () {
        return array("js/payment.js");
    }

    function getStyles () {
        return array();
    }

    static function getTranslations () {
        return array(
            "en" => array(
                "payments.paypal.submit"        => "Continue to PayPal",
                "payments.submit"               => "Pay",
                "payments.paypal.account"       => "PayPal Uesr Account",
                "payments.paypal.mode"          => "Paypal Mode",
                "payments.paypal.mode.test"     => "Test",
                "payments.paypal.mode.live"     => "Production",
                "payments.payment.select"       => "Please select a payment method!",
                "payments.payment.method"       => "Payment Method",
                "payments.payment.paypall"      => "PayPal",
                "payments.payment.creditcard"   => "Credit Card",
                "payments.payment.transfer"     => "Credit Transfer",
                "payments.payment.debit"        => "Credit Debit",
                "payments.creditcard.owner"     => "Name of Owner",
                "payments.creditcard.validdate" => "Expire Date",
                "payments.creditcard.type"      => "Credit Institute",
                "payments.creditcard.number"    => "Card Number",
                "payments.creditcard.validdate.month"   => "Month",
                "payments.creditcard.validdate.year"    => "Year",
                "payments.debit.owner"          => "Name of Owner",
                "payments.debit.bankname"       => "Bank Name",
                "payments.debit.blz"            => "SWIFT / IBAN Code",
                "payments.debit.number"         => "Account Number",
                "payments.edit.debit.email"     => "Email sent to the user with the debit infomation %details% will be replaced with the account details that the user specified",
                "payments.edit.paypal.email"    => "Email sent to the user to inform them that the paypal transfer was successful",
                "payments.edit.transfer.email"  => "Email sent to the user with credit transfer infomation %details% will be replaced with the account details where the user has to pay",
                "payments.edit.creditcard.email"=> "Email sent to the user with the credit card infomation %details% will be replaced with the account details that the user specified"
            ),
            "de" => array(
                "payments.paypal.submit"        => "Weiter zu PayPal",
                "payments.submit"               => "Verbindlich bestellen",
                "payments.paypal.account"       => "PayPal Konto",
                "payments.paypal.mode"          => "PayPal Mode",
                "payments.paypal.mode.test"     => "Test",
                "payments.paypal.mode.live"     => "Production",
                "payments.payment.select"       => "Bitte wählen sie eine Zahlungsmethode!",
                "payments.payment.method"       => "Zahlungsmethode",
                "payments.payment.paypall"      => "PayPal",
                "payments.payment.creditcard"   => "Kreditkarte",
                "payments.payment.transfer"     => "Überweisung",
                "payments.payment.debit"        => "Lastschrift",
                "payments.creditcard.owner"     => "Kreditkarteninhaber",
                "payments.creditcard.validdate" => "Gültig bis",
                "payments.creditcard.type"      => "Kreditkarte Auswahl",
                "payments.creditcard.number"    => "Kreditkartenummer",
                "payments.creditcard.validdate.month"   => "Monat",
                "payments.creditcard.validdate.year"    => "Jahr",
                "payments.debit.owner"          => "Kontoinhaber",
                "payments.debit.bankname"       => "Bankname",
                "payments.debit.blz"            => "BLZ",
                "payments.debit.number"         => "Kontonummer",
                "payments.edit.debit.email"     => "Email sent to the user with the debit infomation %details% will be replaced with the account details that the user specified",
                "payments.edit.paypal.email"    => "Email sent to the user to inform them that the paypal transfer was successful",
                "payments.edit.transfer.email"  => "Email sent to the user with credit transfer infomation %details% will be replaced with the account details where the user has to pay",
                "payments.edit.creditcard.email"=> "Email sent to the user with the credit card infomation %details% will be replaced with the account details that the user specified"
             )
        );
    }

    function renderEditView () {
        $categorysMap = Common::toMap($categorys,"id","title");
        ?>
        <div class="panel slideshowPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"update")); ?>">
                <table class="expand">
                <tr>
                <td class="contract">
                    <b>Shipping Mode: </b>
                </td><td>
                    <?php
                    InputFeilds::printSelect("shippingMode", parent::param("shippingMode"), array(self::shipping_total=>"Total shipping",self::shipping_highest=>"Only Highest shipping"));
                    ?>
                </td>
                </tr>
                <tr>
                <td class="contract"><?php echo parent::getTranslation("payments.paypal.mode"); ?></td>
                <td><?php InputFeilds::printTextFeild("paypalUrl",parent::param("paypalUrl")); ?></td>
                </tr>
                <tr>
                <td class="contract"><?php echo parent::getTranslation("payments.paypal.account"); ?></td>
                <td><?php InputFeilds::printTextFeild("paypalAccount",parent::param("paypalAccount")); ?></td>
                </tr>
                <tr>
                <td class="contract"><?php echo parent::getTranslation("payments.debit.owner"); ?></td>
                <td><?php InputFeilds::printTextFeild("payments_debit_owner",parent::param("payments.debit.owner")); ?></td>
                </tr>
                <tr>
                <td class="contract"><?php echo parent::getTranslation("payments.debit.bankname"); ?></td>
                <td><?php InputFeilds::printTextFeild("payments_debit_bankname",parent::param("payments.debit.bankname")); ?></td>
                </tr>
                <tr>
                <td class="contract"><?php echo parent::getTranslation("payments.debit.blz"); ?></td>
                <td><?php InputFeilds::printTextFeild("payments_debit_blz",parent::param("payments.debit.blz")); ?></td>
                </tr>
                <tr>
                <td><?php echo parent::getTranslation("payments.debit.number"); ?></td>
                <td><?php InputFeilds::printTextFeild("payments_debit_number",parent::param("payments.debit.number")); ?></td>
                </tr>
                <tr><td colspan="2">
                    Here you can edit the order email. the following placeholders will be replaced. &lt;orderText&gt; will be replaced with a list of the ordered products, &lt;detailText&gt; is replaced with the details entered in the order form, &lt;viewLink&gt; is replaced with a link to view the order, &lt;paymentDetails&gt; is replaced with the payment method details.
                </td></tr>
                <tr><td colspan="2"><?php echo parent::getTranslation("payments.edit.debit.email"); ?></td></tr>
                <tr><td colspan="2"><?php InputFeilds::printHtmlEditor("payments_edit_debit_email",parent::param("payments.edit.debit.email")); ?></td></tr>
                <tr><td colspan="2"><?php echo parent::getTranslation("payments.edit.transfer.email"); ?></td></tr>
                <tr><td colspan="2"><?php InputFeilds::printHtmlEditor("payments_edit_transfer_email",parent::param("payments.edit.transfer.email")); ?></td></tr>
                <tr><td colspan="2"><?php echo parent::getTranslation("payments.edit.paypal.email"); ?></td></tr>
                <tr><td colspan="2"><?php InputFeilds::printHtmlEditor("payments_edit_paypal_email",parent::param("payments.edit.paypal.email")); ?></td></tr>
                <tr><td colspan="2"><?php echo parent::getTranslation("payments.edit.creditcard.email"); ?></td></tr>
                <tr><td colspan="2"><?php InputFeilds::printHtmlEditor("payments_edit_creditcard_email",parent::param("payments.edit.creditcard.email")); ?></td></tr>
                </table>
                <hr/>
                <div class="alignRight">
                    <button id="btnSave" type="submit">Save</button>
                </div>
            </form>
        </div>
        <script>
        $(".slideshowPanel button").button();
        </script>
        <?php
    }

    function renderMainView() {
        $orderId = $_GET['id'];
        $order = OrdersModel::getOrder($orderId);
        $products = OrdersModel::getOrderProducts($orderId);
        ?>
        <div class="panel paymentPanel">
            <div class="orderStepsPanel">
                <div class="orderStep"><?php echo parent::getTranslation("order.step.basket"); ?></div>
                <div class="orderStep"><?php echo parent::getTranslation("order.step.details"); ?></div>
                <div class="orderStep orderStepCurrent"><?php echo parent::getTranslation("order.step.payment"); ?></div>
                <div class="clear"></div>
            </div>
            <div class="paymentMethodSelection">
                <table><tr><td>
                <label for="paymentMethod"><?php echo parent::getTranslation("payments.payment.method"); ?></label>
                </td><td>
                <?php
                InputFeilds::printSelect("paymentMethod", $_GET['type'], array(
                    ""                      => "",
                    self::type_paypal       => parent::getTranslation("payments.payment.paypall",null,false),
                    self::type_creditcard   => parent::getTranslation("payments.payment.creditcard",null,false),
                    self::type_transfer     => parent::getTranslation("payments.payment.transfer",null,false),
                    self::type_debit        => parent::getTranslation("payments.payment.debit",null,false)),
                    null, "selectPaymentType();");
                ?>
                </td></tr></table>
            </div>
            <div class="paymentMethodForm">
                <?php
                switch (isset($_GET['type']) ? $_GET['type'] : "") {
                    case self::type_paypal:
                        $this->printPaypalView();
                        break;
                    case self::type_creditcard:
                        $this->printCreditCardView();
                        break;
                    case self::type_transfer:
                        $this->printCreditTransferView();
                        break;
                    case self::type_debit:
                        $this->printDebitView();
                        break;
                    default:
                        echo "<br/><p>".parent::getTranslation("payments.payment.select")."</p>";
                        break;
                }
                ?>
            </div>
            <div class="paymentBillPanel">
                <?php $this->printBillView(); ?>
            </div>
        </div>
        <script>
        function selectPaymentType () {
            callUrl("<?php echo parent::link(array("id"=>$_GET['id'])); ?>",{"type":$("#paymentMethod").val()});
        }
        </script>
        <?php
    }

    function printCreditCardView () {
        ?>
        <h1><?php echo parent::getTranslation("payments.payment.creditcard"); ?>:</h1>
        <form method="post" action="<?php echo parent::link(array("action"=>"submit","type"=>$_GET['type'],"id"=>$_GET['id'])); ?>">
            <table>
            <tr>
            <td><?php echo parent::getTranslation("payments.creditcard.type"); ?></td>
            <td colspan="2"><?php InputFeilds::printSelect("type", "", array(
                "VISA"=>"VISA","Mastercard"=>"Mastercard","American Express"=>"American Express","Dinar Club"=>"Dinar Club")); ?></td>
            </tr>
            <tr>
            <td><?php echo parent::getTranslation("payments.creditcard.owner"); ?></td>
            <td colspan="2"><?php InputFeilds::printTextFeild("owner"); ?></td>
            </tr>
            <tr>
            <td><?php echo parent::getTranslation("payments.creditcard.number"); ?></td>
            <td colspan="2"><?php InputFeilds::printTextFeild("number"); ?></td>
            </tr>
            <tr>
            <td><?php echo parent::getTranslation("payments.creditcard.validdate"); ?></td>
            <td><?php InputFeilds::printSelect("month","",Common::getSequence(1, 12, 1)); ?></td>
            <td><?php InputFeilds::printSelect("year","",Common::getSequence(2012, 2062, 1)); ?></td>
            </tr>
            </table>
            <hr/>
            <div class="alignRight">
                <button><?php echo parent::getTranslation("payments.submit") ?></button>
            </div>
        </form>
        <script>
        $(".paymentMethodForm .alignRight button").each(function (index,object) {
            $(object).button();
        });
        </script>
        <?php
    }

    function printPaypalView () {
        $returnUrl = "";
        $invoice = microtime();
        $orderId = $_GET['id'];
        // https://www.sandbox.paypal.com/cgi-bin/webscr
        ?>
        <h1><?php echo parent::getTranslation("payments.payment.paypall"); ?>:</h1>
        <form action="<?php echo parent::param("paypalUrl"); ?>" method="post" name="frmPaypal" id="frmPaypal">
            <input type="hidden" name="business" value="<?php echo parent::param("paypalAccount"); ?>">
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="return" value="<?php echo $returnUrl; ?>">
            <input type="hidden" name="cancel_return" value="<?php echo $returnUrl; ?>">
            <input type="hidden" name="notify_url" value="<?php echo $returnUrl; ?>">
            <input type="hidden" name="rm" value="2">
            <input type="hidden" name="currency_code" value="EUR">
            <input type="hidden" name="lc" value="DE">
            <input type="hidden" name="bn" value="toolkit-php">
            <input type="hidden" name="cbt" value="Continue >>">
            <input type="hidden" name="txn_id" value="">

            <!-- Payment Page Information -->
            <input type="hidden" name="no_shipping" value="1">
            <input type="hidden" name="no_note" value="0">
            <input type="hidden" name="cn" value="Comments">
            <input type="hidden" name="cs" value="">

            <!-- Product Information -->
            <input type="hidden" name="item_name" value="Order ID: <?php echo $orderId; ?>">
            <input type="hidden" name="amount" value="1">
            <input type="hidden" name="invoice" value="<?php echo $invoice; ?>">
            <input type="hidden" name="quantity" value="">
            <input type="hidden" name="item_number" value="<?php echo $orderId; ?>">
            <input type="hidden" name="undefined_quantity" value="">
            <input type="hidden" name="on0" value="">
            <input type="hidden" name="os0" value="">
            <input type="hidden" name="on1" value="">
            <input type="hidden" name="os1" value="">
            
            <button type="submit" id="btnPaypal"><?php echo parent::getTranslation("payments.paypal.submit") ?></button>
        </form>
        <script>
        $("#btnPaypal").button();
        </script>
        <?php
    }

    function printCreditTransferView () {
        ?>
        <h1><?php echo parent::getTranslation("payments.payment.transfer"); ?>:</h1>
        <form method="post" action="<?php echo parent::link(array("action"=>"submit","type"=>$_GET['type'],"id"=>$_GET['id'])); ?>">
            <table>
            <tr>
            <td><?php echo parent::getTranslation("payments.debit.owner"); ?></td>
            <td><?php echo parent::param("payments.debit.owner"); ?></td>
            </tr>
            <tr>
            <td><?php echo parent::getTranslation("payments.debit.bankname"); ?></td>
            <td><?php echo parent::param("payments.debit.bankname"); ?></td>
            </tr>
            <tr>
            <td><?php echo parent::getTranslation("payments.debit.blz"); ?></td>
            <td><?php echo parent::param("payments.debit.blz"); ?></td>
            </tr>
            <tr>
            <td><?php echo parent::getTranslation("payments.debit.number"); ?></td>
            <td><?php echo parent::param("payments.debit.number"); ?></td>
            </tr>
            </table>
            <hr/>
            <div class="alignRight">
                <button type="submit"><?php echo parent::getTranslation("payments.submit") ?></button>
            </div>
        </form>
        <script>
        $(".paymentMethodForm .alignRight button").each(function (index,object) {
            $(object).button();
        });
        </script>
        <?php
    }

    function printDebitView () {
        ?>
        <h1><?php echo parent::getTranslation("payments.payment.debit"); ?>:</h1>
        <form method="post" action="<?php echo parent::link(array("action"=>"submit","type"=>$_GET['type'],"id"=>$_GET['id'])); ?>">
            <table>
            <tr>
            <td><?php echo parent::getTranslation("payments.debit.owner"); ?></td>
            <td><?php InputFeilds::printTextFeild("owner"); ?></td>
            </tr>
            <tr>
            <td><?php echo parent::getTranslation("payments.debit.bankname"); ?></td>
            <td><?php InputFeilds::printTextFeild("bankname"); ?></td>
            </tr>
            <tr>
            <td><?php echo parent::getTranslation("payments.debit.blz"); ?></td>
            <td><?php InputFeilds::printTextFeild("blz"); ?></td>
            </tr>
            <tr>
            <td><?php echo parent::getTranslation("payments.debit.number"); ?></td>
            <td><?php InputFeilds::printTextFeild("number"); ?></td>
            </tr>
            </table>
            <hr/>
            <div class="alignRight">
                <button type="submit"><?php echo parent::getTranslation("payments.submit") ?></button>
            </div>
        </form>
        <script>
        $(".paymentMethodForm .alignRight button").each(function (index,object) {
            $(object).button();
        });
        </script>
        <?php
    }

    function printBillView () {
        $order = OrdersModel::getOrder($_GET['id']);
        ?>
        <table width="100%" class="shopBasketTable">
            <tr>
                <td class="contract"><b><?php echo parent::getTranslation("cart.quantity"); ?></b></td>
                <td style="width:20%"><b><?php echo parent::getTranslation("cart.products"); ?></b></td>
                <td style="width:20%"></td>
                <td style="width:20%"><b><?php echo parent::getTranslation("cart.price"); ?></b></td>
                <td style="width:20%"><b><?php echo parent::getTranslation("cart.shipping"); ?></b></td>
                <td style="width:20%"></td>
            </tr>
            <?php
            $priceTotal = 0;
            $shippingMax = 0;
            $shippingTotal = 0;
            foreach ($order as $product) {
                $priceTotal += $product->price * $product->quantity;
                $shippingTotal += $product->shipping * $product->quantity;
                if ($product->shipping > $shippingMax) {
                    $shippingMax = $product->shipping;
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
                    <td></td>
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
        </tr>
        </table>
        <?php
    }

}

?>