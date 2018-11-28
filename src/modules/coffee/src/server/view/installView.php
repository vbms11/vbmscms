<?php

class InstallView extends UIView {
    
    static $action_login = "login";
    static $action_saveDatabase = "saveDatabase";
    static $action_saveAdmin = "saveAdmin";
    static $action_saveTerms = "saveTerms";
    static $action_start = "start";
    
    function process () {
        
        RegisterView::process();
        
        switch (self::getAction()) {
            case self::$action_viewDatabase:
                break;
            case self::$action_saveDatabase:
                if (Request::get("saveDatabase") == "1") {
                    Config::write(Request::post("database"),Request::post("server"),Request::post("username"),Request::post("password"));
                }
                break;
            case self::$action_saveTerms:
                self::viewDatabaseStep();
                break;
            default:
                self::viewWelcomeStep();
        }
    }
    
    function view () {
        echo "yey install view";
        switch (self::getAction()) {
            case self::$action_viewDatabase:
                self::viewDatabaseStep();
                break;
            case self::$action_saveDatabase:
                self::viewAdminStep();
                break;
            case self::$action_saveTerms:
                self::viewDatabaseStep();
                break;
            default:
                self::viewWelcomeStep();
        }
    }
    
    function viewWelcomeStep () {
        
        ?>
        <form method="post" action="<?php echo self::link(self::$action_viewTerms); ?>">
            <h1><?php echo Translations::get("install.welcome.title"); ?></h1>
            <p><?php echo Translations::get("install.welcome.description"); ?></p>
            <hr/>
            <button type="submit"><?php echo Translations::get("install.welcome.next"); ?></button>
        </form>
        <?php
    }
    
    function viewDatabaseStep () {
        
        ?>
        <form method="post" action="<?php echo parent::link(self::$action_saveDatabase); ?>">
            <h1><?php echo Translations::get("install.database.title"); ?></h1>
            <p><?php echo Translations::get("install.database.description"); ?></p>
            <div class="table">
                <div>
                    <label for="server"><?php echo Translations::get("install.database.server"); ?></label>
                    <input name="server" type="textfeild" value="" placeholder="<?php echo Translations::get("install.database.server.placeholder"); ?>" />
                </div>
                <div>
                    <label for="database"><?php echo Translations::get("install.database.database"); ?></label>
                    <input name="database" type="textfeild" value="" placeholder="<?php echo Translations::get("install.database.database.placeholder"); ?>" />
                </div>
                <div>
                    <label for="username"><?php echo Translations::get("install.database.username"); ?></label>
                    <input name="username" type="textfeild" value="" placeholder="<?php echo Translations::get("install.database.username.placeholder"); ?>" />
                </div>
                <div>
                    <label for="password"><?php echo Translations::get("install.database.password"); ?></label>
                    <input name="password" type="textfeild" value="" placeholder="<?php echo Translations::get("install.database.password.placeholder"); ?>" />
                </div>
            </div>
            <hr/>
            <button type="submit"><?php echo Translations::get("install.database.prev"); ?></button>
            <button type="submit"><?php echo Translations::get("install.database.next"); ?></button>
        </form>
        <?php
    }
    
    function viewAdminStep () {
        
        RegisterView::render();
    }
    
    function viewTermsStep () {
        
        ?>
        <form method="post" action="<?php echo self::link(self::$action_saveTerms); ?>">
            <h1><?php echo Translations::get("install.terms.title"); ?></h1>
            <p><?php echo Translations::get("install.terms.description"); ?></p>
            <textarea name="terms" cols="3" rows="3" class="3" dissabled>
                <?php echo htmlentities(Translations::get("install.terms.license")); ?>
            </textarea>
            <?php
            RegisterView::render();
            ?>
            <hr/>
            <button type="submit"><?php echo Translations::get("install.submit"); ?></button>
            <button type="submit"><?php echo Translations::get("install.register"); ?></button>
        </form>
        <?php
    }
    
    function viewSettingsStep () {
        
    }
    
}

?>