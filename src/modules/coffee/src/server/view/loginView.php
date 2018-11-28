<?php

class LoginView extends UIView {
    
    static $action_login = "login";
    
    function process () {
        
        switch (Request::getAction()) {
            
            case $this->action_login:
                $controller = Controller::get("User");
                $user = $controller->login(Request::post("username"), Request::post("password"));
                if ($user) {
                    switch ($user->type) {
                        case UserObject::type_seller:
                            Request::redirect(UI::view_orders);
                            break;
                        case UserObject::type_buyer:
                            Request::redirect(UI::view_buyOffer);
                            break;
                        case UserObject::type_admin:
                            Request::redirect(UI::view_statistics);
                            break;
                    }
                } else {
                    Request::redirect(UI::view_deny);
                }
                break;
        }
    }
    
    function view () {
        
        ?>
        <form method="post" action="<?php echo parent::link(self::$action_login); ?>">
            <h1><?php echo Translations::get("login.title"); ?></h1>
            <p><?php echo Translations::get("login.description"); ?></p>
            <label for="username"><?php echo Translations::get("login.username"); ?></label>
            <input name="username" type="textfeild" value="" placeholder="<?php echo Translations::get("login.username.placeholder"); ?>" />
            <label for="password"><?php echo Translations::get("login.password"); ?></label>
            <input name="password" type="password" value="" placeholder="<?php echo Translations::get("login.password.placeholder"); ?>" />
            <hr/>
            <button type="submit"><?php echo Translations::get("login.submit"); ?></button>
            <button type="submit"><?php echo Translations::get("login.register"); ?></button>
        </form>
        <?php
    }
}

?>