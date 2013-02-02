<?php

class TranslationsModel {

    private static $translationsFileName = "core/translations/translations.php";
    private static $translationsVarName = "ar_translations";
    private static $translations = null;

    static function getVar () {
        if (is_array(self::$translations)) {
            return self::$translations;
        }
        self::readTranslationsFile();
        return self::getVar();
    }

    static function getTranslation ($code, $lang=null, $escape=true) {
        if ($lang == null) {
            $lang = Context::getLang();
        }
        $translations = self::getVar();
        $texts = isset($translations[$lang]) ? $translations[$lang] : null;
        $translation = ($texts != null && isset($texts[$code])) ? $texts[$code] : $code;
        if (!$escape) {
            $translation = html_entity_decode($translation, ENT_QUOTES);
        }
        return $translation;
    }

    static function addTranslations ($translations) {
        $newTranslations = false;
        $varObj = self::getVar();
        // add the translations
        foreach ($translations as $langCode => $translation) {
            if (!isset($varObj[$langCode])) {
                $newTranslations = true;
                $varObj[$langCode] = array();
            }
            foreach ($translation as $key => $value) {
                if (!isset($varObj[$langCode][$key])) {
                    $newTranslations = true;
                    $varObj[$langCode][$key] = Common::htmlEntities($value);
                }
            }
        }

        self::$translations = $varObj;
        if ($newTranslations == true) {
            self::writeTranslationsFile();
        }
    }

    static function readTranslationsFile () {
        if (!is_file(self::$translationsFileName)) {
            $var = self::$translationsVarName;
            $$var = array();
            self::writeTranslationsFile();
        }
        require_once(self::$translationsFileName);
        $varName = self::$translationsVarName;
        self::$translations = $$varName;
    }

    static function writeTranslationsFile () {
        // if file exists then delete old file
        if (is_file(self::$translationsFileName)) {
            unlink(self::$translationsFileName);
        }
        // build content of the file
        $fileContent = "<?php ".PHP_EOL."$".self::$translationsVarName." = array(".PHP_EOL;
        $ar_langs = array();
        if (count(self::$translations) > 0) {
            foreach (self::$translations as $langCode => $translations) {
                $content = "'".addslashes($langCode)."'=>array(".PHP_EOL;
                $ar_translations = array();
                if (count($translations) > 0) {
                    foreach ($translations as $key => $value) {
                        $ar_translations[] = "'".addslashes($key)."'=>'".addslashes($value)."'".PHP_EOL;
                    }
                }
                $content .= implode(",", $ar_translations).")";
                $ar_langs[] = $content;
            }
        }
        $fileContent .= implode(",", $ar_langs);
        $fileContent .= "); ".PHP_EOL."?>";
        file_put_contents(self::$translationsFileName, $fileContent);
    }

}

?>