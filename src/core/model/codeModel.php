<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of codeModel
 *
 * @author vbms
 */
class CodeModel {

    static public $codes = array();
    static public $translations = array();
    
    static function getNextCodeId () {
        $result = Database::queryAsObject("select max(code) as max from t_code");
        return $result->max + 1;
    }

    static function deleteCode ($code) {
        $code = Database::escape($code);
        Database::query("delete from t_code where code = '$code'");
    }

    static function createCode ($lang,$value) {
        $lang = Database::escape($lang);
        $value = Database::escape($value);
        $code = CodeModel::getNextCodeId();
        $result = Database::query("insert into t_code(code,value,lang) values('$code','$value','$lang')");
        CodeModel::setCachedCode($code, $lang, $value);
        return $code;
    }

    static function addToCode ($code,$lang,$value) {
        $lang = Database::escape($lang);
        $value = Database::escape($value);
        $code = Database::escape($code);
        Database::query("insert into t_code(code,value,lang) values('$code','$value','$lang')");
        CodeModel::setCachedCode($code, $lang, $value);
        return $code;
    }

    static function updateCode ($code, $lang, $value) {
        $lang = Database::escape($lang);
        $value = Database::escape($value);
        $code = Database::escape($code);
        Database::query("update t_code set value = '$value' where code = '$code' and lang = '$lang'");
        CodeModel::setCachedCode($code, $lang, $value);
    }

    static function setCode ($code, $lang, $value) {
        if (CodeModel::doseCodeExist($code,$lang) == null) {
            CodeModel::addToCode($code, $lang, $value);
        } else {
            CodeModel::updateCode($code, $lang, $value);
        }
    }

    static function doseCodeExist ($code,$lang) {
        if (CodeModel::getCachedCode($code, $lang) != null)
            return true;
        $lang = Database::escape($lang);
        $code = Database::escape($code);
        $result = Database::queryAsObject("select 1 as res from t_code where code = '$code' and lang = '$lang'");
        if ($result != null && $result->res == "1") {
            return true;
        }
        return false;
    }

    static function getCode ($code,$lang) {
        $val = CodeModel::getCachedCode($code,$lang);
        if ($val != null)
            return $val;
        $lang = Database::escape($lang);
        $code = Database::escape($code);
        $obj = Database::queryAsObject("select value from t_code where code = '$code' and lang = '$lang'");
        if ($obj != null)
            $val = $obj->value;
        CodeModel::setCachedCode($code,$lang,$val);
        return $val;
    }
    
    static function getCachedCode ($code,$lang) {
        if (isset(CodeModel::$codes[$lang]) && isset(CodeModel::$codes[$lang][$code]))
            return CodeModel::$codes[$lang][$code];
        return null;
    }
    
    static function setCachedCode ($code,$lang,$value) {
        if (!isset(CodeModel::$codes[$lang])) 
            CodeModel::$codes[$lang] = array();
        CodeModel::$codes[$lang][$code] = $value;
    }
    
    // translations
    
    static function addTranslation ($key,$lang,$value) {
        //if (isset(CodeModel::$keys[$key]))
    }
    
    static function getTranslation ($key,$lang=null) {
        if ($lang == null) {
            $lang = Context::getLang();
        }
        $lang = Database::escape($lang);
        $strKey = "";
        $isFirst = true;
        if (is_array($key)) {
            foreach ($key as $k) {
                if ($isFirst == true) {
                    
                    $isFirst = false;
                } else {
                    $strKey .= ",";
                }
                $strKey .= "'$k'";
            }
        } else {
            $strKey .= "'$key'";
        }
        $objAr = Database::queryAsArray("select c.value, ck.key from t_code_key ck join t_code on ck.code = c.code and c.lang = '$lang' where ck.key in ($strKey)");
    }
    
    static function getTranslations ($lang) {
        
    }
    
    static function saveTranslations () {
        
    }
}

?>