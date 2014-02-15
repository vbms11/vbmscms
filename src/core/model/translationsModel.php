<?php

class TranslationsModel {

    private static $translationsFileName = "core/translations/translations.php";
    private static $translationsVarName = "ar_translations";
    private static $translations = null;
    private static $newTranslations = false;
    
    static function getTranslations () {
        
        if (empty(self::$translations)) {
            self::readTranslationsFile();
        }
        return self::$translations;
    }

    static function getTranslation ($code, $lang=null, $escape=true, $replace=null) {
        if ($lang == null) {
            $lang = Context::getLang();
        }
        $translations = self::getTranslations();
        $translation = $code;
        if (isset($translations[$lang]) && isset($translations[$lang][$code])) {
            //$translation = $translations[$lang][$code];
            $translation = base64_decode($translations[$lang][$code]);
        } else {
            self::addTranslations(array($lang => array($code => $code)));
        }
        if ($escape) {
            $translation = htmlentities($translation, ENT_QUOTES);
        }
        if (!empty($replace) && is_array($replace)) {
            foreach ($replace as $token => $value) {
                $translation = str_replace($token, $value, $translation);
            }
        }
        return $translation;
    }

    static function addTranslations ($translations) {
        
        $varObj = self::getTranslations();
        // add the translations
        foreach ($translations as $langCode => $translation) {
            if (!isset($varObj[$langCode])) {
                self::$newTranslations = true;
                $varObj[$langCode] = array();
            }
            foreach ($translation as $key => $value) {
                $escapedValue = $value;
                if (!isset($varObj[$langCode][$key]) || $escapedValue !== $varObj[$langCode][$key]) {
                    self::$newTranslations = true;
                    $varObj[$langCode][$key] = base64_encode($escapedValue);
                }
            }
        }

        self::$translations = $varObj;
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
    
    static function maintainTrnaslationsFile () {
        if (self::$newTranslations == true) {
            self::writeTranslationsFile();
        }
    }
    
    static function writeTranslationsFile () {
        
        // if file exists then delete old file
        if (is_file(self::$translationsFileName)) {
            unlink(self::$translationsFileName);
        }
        
        // get all translations codes
        $allTranslationCodes = array();
        if (count(self::$translations) > 0) {
            foreach (self::$translations as $langCode => $translations) {
                foreach ($translations as $key => $value) {
                    $allTranslationCodes[$key] = $key;
                }
            }
        }
        
        // build content of the file
        $ar_langs = array();
        if (count(self::$translations) > 0) {
            foreach (self::$translations as $langCode => $translations) {
                $content = "'".addslashes($langCode)."'=>array(".PHP_EOL;
                $ar_translations = array();
                if (count($translations) > 0) {
                    foreach ($allTranslationCodes as $key) {
                        $value = $key;
                        if (isset($translations[$key]) && !empty($translations[$key])) {
                            //$value = $translations[$key];
                            $value = $translations[$key];
                        }
                        $ar_translations[] = "'".addslashes($key)."'=>'".addslashes($value)."'".PHP_EOL;
                    }
                }
                $content .= implode(",", $ar_translations).")";
                $ar_langs[] = $content;
            }
        }
        
        // write file content
        $fileContent = "<?php ".PHP_EOL."$".self::$translationsVarName." = array(".PHP_EOL;
        $fileContent .= implode(",", $ar_langs);
        $fileContent .= "); ".PHP_EOL."?>";
        file_put_contents(self::$translationsFileName, $fileContent);
        
        // 
        self::$translations = null;
    }

}

?>