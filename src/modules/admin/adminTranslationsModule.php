<?php

require_once 'core/plugin.php';

class AdminTranslationsModule extends XModule {

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {
        
        if (Context::hasRole("translations.edit")) {
            
            switch (parent::getAction()) {
                case "update":
                    
                    $translations = parent::post("translations");
                    if (!empty($translations)) {
                        TranslationsModel::addTranslations($translations);
                    }
                    
                    parent::redirect();
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
                    $this->printMainTabsView();
                }
        }
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("translations.edit");
    }
    
    function printMainTabsView () {
        ?>
        <div id="translationsTabs">
            <ul>
                <li><a href="#editTranslations"><?php echo parent::getTranslation("translations.tab.edit"); ?></a></li>
            </ul>
            <div id="editTranslations">
            <?php
            $this->printMainView();
            ?>
            </div>
        </div>
        <script>
        $("#translationsTabs").tabs();
        </script>
        <?php
    }
    
    /**
     * 
     * @param type $pageId
     */
    function printMainView () {

        $translations = TranslationsModel::getTranslations();
        $languages = LanguagesModel::getActiveLanguages();
        $defaultLanguageName = current($languages)->code;
        $keys = array_keys($translations[$defaultLanguageName]);
                
        ?>
        <div class="panel translationsPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"update")); ?>">
                <div class="alignRight">
                    <button type="submit"><?php echo parent::getTranslation("translations.button.save"); ?></button>
                    <button type="reset"><?php echo parent::getTranslation("translations.button.cancel"); ?></button>
                </div>
                <hr/>
                <table class="formTable">
                <thead><tr>
                    <td><?php echo parent::getTranslation("translations.table.code"); ?></td>
                    <td><?php echo parent::getTranslation("translations.table.value"); ?></td>
                    <td class="contract"><?php echo parent::getTranslation("translations.table.language"); ?></td>
                </tr></thead><tbody>
                    <?php
                    foreach ($keys as $key) {
                        $printKey = true;
                        foreach ($languages as $language) {
                            $languageCode = $language->code;
                            ?>
                            <tr><td>
                                <?php 
                                if ($printKey) {
                                    echo $key;
                                }
                                ?>
                            </td><td>
                                <?php
                                $translation = "";
                                if (isset($translations[$languageCode]) && isset($translations[$languageCode][$key])) {
                                    $translation = $translations[$languageCode][$key];
                                }
                                InputFeilds::printTextFeild("translations[".$languageCode."][".$key."]", $translation);
                                ?>
                            </td><td>
                                <?php
                                echo $language->name;
                                ?>
                            </td></tr>
                            <?php
                            $printKey = false;
                        }
                    }
                    ?>
                </tbody></table>
                <hr/>
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