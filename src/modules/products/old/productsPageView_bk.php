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

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {

        $this->getRequestVars();
        $pageId = parent::getId();

        switch (parent::getAction()) {

            case "update":
                parent::redirect();
                break;
            case "save":
                if (Context::hasRole("products.edit")) {
                    parent::param("orderForm",$_POST['orderForm']);
                    parent::param("roleGroup",$_POST['roleGroup']);
                    parent::param("choseUser",$_POST['choseUser']=="1" ? "1" : "0");
                }
                parent::redirect();
                break;
            case "createproduct":
                if (Context::hasRole("products.edit")) {
                    $nextImageId = md5(microtime());
                    $uploadedFile = $_FILES['productimage']['name'];
                    $type = strtolower(substr($uploadedFile,strrpos($uploadedFile,".")+1,3));
                    $targetPath = Resource::getResourcePath("products", "$nextImageId.$type");
                    if(!move_uploaded_file($_FILES['productimage']['tmp_name'], $targetPath)) {
                        echo "error moving uploaded file!";
                    }
                    $this->articleContent = stripslashes($this->articleContent);
                    $this->productpage = stripslashes($this->productpage);
                    ProductsPageModel::createProduct($pageId, "$nextImageId.$type", $this->articleContent, $_POST['articleName'], $_POST['stockAmount'], $_POST['price'], $_POST['minimumAmount'], Context::getLang());
                }
                parent::redirect();
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
                    $targetPath = Resource::getResourcePath("products", "$nextImageId.$type");
                    if(!move_uploaded_file($_FILES['productimage']['tmp_name'], $targetPath)) {
                        $imageFile = $_POST['oldproductimage'];
                    } else {
                        $imageFile = "$nextImageId.$type";
                    }
                    $this->articleContent = stripslashes($this->articleContent);
                    ProductsPageModel::updateProduct($this->productId, $pageId,$imageFile, $this->articleContent, $_POST['articleName'], $_POST['stockAmount'], $_POST['price'], $_POST['minimumAmount'], Context::getLang());
                }
                parent::redirect();
                break;

            case "moveup":
                if (Context::hasRole("products.edit")) {
                    ProductsPageModel::moveUp($pageId, $this->productId);
                }
                parent::blur();
                break;
            case "movedown":
                if (Context::hasRole("products.edit")) {
                    ProductsPageModel::moveDown($pageId, $this->productId);
                }
                parent::blur();
                break;
            case "viewproduct":
                parent::focus();
                break;
            case "edit":
                if (Context::hasRole("products.edit")) {
                    DynamicDataView::processAction(parent::param("orderForm"), parent::link(), parent::link(array("action"=>"edit"),false));
                }
                parent::focus();
                break;
            case "newproduct":
                parent::focus();
                break;
            case "editproduct":
                parent::focus();
                break;
            case "cancel":
                parent::blur();
                break;
            case "addToKart":
                // set products in session
                $products = ProductsPageModel::getProducts($pageId,Context::getLang());
                $_SESSION['products.orders'] = array();
                foreach ($products as $product) {
                    if (isset($_POST['quantity_'.$product->id])) {
                        $quantity = $_POST['quantity_'.$product->id];
                        if ($quantity > 0) {
                            $order;
                            $order->productid = $product->id;
                            $order->quantity = $quantity;
                            $order->name = $product->titel;
                            $_SESSION['products.orders'][$order->productid] = $order;
                            unset($order);
                        }
                    }
                }
                if (!Common::isEmpty(parent::param("orderForm"))) {
                    $orderId = OrdersModel::createOrder(Context::getUserId(),$_SESSION['products.orders']
                        ,parent::param("orderForm"),parent::param("roleGroup")
                        ,parent::param('choseUser') == "1" ? $_POST['distributor'] : null);
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
                $this->printEditView(parent::getId());
                break;
            case "newproduct":
                $this->printEditProductView(parent::getId(),null);
                break;
            case "editproduct":
                $this->printEditProductView(parent::getId(),$_GET['productid']);
                break;
            case "addToKart":
                $this->printMainView(parent::getId(),true);
            default:
                $this->printMainView(parent::getId());
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
        $productsPageModel = new ProductsPageModel();
        $searchResults = $productsPageModel->search($searchText,Context::getLang());
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


    function printMainView ($pageId,$orderDone=false) {

        $products = ProductsPageModel::getProducts($pageId,Context::getLang());

        ?>
        <div class="panel">
            <form id="productsForm" onsubmit="" action="<?php echo parent::link(array("action"=>"addToKart")); ?>" method="post">

                <?php
                if (Context::hasRole("products.edit")) {
                    ?>
                    <a style="text-align:right;" href="<?php echo parent::link(array("action"=>"newproduct")); ?>">Neues Produkt erstellen</a>
                    <?php
                }
                ?>
                <table class="expand"><tr><td colspan="2"><hr/></td></tr>
                <?php
                for ($i=0; $i<count($products); $i++) {
                    ?>

                    <tr><td valign="top" align="left">
                        <img class="productsImage imageLink" src="<?php echo Resource::createResourceLink("products", $products[$i]->img); ?>" alt=""/>
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
                            <?php if ($products[$i]->quantity != 0) { echo Common::htmlEscape("Lagerbestand: ".$products[$i]->quantity." "); } ?>
                            <?php if ($products[$i]->minimum != 0) { echo Common::htmlEscape("Mindestabnahme: ".$products[$i]->minimum." Stk."); } ?>
                            <br/>Bestellmenge: <?php InputFeilds::printTextFeild("quantity_".Common::htmlEscape($products[$i]->id), ""); ?>
                            <input type="hidden" id="<?php echo "quantity_".Common::htmlEscape($products[$i]->id)."_min"; ?>" value="<?php echo Common::htmlEscape($products[$i]->minimum); ?>">
<!--                        <button class="submit_order" type="button" >Bestellen</button>  -->
				<p><a href="#" class="submit_order"><img src="resource/img/bestellen_button.png" alt="" title="" style="border:0" /></a></p>

                        </div>
                    </td></tr>
                    <tr><td colspan="2"><hr/></td></tr>

                    <?php
                    }
                    ?>
                    </table>
                    <input type="hidden" id="distributor" name="distributor" value="" />
                    <?php
                    if (parent::param("choseUser")) {
                        ?>
                        <div id="selectDistributorDialog" title="Please Choose a Distributor">
                            <p class="validateTips">Bitte w&auml;hlen sie ein Distributor! <br/>
                                <?php InputFeilds::printSelect("selectDistributor", null, Common::toMap(UsersModel::getUsersByCustomRoleId(parent::param("roleGroup")), "id", "username")) ?>
                            </p>
                        </div>
                        <?php
                    }
                    ?>

                    <div style="text-align: right;">
                        <button class="submit_order" type="button" >Bestellen</button>
                    </div>

            </form>
        </div>
        <div id="checkValidDialog" title="Please Check Your input">
            <p class="validateTips">Bitte beachten Sie die Mindestabnahme! </p>
        </div>
        <?php
        if ($orderDone == true) {
            ?>
            <div id="orderDoneDialog" title="Order Successfull">
                <p class="validateTips">Danke Ihre Bestellung wurde im Warenkorb abgelegt!
                    Sie m&uuml;ssen noch die Bestellung im Warenkorb best&auml;tigen</p>
            </div>
            <?php
        }
        ?>
        <script>
        $("button").button();
        $("#checkValidDialog").dialog({
            autoOpen: false, modal: true,
            height: 250, width: 350,
            show: "fade", hide: "explode",
            buttons: {
            "ok": function() {
                $("#checkValidDialog").dialog("close");
            }
        }});
        $("#selectDistributorDialog").dialog({
            autoOpen: false, modal: true,
            height: 250, width: 350,
            show: "fade", hide: "explode",
            buttons: {
            "ok": function() {
                $("#distributor").val($("#selectDistributor").val());
                $("#selectDistributorDialog").dialog("close");
                $("#productsForm").submit();
            }
        }});

        var invalid = false;
        var cntOrderedProducts = 0;
        $(".submit_order").button().click(function() {
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
            } else {
                <?php
                if (parent::param("choseUser") == "1") {
                    echo '$("#selectDistributorDialog").dialog("open");';
                } else {
                    echo '$("#productsForm").submit();';
                }
                ?>
            }
            invalid = false;
            cntOrderedProducts = 0
            return false;
        });
        <?php
        if ($orderDone == true) {
            ?>
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
            <?php
        }
        ?>
        </script>
        <?php

    }


    function printEditProductView ($pageId,$productId) {

        $article = null;
        if ($productId == null) {
            $formAction = "createproduct";
        } else {
            $formAction = "updateproduct";
            $article = ProductsPageModel::getProduct($productId, Context::getLang());
        }

        ?>
        <div class="panel">
            <form name="articleForm" method="post" enctype="multipart/form-data"  action="<?php echo parent::link(array("action"=>$formAction,"productid"=>$productId)); ?>">
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
                        <img class="productsImage imageLink" src="<?php echo Resource::createResourceLink("products", $article->img); ?>" alt=""/>
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
                <hr noshade/>
                <div class="formFeildButtons" align="right">
                    <button type="submit" class="button">Speichern</button>
                    <button type="submit" class="button" style="margin-left:6px;" onclick="callUrl('<?php echo parent::link(array('action'=>'cancel')); ?>'); return false;">Abbrechen</button>
                </div>
            </form>
        </div>
        <?php
    }

    function printEditView ($pageId) {
        $tables = VirtualDataModel::getTables();
        if (count($tables) > 0) {
            $valueNameArray = Common::toMap($tables, "name", "name");
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
                        Should user be chosen
                    </td><td class="expand" colspan="2">
                        <?php
                        InputFeilds::printCheckbox("choseUser", parent::param("choseUser"));
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
                })
                $('#saveButton').button().click(function () {
                    $('#ordersConfigForm').submit();
                })

                </script>
            </div>
            <?php
        }
    }


}

?>