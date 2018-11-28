<?php

class RegisterView extends UIView {
    
    static $action_register = "register";
    
    function process () {
        
        switch (Request::getAction()) {
            
            case self::$action_register:
                UserController::register(Request::postMap());
                Request::redirect(ProfileView);
                break;
        }
    }
    
    function view () {
        
        ?>
        <form method="post" action="<?php echo parent::link(self::$action_register); ?>">
            <h1><?php echo Translations::get("register.title"); ?></h1>
            <p><?php echo Translations::get("register.description"); ?></p>
            <div class="table">
                <div>
                    <label><?php echo Translations::get("register.email"); ?></label>
                    <input name="email" type="email" value="" placeholder="<?php echo Translations::get("register.email"); ?>" />
                </div>
                <div>
                    <label><?php echo Translations::get("register.username"); ?></label>
                    <input name="username" type="textfeild" value="" placeholder="<?php echo Translations::get("register.username"); ?>" />
                </div>
                <div>
                    <label><?php echo Translations::get("register.firstName"); ?></label>
                    <input name="firstName" type="textfeild" value="" placeholder="<?php echo Translations::get("register.firstName"); ?>" />
                </div>
                <div>
                    <label><?php echo Translations::get("register.lastName"); ?></label>
                    <input name="lastName" type="textfeild" value="" placeholder="<?php echo Translations::get("register.lastName"); ?>" />
                </div>
                <div>
                    <label><?php echo Translations::get("register.birthDate"); ?></label>
                    <input name="birthDate" type="date" />
                </div>
                <div>
                    <label><?php echo Translations::get("register.telephone"); ?></label>
                    <input name="telephone" type="tel" />
                </div>
                <div>
                    <label><?php echo Translations::get("register.homepage"); ?></label>
                    <input name="homepage" type="url" />
                </div>
                <div>
                    <label><?php echo Translations::get("register.agbs"); ?></label>
                    <div>
                        <input name="agbs" type="checkbox" value="1" />
                        <?php echo Translations::get("register.agbsLink"); ?>
                    </div>
                </div>
            </div>
            <hr/>
            <button type="submit"><?php echo Translations::get("register.submit"); ?></button>
            <p><?php echo Translations::get("register.description"); ?></p>
        </form>
        <?php
    }
}

?>