<?php

require_once 'core/plugin.php';
require_once 'modules/products/productsPageModel.php';

class ProductOfferMailModule extends XModule {

    function onProcess () {
        
        switch (parent::getAction()) {
            
            case "":
            case "saveOfferMail":
                
                parent::focus();
                break;
            case "cancel":
                parent::blur();
                break;
        }
    }

    function onView () {
        
        switch (parent::getAction()) {
            
            case "newProduct":
                $this->printEditProductTabsView($parent);
                break;
            default:
                if ($parent == null) {
                    $this->printProductGroupsTabsView();
                } else {
                    $this->printProductsTabsView($parent);
                }
        }
    }
    
    function getRoles () {
        return array();
    }

    function getStyles () {
        return array("css/products.css");
    }
    
    function printMainView () {
        ?>
        <div class="panel">
            <h1><?php echo parent::getTranslation("product.offerMail.titel"); ?></h1>
            <p><?php echo parent::getTranslation("product.offerMail.description"); ?></p>
        <div>
        <?php
    }
    

}


?>