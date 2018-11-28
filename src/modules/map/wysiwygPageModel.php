<?php

require_once('core/model/searchModel.php');

class WysiwygPageModel {

    static function search ($searchText,$lang) {
        $searchSql = SearchModel::makeSearchSql($searchText, "content");
        $result = Database::queryAsArray("select id, moduleid, content from t_wysiwygpage where $searchSql and lang='$lang'");
        $obj = stdClass;
        $results = array();
        foreach ($result as $obj) {
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
        $moduleId = Database::escape($moduleId);
        $language = Database::escape($language);
        $result = Database::queryAsObject("select id, content from t_wysiwygpage where moduleid='$moduleId' and lang='$language'");
        if (empty($result)) {
            WysiwygPageModel::createWysiwygPage($moduleId,$language,"");
            return WysiwygPageModel::getWysiwygPage($moduleId,$language);
        }
        return $result;
    }

    static function updateWysiwygPage ($moduleId, $language, $content) {
        $moduleId = Database::escape($moduleId);
        $language = Database::escape($language);
        $content = Database::escape($content);
        Database::query("update t_wysiwygpage set content = '$content' where moduleid = '$moduleId' and lang = '$language'");
    }

    static function createWysiwygPage ($moduleId, $language, $content) {
        $moduleId = Database::escape($moduleId);
 	$language = Database::escape($language);
 	$content = Database::escape($content);
 	Database::query("insert into t_wysiwygpage(moduleid,lang,content) values('$moduleId', '$language', '$content')");
    }

    static function deleteWysiwygPage ($moduleId) {
        $moduleId = Database::escape($moduleId);
        Database::query("delete from t_wysiwygpage where moduleid = '$moduleId'");
    }
    
}

?>