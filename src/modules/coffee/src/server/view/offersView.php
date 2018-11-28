<?php

class OffersView extends UIView {
    
    static $action_offerState = "offerState";
    
    function process () {
        
        switch (parent::getAction()) {
            
            case self::$action_offerState:
                $controller = Controller::get("Order");
                if (Request::post("confirm")) {
                    $controller->confirm(Request::post("confirm"));
                }
                if (Request::post("decline")) {
                    $controller->decline(Request::post("decline"));
                }
                break;
        }
    }
    
    function view () {
        
        $offers = DB::all("offers");
        ?>
        <form method="post" action="<?php echo parent::link(self::$action_offerState); ?>">
            <h1><?php echo Translations::get("offers.title"); ?></h1>
            <p><?php echo Translations::get("offers.description.top"); ?></p>
            <div class="table">
                <?php
                foreach ($offers as $offer => $pos) {
                    ?>
                    <div>
                        <div>
                            <?php echo $offer->country; ?>
                        </div>
                        <div>
                            <?php echo $offer->product; ?>
                        </div>
                        <div>
                            <?php echo $offer->quantity; ?>
                        </div>
                        <div>
                            <?php echo $offer->price; ?>
                        </div>
                        <div>
                            <button name="confirm" value="<?php echo $offer->publicid; ?>"><?php echo Translations::get("offers.confirm"); ?></button>
                        </div>
                        <div>
                            <button name="decline" value="<?php echo $offer->publicid; ?>"><?php echo Translations::get("offers.decline"); ?></button>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <p><?php echo Translations::get("offers.description.bottom"); ?></p>
        </form>
        <?php
    }
}

?>