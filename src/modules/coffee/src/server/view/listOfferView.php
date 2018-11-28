<?php

class ListOfferView extends UIView {
    
    static $action_createOffer = "saveOffer";
    
    function process () {
        
        switch (Request::getAction()) {
            
            case $this->action_saveOffer:
                $price = Request::get("price");
                $i_price = intval($price);
                if ($i_price == $price && $i_price > 0) {
                    $controller = Controller::get("Offer");
                    $controller->addOffer(Request::getUser(), $price);
                    Request::redirect(UI::$view_orders);
                }
                break;
        }
    }
    
    function view () {
        
        $offers = DB::all("offers");
        ?>
        <form method="post" action="<?php echo parent::link(self::$action_order); ?>">
            <h1><?php echo Translations::get("offerList.title"); ?></h1>
            <p><?php echo Translations::get("offerList.description"); ?></p>
            <div class="table">
                <?php
                foreach ($offers as $offer => $pos) {
                    ?>
                    <div>
                        <div>
                            <?php echo htmlentities($offer->price); ?>
                        </div>
                        <div>
                            <?php echo htmlentities($offer->product->name); ?>
                        </div>
                        <div>
                            <a href="<?php echo parent::link(array("action"=>self::$action_offer, "id"=>$offer->product->publicid)); ?>"><?php echo Translations::get("offerList.order"); ?></a>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <p><?php echo Translations::get("orderList.suffix"); ?></p>
            <hr/>
            <button type="submit"><?php echo Translations::get("orderList.submit"); ?></button>
        </form>
        <?php
    }
}

?>