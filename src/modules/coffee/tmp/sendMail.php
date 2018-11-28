<?php



class Config {
    
    static $configFileName = "config.php";
    
    static function __get ($obj, $name) {
        return $GLOBALS[$name];
    }
    
    static function __call () {
        
    }
    
    static function load () {
        include_once(self::$configFileName);
    }
    
    static function write ($database,$hostname,$username,$password) {
        $config  = '<?php'.PHP_EOL;
        // database config
        $config .= '$GLOBALS[\'dbName\'] = \''.$database.'\';'.PHP_EOL;
        $config .= '$GLOBALS[\'dbHost\'] = \''.$hostname.'\';'.PHP_EOL;
        $config .= '$GLOBALS[\'dbUser\'] = \''.$username.'\';'.PHP_EOL;
        $config .= '$GLOBALS[\'dbPass\'] = \''.$password.'\';'.PHP_EOL;
        $config .= '$GLOBALS[\'dbTablePrefix\'] = \'t_\';'.PHP_EOL;
        $config .= '$GLOBALS[\'dbDateFormat\'] = \'\';'.PHP_EOL;
        $config .= '$GLOBALS[\'uiDateFormat\'] = \'\';'.PHP_EOL;

        // session config
        $config .= '$GLOBALS[\'sessionExpireTime\'] = 60;'.PHP_EOL;

        // resource config
        $config .= '$GLOBALS[\'resourcePath\'] = \'files\';'.PHP_EOL;

        // cms info
        $config .= '$GLOBALS[\'cmsName\'] = \'coffee and websites\';'.PHP_EOL;
        $config .= '$GLOBALS[\'cmsVersion\'] = \'0.1\';'.PHP_EOL;
        $config .= '$GLOBALS[\'cmsLicese\'] = \'\';'.PHP_EOL;
        $config .= '$GLOBALS[\'cmsSecureLink\'] = true;'.PHP_EOL;
        $config .= '$GLOBALS[\'cmsMainDomain\'] = \''.DomainsModel::getDomainName().'\';'.PHP_EOL;
        
        // crypto configs
        $config .= '$GLOBALS[\'serverSecret\'] = \'';
        $config .= self::generateServerSecret();
        $config .= '\';'.PHP_EOL;
        
        $config .= '$GLOBALS[\'serverPublicKey\'] = \'\';'.PHP_EOL;
        $config .= '$GLOBALS[\'serverPrivateKey\'] = \'\';'.PHP_EOL;

        // shop config
        $config .= '$GLOBALS[\'currencySymbol\'] = \'&euro;\';'.PHP_EOL;
        $config .= '$GLOBALS[\'weightUnit\'] = \'kg\';'.PHP_EOL;
        $config .= '$GLOBALS[\'weightInGram\'] = \'1000\';'.PHP_EOL;
        
        $config .= "?>";

        // write config file
        file_put_contents("config.php",$config);
    }
    
    static function getCurrency () {
        return $GLOBALS['currencySymbol'];
    }

    static function getWeight () {
        return $GLOBALS['weightUnit'];
    }

    static function getQueryLog () {
        if (!isset($GLOBALS['queryLog'])) {
            return false;
        }
        return $GLOBALS['queryLog'];
    }
    
    static function getNoDatabase () {
        if (!isset($GLOBALS['noDatabase'])) {
            return true;
        }
        return $GLOBALS['noDatabase'];
    }
    
    static function getDBHost () {
        return $GLOBALS['dbHost'];
    }
    
    static function getDBUser () {
        return $GLOBALS['dbUser'];
    }
    
    static function getDBPassword () {
        return $GLOBALS['dbPass'];
    }
    
    static function getDBName () {
        return $GLOBALS['dbName'];
    }
    
    static function getShippingMode () {
        return $GLOBALS['shippingMode'];
    }
    
    static function getCmsMainDomain () {
        return $GLOBALS['cmsMainDomain'];
    }
    
    static function getSeoUrl () {
        if (isset($GLOBALS['seoUrl']) && $GLOBALS['seoUrl'] === true) {
            return true;
        }
        return false;
    }
    
    static function getPiwikUsername () {
        return $GLOBALS['piwikUsername'];
    }
    
    static function getPiwikPassword () {
        return $GLOBALS['piwikPassword'];
    }
    
    static function getAdminEmail () {
        return $GLOBALS['cmsAdminEmail'];
    }
}

abstract class DBObject {
    
    static $type_varchar;
    static $type_text;
    static $type_int;
    static $type_double;
    static $type_boolean;
    static $type_timestamp;
    static $type_date;
    
    abstract function getColumns ();
    
    function save () {
        
    }
    
    function delete () {
    }
}

class DB {
    
    static function open () {
        
        $dbLink = mysqli_connect(Config::getDBHost(),Config::getDBUser(),Config::getDBPassword());
        if (false !== $dbLink && true === mysqli_select_db($dbLink, Config::getDBName())) {
            $this->setDbLink($dbLink);
            $this->connected = true;
        } else {
            $this->connected = false;
            Context::addError("database::connect() : failed to connect : ".$this->getError());
        }
        return $this->connected;
    }
    
    static function close () {
        
        mysql_close();
    }
    
    static function get ($tableName, $params, $or=false) {
        $result = array();
        $condition = array();
        foreach ($params as $key => $value) {
            $condition []= " '".mysql_real_escape_string($key)."'='".mysql_real_escape_string($value)."' ";
        }
        $result = mysql_query("select * from $tableName ".implode($or ? " or " : " and ", $condition));
        if (($obj = mysql_fetch_object($result)) != null) {
            $result []= $obj;
        }
        return $result;
    }
    
    static function save ($tableName, $id,  $obj) {
        $id = mysql_real_escape_string($id);
        if ($id == null) {
            $names = array();
            $values = array();
            foreach (get_object_vars($obj) as $name) {
                $names []= $name;
                $values []= $obj->$name;
            }
            mysql_query("insert into $tableName (".implode(",",$names).") values (".implode(",",$values).")");
        } else {
            $params = array();
            foreach (get_object_vars($obj) as $name) {
                $params []= $name."=".$obj->$name;
            }
            mysql_query("update $tableName set ".implode(", ",$params)." where id = '$id'");
        }
    }
    
    static function delete ($tableName, $id) {
        
        $id = mysql_real_escape_string($id);
        $result = mysql_query("delete from $tableName where id = '$id'");
        return mysql_affected_rows($result) > 0;
    }
    
    static function all ($tableName) {
        
        $all = array();
        $result = mysql_query("select * from $tableName");
        while ($row = mysql_fetch_object($result) != null) {
            $all []= $row;
        }
        return $all;
    }
    
}

class Email {
    
    function sendMail ($to, $from, $subject, $message, $html=true) {
        
        $header  = "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/".($html ? "html" : "plain")."; charset=iso-8859-1\r\n";
        $header .= "From: $from\r\n";
        $header .= "Reply-To: $from\r\n";
        $header .= "X-Mailer: PHP ". phpversion();
        
        return mail($to,$subject,$message,$header);
    }
    
    function sendDefinedMessage ($to, $messageName, $params, $html=true) {
        
        $obj = DB::get("mails", array("name"=>$mailName));
        
        return self::sendMail($to, $obj->sender, $obj->subject, $obj->message, $html);
    }
}

class UserController {
    
    function getConfig () {
        return array(
            "name" => "user",
            "feilds" => array(
                array(
                    "name" => "firstname", 
                    "label" => "", 
                    "type" => "", 
                    "length" => "200", 
                    "" => "", 
                    "" => "", 
                ),array(
                    
                ),array(
                    
                )
            )
        );
    }
    
    function validate ($id, $username, $firstname, $lastname, $password, $email, $gender) {
        
        $validate = array();
        if (strlen($username) < 4) {
            $validate["username"] = "user name must be at least 4 characters!";
        } else if ($username > 100) {
            $validate["username"] = "user name must be shorter that 100 characters!";
        }
        if (strlen($firstName) < 1) {
            $validate["firstname"] = "First name cannot be empty!";
        }
        if (strlen($lastName) < 1) {
            $validate["lastname"] = "Last name cannot be empty!";
        }
        if ($password != null && strlen($password) < 6) {
            $validate["password"] = "Password must be at least 6 characters!";
        }
        if (preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9_.-]+\.[a-zA-Z]{2,7}$/D", $email) == 0) {
            $validate["email"] = "Not a valid email address!";
        }
        if ($gender != "0" && $gender != "1") {
            $validate["gender"] = "invalid value!";
        }
        if ($id == null) {
            $_email = Database::escape($email);
            $result = Database::queryAsObject("select 1 as emailexists from t_user where email = '$_email'");
            if ($result != null) {
                $validate["email"] = "Email already registered by another user!";
            }
            $_username = Database::escape($username);
            $result = Database::queryAsObject("select 1 as usernameexists from t_user where username = '$_username'");
            if ($result != null) {
                $validate["username"] = "Username already registered by another user!";
            }
        } else {
            $_id = Database::escape($id);
            $_email = Database::escape($email);
            $result = Database::queryAsObject("select 1 as emailexists from t_user where email = '$_email' and id != '$id'");
            if ($result != null) {
                $validate["email"] = "Email already registered by another user!";
            }
            $_username = Database::escape($username);
            $result = Database::queryAsObject("select 1 as usernameexists from t_user where username = '$_username' and id != '$id'");
            if ($result != null) {
                $validate["username"] = "Username already registered by another user!";
            }
        }
        return $validate;
    }
    
    function register () {
        
        $user;
        $user->username = Request::post("username");
        $user->firstName = Request::post("firstName");
        $user->lastName = Request::post("lastName");
        $user->birthDate = Request::post("birthDate");
        $user->telephone = Request::post("telephone");
        $user->homepage = Request::post("homepage");
        $user->password = Request::post("password");
        $user->agbs = Request::post("agbs");
        $user->email = Request::post("email");
        $user->gender = Request::post("gender");
        
        $validation = self::validate(null, $user->username, $user->firstname, $user->lastname, $user->password, $user->email, $user->gender);
        
        if ($user->agbs) {
            $validation["agbs"] = "You can only use the application if you accept the agbs AGBs";
        }
        
        if (count($validation) > 0) {
            return $validation;
        }
        
        $user->password = md5($user->password);
        
        return $user;
    }
    
    function delete ($publicId) {
        
        return DB::delete(self::getTableName(), "publicid = $publicId");
    }
    
    function login () {
        
        $username = Request::post("username");
        $password = Request::post("password");
        //$loginAttempts = Request::session("login.attempts");
        $password = md5($password);
        //if ($loginAttempts > Config::getMaxLoginAttempts()) {
        //    return array("Max login attempts!");
        //}
        //$loginAttempts++;
        $user = DB::get(self::getTableName(), array("username"=>$username,"password"=>$password), false);
        if ($user == null) {
            Request::session("loginAttempts", $loginAttempts);
            return array("Username or password invalid!");
        }
        return $user;
    }
    
    function logout () {
        
    }
}

class OfferController {
    
}

class OrderController {
    
    function confirm ($publicId) {
        Email::sendPrepairedMail("customer.order.confirm");
        $supplyer = DB::get("");
        Email::sendPrepairedMail("supplyer.order.confirm");
        
    }
    
    function decline ($publicId) {
        $publicId = DB::get("order",array());
        Email::sendPrepairedMail("customer.order.decline");
        
    }
}



class InstallView extends UIView {
    
    static $action_login = "login";
    static $action_saveDatabase = "saveDatabase";
    static $action_saveAdmin = "saveAdmin";
    static $action_saveTerms = "saveTerms";
    static $action_start = "start";
    
    function process () {
        
        RegisterView()::process();
        
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
        
        RegisterView()::render();
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
            RegisterView()::render();
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

class DenyView {
    
    function process () {
        
    }
    
    function view () {
        
        ?>
        <form method="post" action="<?php echo parent::link(RegisterView); ?>">
            <h1><?php echo Translations::get("authentication.title"); ?></h1>
            <p><?php echo Translations::get("authentication.description"); ?></p>
            <button type="submit"><?php echo Translations::get("authentication.register"); ?></button>
        </form>
        <?php
    }
}

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

class ShowOfferView extends UIView {
    
    
}

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

 



class Request {
    
    static $key_res = "res";
    static $key_view = "view";
    
    static function get ($name) {
        return isset($_GET[$name]) ? $_GET[$name] : null;
    }
    
    static function post ($name) {
        return isset($_POST[$name]) ? $_POST[$name] : null;
    }
    
    static function postMap () {
        return $_POST;
    }
    
    static function getResource () {
        return self::get(self::key_res);
    }
    
    static function getView () {
        $view = self::get(self::key_view);
        switch ($view) {
            case UI::view_login:
            default:
                return UI::view_login;
        }
    }
    
    static function start () {
        self::useSession();
    }
    
    static function getSessionKeysString () {
        return isset($_SESSION["session.started"]) ? $_SESSION["session.started"]."-".session_id() : "";
    }
    
    static function getSessionKeysArray () {
        return isset($_SESSION["session.started"]) ? array("k"=>$_SESSION["session.started"],session_name()=>session_id()) : array();
    }
    
    static function useSession () {
        
        $noError = true;
        $keysValid = true;
        $sessionValid = false;
        
        // get php session key param
        $sessionId = null;
        if (isset($_COOKIE["s"])) {
            $sessionId = $_COOKIE["s"];
        } else if (isset($_GET["s"])) {
            $sessionId = $_GET["s"];
        } else if (isset($_POST["s"])) {
            $sessionId = $_POST["s"];
        }
        
        // get session key param
        $sessionKey = null;
        if (isset($_COOKIE["k"])) {
            $sessionKey = $_COOKIE["k"];
        } else if (isset($_GET["k"])) {
            $sessionKey = $_GET["k"];
        } else if (isset($_POST["k"])) {
            $sessionKey = $_POST["k"];
        }
        
        // validate keys
        if (empty($sessionId)  || strlen($sessionId)  != 40 || 
            empty($sessionKey) || strlen($sessionKey) != 40) {
            
            // session keys are invalid
            $keysValid = false;
            $sessionValid = false;
            
        } else {

            // try starting session
            $sessionValid = Session::startSession("s",$sessionId);
            
            if ($sessionValid == true) {
                
                // start database session
                Database::getDataSource();
                
                // remove old sessions
                SessionModel::cleanOldSessions();
                
                // check if session valid
                $sessionValid = Session::isValid($sessionId,$sessionKey);
            }
            
            // if session invalid destroy session
            if ($sessionValid == false) {
                
                Session::endSession($sessionId);
            }
        }
        
        // if session is invalid create session
        if ($keysValid == false || $sessionValid == false) {
            
            // create session keys
            $sessionId = Session::generateSessionId();
            $sessionKey = Session::generateSessionKey();
            
            // start session
            Session::startSession("s", $sessionId);
            $_SESSION["session.started"] = $sessionKey;
	    
            // set session key
            setcookie("k",$sessionKey, 0, "/");
	    
            // start database session
            Database::getDataSource();
	    
            // remove old sessions
            SessionModel::cleanOldSessions();
                
            // start a clean session in the model
            Context::clear();
            SessionModel::startSession($sessionId, $sessionKey, $_SERVER['REMOTE_ADDR']);
            Context::addDefaultRoles();
        }
        
        // if user authcode log user in
        if (isset($_GET["userAuthKey"])) {
            
            UsersModel::loginWithKey($_GET["userAuthKey"]);
        }
    }
    
    static function setUserFromContext () {
        SessionModel::setSessionUser(session_id(), Context::getUserId());
    }
    
    static function clear () {
        Context::clear();
        Context::addDefaultRoles();
        SessionModel::endSession($_SESSION["session.started"]);
        SessionModel::cleanOldSessions();
    }
    
    static function generateSessionId () {
        return sha1(Common::randHash(64,false));
    }
    
    static function generateSessionKey () {
        return Common::randHash(40);
    }
    
    static function startSession ($sessionName,$sessionId) {
        // try starting the session
        session_name($sessionName);
        session_id($sessionId);
        return session_start();
    }

    static function startDefaultSession () {
        // try starting the session
        return session_start();
    }

    static function endSession ($sessionId) {
        // end php session
        session_unset();
        session_destroy();
        session_write_close();
        session_regenerate_id(true);
    }
    
    static function isValid ($sessionId, $sessionKey) {
        $valid = false;
        // check if session is valid
        if (!isset($_SESSION["session.started"]) || $_SESSION["session.started"] != $sessionKey) {
            // session key new or invalid
            $valid = false;
        } else {
	        // is session valid
            if (SessionModel::pollSession($sessionId,$sessionKey) == true) {
            	// valid
            	$valid = true;
            } else {
            	$valid = false;
            }
        }
        return $valid;
    }
}


