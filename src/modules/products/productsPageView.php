<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'core/plugin.php';
require_once 'modules/products/ordersModel.php';
require_once 'modules/products/productsPageModel.php';

class ProductsPageView extends XModule {

    public $action;
    public $productId;
    public $productsPageModel;
    public $wysiwygPageModel;
    public $articleContent;
    public $oldproductimage;
    public $productpage;
    public $productpagevisible;

    const displayModeList = 1;
    const displayModeGrid = 2;

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {

        $this->getRequestVars();
        
        switch (parent::getAction()) {

            case "update":
                parent::redirect();
                break;
            case "save":
                if (Context::hasRole("products.edit")) {
                    parent::param("orderForm",$_POST['orderForm']);
                    parent::param("roleGroup",$_POST['roleGroup']);
                    parent::param("displayMode",$_POST['displayMode']);
                    parent::param("productGroup",$_POST['productGroup']);
                    ProductsPageModel::setModuleProductGroup(parent::getId(), $_POST['productGroup']);
                }
                parent::redirect();
                break;
            case "edit":
                if (Context::hasRole("products.edit")) {
                    DynamicDataView::processAction(parent::param("orderForm"), parent::link(), parent::link(array("action"=>"edit"),false));
                }
                parent::focus();
                break;
            case "addToKart":
                // set products in session 
                $products = ProductsPageModel::getProducts(parent::param("productGroup"),Context::getLang());
                $_SESSION['products.orders'] = array();
                foreach ($products as $product) {
                    if (isset($_POST['quantity_'.$product->id])) {
                        $quantity = $_POST['quantity_'.$product->id];
                        if ($quantity > 0) {
                            $order;
                            $order->productid = $product->id;
                            $order->quantity = $quantity;
                            $order->price = $product->price;
                            $order->shipping = $product->shipping;
                            $order->img = $product->img;
                            $order->name = $product->titel;
                            $_SESSION['products.orders'][$order->productid] = $order;
                            unset($order);
                        }
                    }
                }
                if (!Common::isEmpty(parent::param("orderForm"))) {
                    $orderId = OrdersModel::createOrder(Context::getUserId(),$_SESSION['products.orders']
                        ,parent::param("orderForm"),parent::param("roleGroup"));
                }
                break;
            case "viewProduct":
                parent::focus();
                break;
            case "cancel":
                parent::blur();
                break;
            default:
                break;
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {
        
        switch (parent::getAction()) {
            case "edit":
                $this->printEditView(parent::getId());
                break;
            case "addToKart":
                $this->printMainView(parent::param("productGroup"),true);
                break;
            case "viewProduct":
                $this->printProductPage();
                break;
            default:
                $this->printMainView(parent::param("productGroup"));
        }
    }

    /**
     * returns style sheets used by this module
     */
    function getStyles () {
        return array('css/products.css');
    }

    /**
     * returns scripts used by this module
     */
    function getScripts () {

    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("products.edit","products.view");
    }

    /**
     * returns search results for given text
     */
    function search ($searchText, $lang) {
        return ProductsPageModel::search($searchText,Context::getLang());
    }
    
    function getRequestVars () {
        if (isset($_GET['action'])) $this->action = $_GET['action'];
        if (isset($_GET['productid'])) $this->productId = $_GET['productid'];
        if (isset($_POST['articleContent'])) $this->articleContent = $_POST['articleContent'];
        if (isset($_POST['articleName'])) $this->articleName = $_POST['articleName'];
        if (isset($_POST['oldproductimage'])) $this->oldProductImage = $_POST['oldproductimage'];
        if (isset($_POST['productpage'])) $this->productpage = $_POST['productpage'];
        if (isset($_POST['productpagevisible'])) $this->productpagevisible = $_POST['productpagevisible'];
    }

    
    function printMainView ($groupId,$orderDone=false) {

        switch (parent::param("displayMode")) {

            case self::displayModeList:
                $this->printProductList($groupId,$orderDone);
                break;
            case self::displayModeGrid:
                $this->printProductGrid($groupId,$orderDone);
                break;
            default:
                break;
        }
    }

    static function getTranslations () {
        return array(
            "en" => array(
                "order.button.cart"         => "To Cart",
                "order.button.continue"     => "Continue Shopping",
                "order.status.title"        => "Status",
                "products.order"            => "Order",
                "products.quantity"         => "Quantity",
                "products.shipping"         => "Shipping",
                "products.weight"           => "Weight",
                "products.addToCart"        => "Add To Cart",
                "products.cancel"           => "Back To Category",
                "products.dialog.minimum"   => "Please consider the minimum order amount!",
                "products.dialog.ordered"   => "Thank you for your order. You still have to confirm the order in the shopping cart!"
            ), "de" => array(
                "order.button.cart"         => "Zum Warenkorb",
                "order.button.continue"     => "Weiter einkaufen",
                "order.status.title"        => "Status",
                "products.order"            => "Bestellen",
                "products.quantity"         => "Menge",
                "products.shipping"         => "Versand",
                "products.weight"           => "Gewicht",
                "products.addToCart"        => "In den Warenkorb",
                "products.cancel"           => "Zurück zur Kategorie",
                "products.dialog.minimum"   => "Bitte beachten sie die Mindestabnahme!",
                "products.dialog.ordered"   => "Danke Ihre Bestellung wurde im Warenkorb abgelegt. Sie müssen noch die Bestellung im Warenkorb bestätigen!"
            )
        );
    }

    function printProductList ($groupId,$orderDone=false) {
        $products = ProductsPageModel::getProducts($groupId,Context::getLang());
        $group = ProductsPageModel::getGroup($groupId);
        ?>
        <div class="panel">
            <div class="productsGroupTitle">
                <h1><?php echo $group->name; ?></h1>
            </div>
            <form id="productsForm" onsubmit="" action="<?php echo parent::link(array("action"=>"addToKart")); ?>" method="post">

                <table class="expand"><tr><td colspan="2"><hr/></td></tr>
                <?php
                for ($i=0; $i<count($products); $i++) {
                    ?>

                    <tr><td valign="top" align="left">
                        <a href="<?php echo parent::link(array("action"=>"viewProduct","id"=>$products[$i]->id)) ?>"><img class="productsImage imageLink" src="<?php echo Resource::createResourceLink("products", $products[$i]->img); ?>" alt=""/></a>
                    </td><td valign="top">
                        <div class="productTitel">
                            <?php
                            if (Context::hasRole("products.edit")) {
                                ?>
                                <a href="<?php echo parent::link(array("action"=>"editproduct","productid"=>$products[$i]->id)); ?>"><img src="resource/img/edit.png" class="imageLink" alt="edit the product" title="edit the product" /></a>
                                <a href="<?php echo parent::link(array("action"=>"moveup","productid"=>$products[$i]->id)); ?>"><img src="resource/img/moveup.png" class="imageLink" alt="move the product up" title="move the product up" /></a>
                                <a href="<?php echo parent::link(array("action"=>"movedown","productid"=>$products[$i]->id)); ?>"><img src="resource/img/movedown.png" class="imageLink" alt="move the product down" title="move the product down" /></a>
                                <img src="resource/img/delete.png" class="imageLink" alt="delete the product" title="delete the product" onclick="doIfConfirm('Wollen Sie wirklich den Artikel l&ouml;schen?','<?php echo parent::link(array("action"=>"deleteproduct","productid"=>$products[$i]->id),false); ?>')" />
                                <?php
                            }
                            echo Common::htmlEscape($products[$i]->titel);
                            ?>
                        </div>
                        <div class="productText">
                            <?php
                            echo $products[$i]->text;
                            ?>
                        </div>
                        <div class="productOrder">
                            <?php if ($products[$i]->quantity != 0) { echo Common::htmlEscape("Lagerbestand: ".$products[$i]->quantity." | "); } ?>
                            <?php if ($products[$i]->minimum != 0) { echo Common::htmlEscape("Mindestabnahme: ".$products[$i]->minimum." Stk. | "); } ?>
                            Bestellmenge: <?php InputFeilds::printTextFeild("quantity_".Common::htmlEscape($products[$i]->id), ""); ?>
                            <input type="hidden" id="<?php echo "quantity_".Common::htmlEscape($products[$i]->id)."_min"; ?>" value="<?php echo Common::htmlEscape($products[$i]->minimum); ?>">
                        </div>
                    </td></tr>
                    <tr><td colspan="2"><hr/></td></tr>
                    <?php
                }
                ?>
                </table>
                <div style="text-align: right;">
                    <button class="submit_order" type="submit" ><?php echo parent::getTranslation("products.order"); ?></button>
                </div>
            </form>
        </div>
        <?php
        if ($orderDone == true) {
            ?>
            <div id="orderDoneDialog" title="Order Successfull">
                <p class="validateTips"><?php echo parent::getTranslation("products.dialog.ordered"); ?></p>
            </div>
            <script>
            $("#orderDoneDialog").dialog({
                autoOpen: false, modal: true,
                height: 250, width: 350,
                show: "fade", hide: "explode",
                buttons: {
                    "Weiter in der Bestellung": function() {
                        $("#orderDoneDialog").dialog("close");
                        callUrl("<?php echo parent::link(); ?>");
                    },
                    "Zum Warenkorb": function() {
                        $("#orderDoneDialog").dialog("close");
                        callUrl("<?php echo NavigationModel::createStaticPageLink("shopBasket"); ?>");
                    }
                }
            });
            $("#orderDoneDialog").dialog("open");
            </script>
            <?php
        }
        ?>
        <div id="checkValidDialog" title="Please Check Your input">
            <p class="validateTips"><?php echo parent::getTranslation("products.dialog.minimum"); ?></p>
        </div>

        <script>
        $("#checkValidDialog").dialog({
            autoOpen: false, modal: true,
            height: 250, width: 350,
            show: "fade", hide: "explode",
            buttons: {
            "ok": function() {
                $("#checkValidDialog").dialog("close");
            }
        }});
        $(".submit_order").click(function(event) {
            var invalid = false;
            var cntOrderedProducts = 0;
            $(".productOrder input").each(function (index,object) {
                if (object.getAttribute("id").indexOf("_min") > 0) {
                } else {
                    var val = parseInt($("#"+object.getAttribute("id")).val());
                    if (val != "" && val > 0) {
                        var min = parseInt($("#"+object.getAttribute("id")+"_min").val());
                        if (min > 0 && val < min) {
                            invalid = true;
                        } else {
                            if (val > 0) {
                                cntOrderedProducts++;
                            }
                        }
                    }
                }
            });
            if (invalid || cntOrderedProducts < 1) {
                $("#checkValidDialog").dialog("open");
                event.preventDefault();
                return false;
            }
            invalid = false;
            cntOrderedProducts = 0
            return true;
        });
        </script>
        <?php
    }

    function printProductGrid ($groupId, $orderDone = false) {
        $products = ProductsPageModel::getProducts($groupId,Context::getLang());
        $group = ProductsPageModel::getGroup($groupId);
        ?>
        <div class="panel">
            <?php
            if (!empty($group)) {
                ?>
                <div class="productsGroupTitle shadow">
                    <h1><?php echo $group->name; ?></h1>
                </div>
                <div>
                    <?php
                    for ($i=0; $i<count($products); $i++) {
                        ?>
                        <div class="productsGridTile shadow">
                            <div class="productsGridImage">
                                <a href="<?php echo parent::link(array("action"=>"viewProduct","id"=>$products[$i]->id)) ?>"><img class="productsImage imageLink" width="228" height="228" src="<?php echo Resource::createResourceLink("products", $products[$i]->img); ?>" alt=""/></a>
                            </div>
                            <div class="productsGridTitle">
                                <?php
                                echo Common::htmlEscape($products[$i]->titel);
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <?php
            }
            ?>
            <hr class="hrClear">
        </div>
        <?php
        if ($orderDone == true) {
            ?>
            <div id="orderDoneDialog" title="<?php echo parent::getTranslation("order.status.title"); ?>">
                <p class="validateTips"><?php echo parent::getTranslation("products.dialog.ordered"); ?></p>
            </div>
            <script>
            $("#orderDoneDialog").dialog({
                autoOpen: false, modal: true,
                height: 250, width: 350,
                show: "fade", hide: "explode",
                buttons: {
                    "<?php echo parent::getTranslation("order.button.continue"); ?>": function() {
                        $("#orderDoneDialog").dialog("close");
                        callUrl("<?php echo parent::link(); ?>");
                    },
                    "<?php echo parent::getTranslation("order.button.cart"); ?>": function() {
                        $("#orderDoneDialog").dialog("close");
                        callUrl("<?php echo NavigationModel::createStaticPageLink("shopBasket"); ?>");
                    }
                }
            });
            $("#orderDoneDialog").dialog("open");
            </script>
            <?php
        }
    }

    function printProductPage () {
        $product = ProductsPageModel::getProduct($_GET['id'], Context::getLang());
        ?>
        <div class="productPagePanel">
            <div class="productPageSlideShow">
                <?php
                if (!empty($product->gallery)) {
                    $images = GalleryModel::getImages($product->galleryid);
                    foreach ($images as $image) {
                        $imageLink = Resource::createResourceLink("gallery",$image->image);
                        ?>
                        <div class="productGalleryImages shadow">
                            <a href="<?php echo $imageLink; ?>">
                                <img class="imageLink" width="170" height="170" src="<?php echo $imageLink; ?>" alt=""/>
                            </a>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <img class="productImage shadow imageLink" src="<?php echo Resource::createResourceLink("products", $product->img); ?>" alt=""/>
                    <?php
                }
                ?>
            </div>
            <div class="productPageRight">
                <h1><?php echo Common::htmlEscape($product->price)." ".Config::getCurrency(); ?></h1>
                <form method="post" action="<?php echo parent::link(array("action"=>"addToKart")); ?>">
                    <?php InputFeilds::printTextFeild("quantity_".$product->id, $product->minimum == 0 ? "1" : $product->minimum); ?>
                    <label for="quantity_<?php echo $product->id; ?>"><?php echo parent::getTranslation("products.quantity"); ?></label>
                    <?php if ($product->weight != 0) { ?>
                        <input id="weight_<?php echo $product->id; ?>"  value="<?php echo $product->weight." ".Config::getWeight(); ?>" disabled="true" />
                        <label for="weight_<?php echo $product->id; ?>"><?php echo parent::getTranslation("products.weight"); ?></label>
                    <?php } ?>
                    <?php if ($product->shipping != 0) { ?>
                        <input id="shipping_<?php echo $product->id; ?>"  value="<?php echo $product->shipping." ".Config::getCurrency(); ?>" disabled="true" />
                        <label for="shipping_<?php echo $product->id; ?>"><?php echo parent::getTranslation("products.shipping"); ?></label>
                    <?php } ?>
                    <input type="hidden" id="minimum_<?php echo $product->id; ?>" name="minimum_<?php echo $product->id; ?>" value="<?php echo $product->minimum; ?>" />
                    <button type="submit" class="submit_order" id="addToCart"><?php echo parent::getTranslation("products.addToCart"); ?></button>
                    <button type="submit" id="backToCategory"><?php echo parent::getTranslation("products.cancel"); ?></button>
                </form>
            </div>
            <div class="productPageCenter">
                <h1><?php echo Common::htmlEscape($product->titel); ?></h1>
                <?php echo $product->text; ?>
            </div>
            <div id="checkValidDialog" title="Please Check Your input">
                <p class="validateTips"><?php echo parent::getTranslation("products.dialog.minimum"); ?></p>
            </div>
            <hr class="hrClear"/>
            <script>
            $("#backToCategory").button().click(function (event) {
                callUrl("<?php echo parent::link(); ?>");
                event.preventDefault();
            });
            $("#addToCart").button().click(function (event) {
                if ($("#quantity_<?php echo $product->id ?>").val() < $("#minimum_<?php echo $product->id; ?>").val()) {
                    $("#checkValidDialog").dialog("open");
                    event.preventDefault();
                }
            });
            $("#checkValidDialog").dialog({
                autoOpen: false, modal: true,
                height: 250, width: 350,
                show: "fade", hide: "explode",
                buttons: {
                "ok": function() {
                    $("#checkValidDialog").dialog("close");
                }
            }});
            </script>
        </div>
        <?php
    }
    
    function printEditView () {
        $tables = VirtualDataModel::getTables();
        if (count($tables) > 0) {
            $valueNameArray = Common::toMap($tables, "id", "name");
            ?>
            <div class="panel">
                <h3>Configure Products View</h3>
                <form method="post" id="ordersConfigForm" action="<?php echo parent::link(array("action"=>"save")); ?>">
                    <table width="100%" style="white-space: nowrap;"><tr><td>
                        Select Order Form: 
                    </td><td class="expand">
                        <?php
                        InputFeilds::printSelect("orderForm", parent::param("orderForm"), $valueNameArray);
                        ?>
                    </td><td>
                        <button id="configTable">Configure</button>
                    </td></tr><tr><td>
                        Rolegroup that receives orders:
                    </td><td class="expand" colspan="2">
                        <?php
                        InputFeilds::printSelect("roleGroup", parent::param("roleGroup"), Common::toMap(RolesModel::getCustomRoles(),"id","name"));
                        ?>
                    </td></tr><tr><td>
                        Product group to display:
                    </td><td class="expand">
                        <?php
                        $groups = ProductsPageModel::getGroups();
                        InputFeilds::printSelect("productGroup", parent::param("productGroup"), Common::toMap($groups,"id","name"));
                        ?>
                    </td><td>
                        <button id="configGroup">Configure</button>
                    </td></tr><tr><td>
                        Product Display Mode:
                    </td><td class="expand" colspan="2">
                        <?php
                        InputFeilds::printSelect("displayMode", parent::param("displayMode"), array(self::displayModeList=>"List",self::displayModeGrid=>"Grid"));
                        ?>
                    </td></tr></table>
                    <br/>
                    <hr/>
                    <div style="text-align:right;">
                        <button id="saveButton">Save</button>
                    </div>
                </form>
                <script>
                $('#configTable').button().click(function (event) {
                    callUrl("<?php echo NavigationModel::createStaticPageLink("configTables",array(),false); ?>",{"table":$("#orderForm").val()});
                    event.preventDefault();
                });
                $('#configGroup').button().click(function (event) {
                    callUrl("<?php echo parent::staticLink("productGroups",array(),false) ?>");
                    event.preventDefault();
                });
                $('#saveButton').button().click(function () {
                    $('#ordersConfigForm').submit();
                });
                </script>
            </div>
            <?php
        }
    }
    
}

?>