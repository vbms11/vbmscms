<?php

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

?>