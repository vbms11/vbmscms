<?php

require_once 'core/plugin.php';
require_once 'modules/products/productsPageModel.php';
require_once 'modules/gallery/galleryModel.php';

class ProductGroupsModule extends XModule {

    function onProcess () {

        $parent = (isset($_GET['parent']) ? $_GET['parent'] : null);

        switch (parent::getAction()) {
            case "createProduct":
                if (Context::hasRole("products.edit")) {
                    $nextImageId = md5(microtime());
                    $uploadedFile = $_FILES[parent::alias('productImage')]['name'];
                    if (!Common::isEmpty($uploadedFile)) {
                        $type = strtolower(substr($uploadedFile,strrpos($uploadedFile,".")+1,3));
                        $targetPath = ResourcesModel::getResourcePath("products", "$nextImageId.$type");
                        if(!move_uploaded_file($_FILES[parent::alias('productImage')]['tmp_name'], $targetPath)) {
                            echo "error moving uploaded file!";
                        }
                    }
                    ProductsPageModel::createProduct($parent, "$nextImageId.$type" ,$_POST[parent::alias("shorttext")], $_POST[parent::alias("text")],$_POST[parent::alias('titel')],$_POST[parent::alias('stockAmount')],$_POST[parent::alias('price')],$_POST[parent::alias('shipping')],$_POST[parent::alias('weight')],$_POST[parent::alias('minimumAmount')],$_POST[parent::alias('gallerId')],Context::getLang());
                }
                parent::blur();
                parent::redirect(array("parent"=>$parent));
                break;
            case "deleteProduct":
                if (Context::hasRole("products.edit")) {
                    ProductsPageModel::deleteProduct($_GET['id']);
                }
                parent::redirect(array("parent"=>$parent));
                break;
            case "moveUp":
                if (Context::hasRole("products.edit")) {
                    ProductsPageModel::moveUp($_GET['id']);
                }
                parent::redirect(array("parent"=>$parent));
                break;
            case "moveDown":
                if (Context::hasRole("products.edit")) {
                    ProductsPageModel::moveDown($_GET['id']);
                }
                parent::redirect(array("parent"=>$parent));
                break;
            case "updateProduct":
                if (Context::hasRole("products.edit")) {
                    $nextImageId = md5(microtime());
                    $uploadedFile = $_FILES[parent::alias('productImage')]['name'];
                    $type = strtolower(substr($uploadedFile,strrpos($uploadedFile,".")+1,3));
                    $targetPath = ResourcesModel::getResourcePath("products", "$nextImageId.$type");
                    if(!move_uploaded_file($_FILES[parent::alias('productImage')]['tmp_name'], $targetPath)) {
                        $imageFile = $_POST[parent::alias('oldProductImage')];
                    } else {
                        $imageFile = "$nextImageId.$type";
                    }
                    ProductsPageModel::updateProduct($_GET['id'], $parent,$imageFile, $_POST[parent::alias('shorttext')], $_POST[parent::alias('text')], $_POST[parent::alias('titel')], $_POST[parent::alias('stockAmount')], $_POST[parent::alias('price')], $_POST[parent::alias('shipping')], $_POST[parent::alias('weight')], $_POST[parent::alias('minimumAmount')], $_POST[parent::alias('gallerId')], Context::getLang());
                }
                parent::blur();
                parent::redirect(array("parent"=>$parent));
                break;
            case "createGroup":
                ProductsPageModel::createGroup($_POST[parent::alias('groupName')]);
                parent::blur();
                parent::redirect(array("parent"=>$parent));
                break;
            case "updateGroup":
                ProductsPageModel::updateGroup($_GET['id'],$_POST[parent::alias('groupName')]);
                parent::blur();
                parent::redirect(array("parent"=>$parent));
                break;
            case "deleteGroup":
                ProductsPageModel::deleteGroup($_GET['id']);
                parent::redirect(array("parent"=>$parent));
                break;
            case "back":
                $group = ProductsPageModel::getGroup($_GET['parent']);
                parent::redirect(array("parent"=>$group->parent));
                break;
            case "editGroup":
            case "newGroup":
            case "editProduct":
            case "newProduct":
                parent::focus();
                break;
            case "cancel":
                parent::blur();
                break;
        }
    }

    function onView () {

        $parent = (isset($_GET['parent']) ? $_GET['parent'] : null);

        switch (parent::getAction()) {

            case "editGroup":
                $this->printEditGroup($parent, $_GET['id']);
                break;
            case "newGroup":
                $this->printEditGroup($parent);
                break;
            case "editProduct":
                $this->printEditProduct($parent, $_GET['id']);
                break;
            case "newProduct":
                $this->printEditProduct($parent);
                break;
            default:
                $this->printMainView($parent);
        }
    }

    function getRoles () {
        return array();
    }

    function getStyles () {
        return array("css/products.css");
    }

    static function getTranslations () {
        return array("en" => array(
                "products.image"        =>"Product Image",
                "products.gallery"      =>"Product Gallery",
                "products.titel"        =>"Name",
                "products.shorttext"    =>"Short Text",
                "products.text"         =>"Long Text",
                "products.stock"        =>"Stock",
                "products.price"        =>"Price",
                "products.minimum"      =>"Minimum Amount",
                "products.weight"       =>"Weight",
                "products.shipping"     =>"Shipping Costs"
            ), "de" => array(
                "products.image"        =>"Product Image",
                "products.gallery"      =>"Product Gallery",
                "products.titel"        =>"Name",
                "products.shorttext"    =>"Short Text",
                "products.text"         =>"Long Text",
                "products.stock"        =>"Stock",
                "products.price"        =>"Price",
                "products.minimum"      =>"Minimum Amount",
                "products.weight"       =>"Weight",
                "products.shipping"     =>"Shipping Costs"
            ));
    }

    function printMainView ($parent) {
        ?>
        <div class="panel">
            <?php
            if ($parent ==  null) {
                $groups = ProductsPageModel::getGroups($parent);
                InfoMessages::printInfoMessage("product.groups.main.grouplist") ?>
                <br/>
                <div class="alignRight">
                    <button type="button" id="<?php echo parent::alias("newGroup"); ?>">Create New Group</button>
                </div>
                <?php
                if (count($groups) > 0) {
                    ?>
                    <table class="productGroupsTable" cellspacing="0">
                    <thead>
                        <tr>
                        <td class="contract">id</td>
                        <td class="expand">name</td>
                        <td colspan="2" class="contract">tools</td>
                        <tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($groups as $group) {
                            ?>
                            <tr>
                            <td><?php echo $group->id ?></td>
                            <td><a href="<?php echo parent::link(array("parent"=>$group->id)); ?>"><?php echo $group->name ?></a></td>
                            <td><a href="<?php echo parent::link(array("action"=>"editGroup","id"=>$group->id,"parent"=>$parent)); ?>"><img src="resource/img/preferences.png" alt=""/></a></td>
                            <td><img src="resource/img/delete.png" alt="" onclick="doIfConfirm('Are you sure that you want to delete this product group?','<?php echo parent::link(array("action"=>"deleteGroup","parent"=>$parent,"id"=>$group->id),false); ?>');" /></td>
                            <tr>
                            <?php
                        }
                        ?>
                    </tbody>
                    </table>
                    <hr>
                    <?php
                }
            }
            if ($parent != null) {
                $products = ProductsPageModel::getProducts($parent, Context::getLang());
                InfoMessages::printInfoMessage("product.groups.main.productlist") ?>
                <br/>
                <div class="alignRight">
                    <button type="button" id="<?php echo parent::alias("newProduct"); ?>">Create New Product</button>
                    <button type="button" id="<?php echo parent::alias("newBack"); ?>">Back</button>
                </div>
                <?php
                if (count($products) > 0) {
                    ?>
                    <table class="productGroupsTable" cellspacing="0">
                    <thead>
                        <tr>
                        <td class="contract">id</td>
                        <td class="expand">name</td>
                        <td class="contract">price (<?php echo Config::getCurrency(); ?>)</td>
                        <td class="contract">stock</td>
                        <td class="contract">weight (<?php echo Config::getWeight(); ?>)</td>
                        <td class="contract">shipping (<?php echo Config::getCurrency(); ?>)</td>
                        <td class="contract">minimum</td>
                        <td colspan="4" class="contract">tools</td>
                        <tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($products as $product) {
                            ?>
                            <tr>
                            <td><?php echo $product->id ?></td>
                            <td><?php echo $product->titel ?></td>
                            <td><?php echo $product->price ?></td>
                            <td><?php echo $product->quantity ?></td>
                            <td><?php echo $product->weight ?></td>
                            <td><?php echo $product->shipping ?></td>
                            <td><?php echo $product->minimum ?></td>
                            <td><a href="<?php echo parent::link(array("action"=>"editProduct","id"=>$product->id,"parent"=>$parent)); ?>"><img src="resource/img/preferences.png" alt=""/></a></td>
                            <td><a href="<?php echo parent::link(array("action"=>"moveUp","id"=>$product->id,"parent"=>$parent)); ?>"><img src="resource/img/moveup.png" alt=""/></a></td>
                            <td><a href="<?php echo parent::link(array("action"=>"moveDown","id"=>$product->id,"parent"=>$parent)); ?>"><img src="resource/img/movedown.png" alt=""/></a></td>
                            <td><img src="resource/img/delete.png" alt="" onclick="doIfConfirm('Are you sure that you want to delete this product?','<?php echo parent::link(array("action"=>"deleteProduct","parent"=>$parent,"id"=>$product->id),false); ?>');" /></td>
                            <tr>
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
            $("#<?php echo parent::alias("newGroup"); ?>").button().click(function (event) {
                callUrl("<?php echo parent::link(array("action"=>"newGroup","parent"=>$parent),false); ?>");
            })
            $("#<?php echo parent::alias("newProduct"); ?>").button().click(function (event) {
                callUrl("<?php echo parent::link(array("action"=>"newProduct","parent"=>$parent),false); ?>");
            })
            $("#<?php echo parent::alias("newBack"); ?>").button().click(function (event) {
                callUrl("<?php echo parent::link(array("action"=>"back","parent"=>$parent),false); ?>");
            });
        </script>
        <?php
    }

    function printEditGroup ($parent = null, $id = null) {
        $group = null;
        $action = "createGroup";
        if ($id != null) {
            $group = ProductsPageModel::getGroup($id);
            $action = "updateGroup";
        }
        ?>
        <div class="panel">
            <form method="post" action="<?php echo parent::link(array("action"=>$action,"id"=>($id == null ? "" : $id),"parent"=>$parent)); ?>">
                <?php InfoMessages::printInfoMessage("product.groups.edit"); ?>
                <br/>
                <label>Group Name</label>
                <?php InputFeilds::printTextFeild(parent::alias("groupName"),($id == null ? "" : $group->name)); ?>
                <hr/>
                <div class="alignRight">
                    <button id="<?php echo parent::alias("saveGroup"); ?>" type="submit">Save</button>
                    <button id="<?php echo parent::alias("cancelSaveGroup"); ?>" type="button">Cancel</button>
                </div>
            </form>
        </div>
        <script>
        $("#<?php echo parent::alias("saveGroup"); ?>").button();
        $("#<?php echo parent::alias("cancelSaveGroup"); ?>").button().click(function (event) {
            callUrl("<?php parent::link(array("parent"=>$parent),false); ?>");
            event.preventDefault();
        });
        </script>
        <?php
    }

    function printEditProduct ($parent = null, $productId = null) {

        $article = null;
        $formAction = "createProduct";
        if ($productId != null) {
            $formAction = "updateProduct";
            $article = ProductsPageModel::getProduct($productId);
        }
        ?>
        <div class="panel editProduct">
            <form method="post" enctype="multipart/form-data"  action="<?php echo parent::link(array("action"=>$formAction,"id"=>$productId,"parent"=>$parent)); ?>">
                <input type="hidden" name="<?php echo parent::alias("oldProductImage"); ?>" value="<?php echo $productId == null ? "" : $article->img; ?>" />
                <table width="100%"><tr><td class="expand nowrap" style="vertical-align: top;">
                    <table width="100%"><tr><td class="contract nowrap">
                        <b><?php echo parent::getTranslation("products.image"); ?>:</b>
                    </td><td class="expand">
                        <input type="file" class="expand" name="<?php echo parent::alias("productImage"); ?>" />
                    </td></tr><tr><td class="contract nowrap">
                        <b><?php echo parent::getTranslation("products.image"); ?>:</b>
                    </td><td class="expand">
                        <?php
                        $gallerys = Common::toMap(GalleryModel::getCategorys(),"id","title");
                        InputFeilds::printSelect(parent::alias("galleryId"), $article == null ? "" : $article->galleryid, $gallerys);
                        ?>
                    </td></tr><tr><td>
                        <b><?php echo parent::getTranslation("products.titel"); ?>:</b>
                    </td><td>
                        <?php
                        InputFeilds::printTextFeild(parent::alias("titel"), $article == null ? "" : $article->titel, "expand");
                        ?>
                    </td></tr><tr><td>
                        <b><?php echo parent::getTranslation("products.stock"); ?>:</b>
                    </td><td>
                        <?php
                        InputFeilds::printTextFeild(parent::alias("stockAmount"), $article == null ? "" : $article->quantity, "expand");
                        ?>
                    </td></tr><tr><td>
                        <b><?php echo parent::getTranslation("products.price")." (".Config::getCurrency().")"; ?>:</b>
                    </td><td>
                        <?php
                        InputFeilds::printTextFeild(parent::alias("price"), $article == null ? "" : $article->price, "expand");
                        ?>
                    </td></tr><tr><td>
                        <b><?php echo parent::getTranslation("products.minimum"); ?>:</b>
                    </td><td>
                        <?php
                        InputFeilds::printTextFeild(parent::alias("minimumAmount"), $article == null ? "" :$article->minimum, "expand");
                        ?>
                    </td></tr><tr><td>
                        <b><?php echo parent::getTranslation("products.weight")." (".Config::getWeight().")"; ?>:</b>
                    </td><td>
                        <?php
                        InputFeilds::printTextFeild(parent::alias("weight"), $article == null ? "" :$article->weight, "expand");
                        ?>
                    </td></tr><tr><td>
                        <b><?php echo parent::getTranslation("products.shipping")." (".Config::getCurrency().")"; ?>:</b>
                    </td><td>
                        <?php
                        InputFeilds::printTextFeild(parent::alias("shipping"), $article == null ? "" :$article->shipping, "expand");
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
                    <b><?php echo parent::getTranslation("products.shorttext"); ?>:</b>
                </div>
                <div class="formFeild">
                    <?php
                    InputFeilds::printHtmlEditor(parent::alias("shorttext"), $article == null ? "" :$article->shorttext);
                    ?>
                </div>
                <div class="formFeildLine">
                    <b><?php echo parent::getTranslation("products.text"); ?>:</b>
                </div>
                <div class="formFeild">
                    <?php
                    InputFeilds::printHtmlEditor(parent::alias("text"), $article == null ? "" :$article->text);
                    ?>
                </div>
                <hr/>
                <div class="alignRight">
                    <button type="submit" class="button">Speichern</button>
                    <button type="submit" class="button" onclick="callUrl('<?php echo parent::link(array('action'=>'cancel')); ?>'); return false;">Abbrechen</button>
                </div>
            </form>
        </div>
        <script>
        $(".editProduct button").each(function (index, object) {
            $(object).button();
        });
        </script>
        <?php
    }

}


?>