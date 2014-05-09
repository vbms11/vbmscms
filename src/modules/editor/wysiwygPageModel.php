<?php

require_once('core/model/searchModel.php');

class WysiwygPageModel {

    static function search ($searchText,$lang) {
        $searchSql = SearchModel::makeSearchSql($searchText, "content");
        $result = Database::query("select id, moduleid, content from t_wysiwygpage where $searchSql and lang='$lang'");
        $obj;
        $results = array();
        while (($obj = mysql_fetch_object($result)) != null) {
            $pageId = PagesModel::getPageIdFromModuleId($obj->moduleid);
            $content = SearchModel::cleanPreviewText($obj->content,$searchText);
            $title = PagesModel::getPageNameInMenu($pageId,$lang);
            if ($pageId == null || $title == null)
                continue;
            // @EDIT ME: filter css results | quick and dirty fix!
            if (!preg_match('/\{/', $content)) {
                $results[] = new SearchResult($pageId,$content,$title);
            }
        }
        return $results;
    }

    static function getWysiwygPage ($moduleId, $language) {
        $moduleId = mysql_real_escape_string($moduleId);
        $language = mysql_real_escape_string($language);
        $result = Database::queryAsObject("select id, content from t_wysiwygpage where moduleid='$moduleId' and lang='$language'");
        if (empty($result)) {
            WysiwygPageModel::createWysiwygPage($moduleId,$language,"");
            return WysiwygPageModel::getWysiwygPage($moduleId,$language);
        }
        return $result;
    }

    static function updateWysiwygPage ($moduleId, $language, $content) {
        $moduleId = mysql_real_escape_string($moduleId);
        $language = mysql_real_escape_string($language);
        $content = mysql_real_escape_string($content);
        Database::query("update t_wysiwygpage set content = '$content' where moduleid = '$moduleId' and lang = '$language'");
    }

    static function createWysiwygPage ($moduleId, $language, $content) {
        $moduleId = mysql_real_escape_string($moduleId);
 	$language = mysql_real_escape_string($language);
 	$content = mysql_real_escape_string($content);
 	Database::query("insert into t_wysiwygpage(moduleid,lang,content) values('$moduleId', '$language', '$content')");
    }

    static function deleteWysiwygPage ($moduleId) {
        $moduleId = mysql_real_escape_string($moduleId);
        Database::query("delete from t_wysiwygpage where moduleid = '$moduleId'");
    }
    
}

?>