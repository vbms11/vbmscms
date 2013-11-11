<?php

require_once 'core/plugin.php';

class TranslationsModule extends XModule {

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {
        
        if (Context::hasRole("translations.edit")) {
            
            switch (parent::getAction()) {
                case "update":
                    
                    $translations = parent::post("translations");
                    TranslationsModel::addTranslations($translations);
                    
                    break;
            }
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {
        
        switch (parent::getAction()) {
            default:
                if (Context::hasRole("translations.edit")) {
                    $this->printMainView();
                }
        }
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("translations.edit");
    }
    
    /**
     * 
     * @param type $pageId
     */
    function printMainView () {

        $translations = TranslationsModel::getTranslations();
        $languages = LanguagesModel::getLanguages();
        $keys = array_keys($translations[current($languages)]);
                
        ?>
        <div class="panel translationsPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"update")); ?>">
                <div class="alignRight">
                    <button type="submit"><?php echo parent::getTranslation("translations.button.save"); ?></button>
                    <button type="reset"><?php echo parent::getTranslation("translations.button.cancel"); ?></button>
                </div>
                <table class="formTable">
                <thead><tr>
                    <td>Code</td>
                    <td>Value</td>
                </tr></thead><tbody>
                    <?php
                    foreach ($keys as $key) {
                        $printKey = true;
                        foreach ($languages as $language) {
                            ?>
                            <tr><td>
                                <?php 
                                if ($printKey) {
                                    echo $key;
                                }
                                ?>
                            </td><td>
                                <?php
                                InputFeilds::printTextFeild("translations['".$language->name."']['".$key."']", $translations[$language->name][$key]);
                                ?>
                            </td></tr>
                            <?php
                            $printKey = false;
                        }
                    }
                    ?>
                </tbody></table>
                <div class="alignRight">
                    <button type="submit"><?php echo parent::getTranslation("translations.button.save"); ?></button>
                    <button type="reset"><?php echo parent::getTranslation("translations.button.cancel"); ?></button>
                </div>
            </form>
        </div>
        <script>
        $(".translationsPanel .alignRight button").each(function(index,object){
            $(object).button();
        });
        </script>
        <?php
    }
}

?>