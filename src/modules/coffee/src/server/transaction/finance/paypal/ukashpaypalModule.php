<?php

require_once 'core/plugin.php';
include_once 'modules/ukashpaypal/ukashpaypalModel.php';

class UkashPaypalModule extends XModule {

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {
            
        switch (parent::getAction()) {
            case "update":
                parent::param("paypalUrl", $_POST['paypalUrl']);
                parent::param("paypalAccount", $_POST['paypalAccount']);
                break;
            case "edit":
                parent::focus();
                break;
            case "cancel":
                parent::blur();
                break;
            case "pay":
                $valid = true;
                $email = "";
                $currency = "";
                if (isset($_POST["email"])) {
                    $email = $_POST["email"];
                } else {
                    $valid = false;
                }
                if (isset($_POST["currency"])) {
                    $currency = $_POST["currency"];
                }
                if (isset($_POST["amount"])) {
                    $amount = intval($_POST["amount"]);
                }
                if (!in_array($amount, array(10,20,50,100))) {
                    $valid = false;
                }
                if ($valid) {
                    $_SESSION["ukash.email"] = $email;
                    $_SESSION["ukash.amount"] = $amount;
                    $_SESSION["ukash.currency"] = $currency;
                } else {
                    parent::redirect();
                }
                break;
            case "payed":

                $verified = false;

                $req = 'cmd=_notify-validate';
                foreach ($_POST as $key => $value) {
                    $value = urlencode($value);
                    $req .= "&$key=$value";
                }
                // post back to PayPal system to validate
                $header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
                $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
                $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
                $errno = "";
                $errstr = "";
                $fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);

                if (!$fp) {
                    // HTTP ERROR
                } else {
                    fputs ($fp, $header.$req);
                    while (!feof($fp)) {
                        $res = fgets ($fp, 1024);
                        if (strcmp ($res, "VERIFIED") == 0) {
                            // PAYMENT VALIDATED & VERIFIED!
                            $verified = true;
                        } else if (strcmp ($res, "INVALID") == 0) {
                            $verified = false;
                        }
                    }
                }
                fclose ($fp);
                $_SESSION["ukash.verified"] = $verified;

                if ($verified) {
                    UkashPaypalModel::sendUkashEmail();
                }

                break;

        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {
        
        switch (parent::getAction()) {
            case "edit":
                if (Context::hasRole("ukash.edit")) {
                    $this->printEditView();
                }
                break;
            case "payed":
                $this->printPayedView();
                break;
            case "pay":
                $this->printPayView();
                break;
            default:
                $this->printMainView();
        }
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("ukash.edit");
    }

    function printMainView () {

        ?>
        <div class="panel ukashPanel">
            
            <h1><?php echo parent::getTranslation("ukash.buy.title"); ?></h1>
            <p><?php echo parent::getTranslation("ukash.buy.description"); ?></p>
            <form method="post" action="<?php echo parent::link(array("action"=>"pay")); ?>">
                <table class="formTable"><tr><td>
                    <?php echo parent::getTranslation("ukash.buy.label.email"); ?>
                </td><td>
                    <?php InputFeilds::printTextFeild("email"); ?>
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("ukash.buy.label.amount"); ?>
                </td><td>
                    <select id="ukashAmount" name="amount">
                        <option>10</option>
                        <option>20</option>
                        <option>50</option>
                        <option>100</option>
                    </select>
                </td></tr><tr><td>
                    <?php echo parent::getTranslation("ukash.buy.label.cost"); ?>
                </td><td>
                    <div id="ukashCost"></div>
                </td></tr></table>
                <hr/>
                <div class="alignRight">
                    <button class="jquiButton" type="submit"><?php echo parent::getTranslation("ukash.buy.button.pay"); ?></button>
                </div>
            </form>
        </div>
        <script>
        function changeAmountUpdateCost () {
            var amount = $("#ukashAmount").val();
            var cost = amount * 1.25;
            $("#ukashCost").html(cost+" &euro;");
        }
        $("#ukashAmount").change(function(){
            changeAmountUpdateCost();
        });
        changeAmountUpdateCost();
        </script>
        <?php
    }
    
    function printPayView () {
        
        $returnUrl = "http://".$_SERVER['HTTP_HOST']."/".parent::ajaxLink(array("action"=>"pay"));
        $paypalAccount = parent::param("paypalAccount");
        $invoice = microtime();
        $moneyAmount = $_SESSION["ukash.amount"];
        
        ?>
        <div class="ukashPanel">
            
            <h1><?php echo parent::getTranslation("ukash.pay.title"); ?></h1>
            <p><?php echo parent::getTranslation("ukash.pay.message"); ?></p>
            <form action="<?php echo parent::param("paypalUrl"); ?>" method="post" name="frmPaypal" id="frmPaypal">

                <input type="hidden" name="business" value="<?php echo $paypalAccount; ?>">
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
                <input type="hidden" name="item_name" value="Order ID: <?php echo $invoice; ?>">
                <input type="hidden" name="amount" value="<?php echo $moneyAmount; ?>">
                <input type="hidden" name="invoice" value="<?php echo $invoice; ?>">
                <input type="hidden" name="quantity" value="">
                <input type="hidden" name="item_number" value="<?php echo $invoice; ?>">
                <input type="hidden" name="undefined_quantity" value="">
                <input type="hidden" name="on0" value="">
                <input type="hidden" name="os0" value="">
                <input type="hidden" name="on1" value="">
                <input type="hidden" name="os1" value="">
                
                <hr/>
                <div class="alignRight">
                    <button class="jquiButton" type="submit"><?php echo parent::getTranslation("ukash.pay.button.submit"); ?></button>
                </div>
            </form>
        </div>
        <?php
    }
    
    function printPayedView () {
        ?>
        <div class="ukashPanel">
            <?php
            if ($_SESSION["ukash.verified"]) {
                ?>
                <h1><?php echo parent::getTranslation("ukash.payed.success.title"); ?></h1>
                <p><?php echo parent::getTranslation("ukash.payed.success.message"); ?></p>
                <?php
            } else {
                ?>
                <h1><?php echo parent::getTranslation("ukash.payed.fail.title"); ?></h1>
                <p><?php echo parent::getTranslation("ukash.payed.fail.message"); ?></p>
                <?php
            }
            ?>
            <hr/>
            <div class="alignRight">
                <button id="ukashBuyMoreButton" class="jquiButton"><?php echo parent::getTranslation("ukash.payed.button"); ?></button>
            </div>
        </div>
        <script>
        $("#ukashBuyMoreButton").click(function () {
            callUrl("<?php echo parent::link(); ?>");
        });
        </script>
        <?php
    }
    
    function printEditView () {
        ?>
        <div class="ukashPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"update")); ?>">
                <table class="formTable"><tr>
                <td><?php echo parent::getTranslation("ukash.paypal.url"); ?></td>
                <td><?php InputFeilds::printTextFeild("paypalUrl",parent::param("paypalUrl")); ?></td>
                </tr><tr>
                <td><?php echo parent::getTranslation("ukash.paypal.account"); ?></td>
                <td><?php InputFeilds::printTextFeild("paypalAccount",parent::param("paypalAccount")); ?></td>
                </tr></table>
                <hr/>
                <div class="alignRight">
                    <button type="submit" class="jquiButton"><?php echo parent::getTranslation("common.save"); ?></button>
                </div>
            </form>
        </div>
        <?php
    }
}

?>