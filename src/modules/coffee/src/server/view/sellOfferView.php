<?php

class SellOfferView extends UIView {
    
    static $action_saveOffer = "saveOffer";
    
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
        
        ?>
        <form method="post" action="<?php echo parent::link(self::$action_saveOffer); ?>">
            <h1><?php echo Translations::get("sell.offer.title"); ?></h1>
            <p><?php echo Translations::get("sell.offer.description"); ?></p>
            <label for="price"><?php echo Translations::get("sell.offer.price"); ?></label>
            <input type="number" name="price" />
            <span><?php echo Translations::get("sell.offer.currency"); ?></span>
            <p><?php echo Translations::get("sell.offer.suffix"); ?></p>
            <hr/>
            <button type="submit"><?php echo Translations::get("sell.offer.submit"); ?></button>
        </form>
        <?php
    }
}

?>

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
    
class SettingsView extends UIView {
    
    static $action_saveSettings = "saveSettings";
    
    function process () {
        
        switch (Request::getAction()) {
            
            case self::$action_saveSettings:
                $translations = Translations::all();
                $emails = DB::getAll("emails");
                foreach ($translations as $translation => $key) {
                    $translation->postValue();
                    $translation->save();
                }
                foreach ($emails as $email) {
                    $email->postValue();
                    $email->save();
                }
                break;
        }
    }
    
    function view () {
        
        $translations = Translations::all();
        $emails = DB::all("emails");
        ?>
        <form method="post" action="<?php echo parent::link($this->action_saveSettings); ?>">
            <h1><?php echo Translations::get("configurations.title"); ?></h1>
            <p><?php echo Translations::get("configurations.description.top"); ?></p>
            <h3><?php echo Translations::get("configurations.translations.title"); ?></h3>
            <p><?php echo Translations::get("configurations.translations.description"); ?></p>
            <div class="table">
                <?php
                foreach ($translations as $translation => $name) {
                    ?>
                    <div>
                        <label for="<?php echo $name; ?>">
                            <?php echo $name; ?>
                        </label>
                        <div>
                            <?php
                            foreach ($translation as $value => $lang) {
                                ?>
                                <textarea name="<?php echo $lang."_".$name; ?>"><?php echo htmlentities($value); ?></textarea>
                                <span><?php echo $lang; ?></span>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <h3><?php echo Translations::get("configurations.emails.title"); ?></h3>
            <p><?php echo Translations::get("configurations.emails.description"); ?></p>
            <div class="divTable">
                <?php
                foreach ($emails as $email => $pos) {
                    ?>
                    <div>
                        <label for="<?php echo ."name_".$email->name; ?>">
                            <?php echo Translations::get("configurations.email.subject"); ?>
                        </label>
                        <div>
                            <input name="<?php echo ."name_".$email->name; ?>" dissabled value="<?php echo htmlentities($email->name, ENT_QUOTES); ?>"/>
                        </div>
                    </div>
                    <div>
                        <label for="<?php echo "subject_".$email->name; ?>">
                            <?php echo Translations::get("configurations.email.subject"); ?>
                        </label>
                        <div>
                            <textarea name="<?php echo "subject_".$email->name; ?>"><?php echo htmlentities($email->subject, ENT_QUOTES); ?></textarea>
                        </div>
                    </div>
                    <div>
                        <label for="<?php echo "message_".$email->name; ?>">
                            <?php echo Translations::get("configurations.email.message"); ?>
                        </label>
                        <div>
                            <textarea name="<?php echo "message_".$email->name; ?>"><?php echo htmlentities($email->message, ENT_QUOTES); ?></textarea>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <p><?php echo Translations::get("configurations.description.top"); ?></p>
            <hr/>
            <button type="submit"><?php echo Translations::get("configurations.description.top"); ?></button>
        </form>
        <?php
    }
}

class SellOffersListView extends UIView {
    
    static $action_createOffer = "saveOffer";
    
    function process () {
        
        switch (Request::getAction()) {
            
            case self::$action_saveOffer:
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

class SettingType extends DBObject {
   
    static $settings_type_checkbox = "settingType.checkbox";
    static $settings_type_text = "settingType.text";
    static $settings_type_textarea = "settingType.textarea";
    static $settings_type_date = "settingType.date";
    static $settings_type_time = "settingType.time";
    static $settings_type_dropdown = "settingType.dropdown";
    
    public $options;
    public $value;
    public $label;
    public $name;
    public $type;
    
    public __constructor ($type, $name, $label, $value, $options) {
        
        parent(array(
            array(
                "name" => "name",
                "label" => "Name",
                "type" => "varchar",
                "length" => 200,
                "null" => false
            )
        ));
        
        $options = $options;
        $value = $value;
        $label = $label;
        $name = $name;
    }
    
    public html () {
        
        switch ($this->type) {
            case settings_type_checkbox:
                return '<input type="checkbox" value="'.$this->value.'" name="'.$this->name.'" />';
            case settings_type_text:
                return '<input type="text" value="'.$this->value.'" name="'.$this->name.'" />';
            case settings_type_textarea:
                return '<textarea name="'.$this->name.'">'.htmlentities($this->value).'</textarea>';
            case settings_type_date:
                return '<input type="date" value="'.$this->value.'" name="'.$this->name.'" />';
            case settings_type_time:
                return '<input type="time" value="'.$this->value.'" name="'.$this->name.'" />';
            case settings_type_dropdown:
                $options = array();
                foreach ($this->options as $option => $value) {
                    $options []= '<option value="'.$value.'">'.$option.'</option>';
                }
                return '<select name="'.$this->name.'">'.$options.'</select>';
        }
    }
    
    public postValue () {
        
        $this->value = Request::post($this->name);
    }
    
}

class Setting extends SettingType {
    
    
}

class SettingsView {
    
    static $action_saveSettings = "saveSettings";
    
    function process () {
        
        switch (self::getAction()) {
            
            case self::$action_saveSettings:
                $settings = DB::getAll("settings");
                foreach ($settings as $setting) {
                    $setting->postValue();
                    $setting->save();
                }
                break;
        }
    }
    
    function view () {
        
        $settings = DB::getAll("settings");
        ?>
        <form method="post" action="<?php echo parent::link(self::$action_saveSettings); ?>">
            <h1><?php echo Translations::get("settings.title"); ?></h1>
            <p><?php echo Translations::get("settings.description.top"); ?></p>
            <div class="table">
                <?php
                foreach ($settings as $setting) {
                    ?>
                    <div>
                        <label for="<?php echo $setting->label; ?>">
                            <?php echo $name; ?>
                        </label>
                        <div>
                            <?php echo $setting->html(); ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <p><?php echo Translations::get("settings.description.bottom"); ?></p>
            <hr/>
            <button type="submit"><?php echo Translations::get("settings.save"); ?></button>
            <button type="reset"><?php echo Translations::get("settings.reset"); ?></button>
        </form>
        <?php
    }
    
}
