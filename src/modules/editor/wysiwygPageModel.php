<?php

require_once('core/model/searchModel.php');

class WysiwygPage {
    public $id;
    public $pageId;
    public $language;
    public $content;
    function WysiwygPage ($id,$pageId,$language,$content) {
        $this->id = $id;
        $this->pageId = $pageId;
        $this->language = $language;
        $this->content = $content;
    }
}

class WysiwygPageModel {

    static function search ($searchText,$lang) {
        $searchSql = SearchModel::makeSearchSql($searchText, "content");
        $result = Database::query("select id, pageid, content from t_wysiwygpage where $searchSql and lang='$lang'");
        $obj;
        $results = array();
        while (($obj = mysql_fetch_object($result)) != null) {
            $pageId = PagesModel::getPageIdFromIncludeId($obj->pageid);
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

    static function getWysiwygPage ($pageId, $language) {
        $pageId = mysql_real_escape_string($pageId);
        $language = mysql_real_escape_string($language);
        $result = Database::query("select id, content from t_wysiwygpage where pageid='$pageId' and lang='$language'");
        $row = mysql_fetch_array($result);
        if ($row == null || count($row) == 0) {
            WysiwygPageModel::createWysiwygPage($pageId,$language,"");
            return WysiwygPageModel::getWysiwygPage($pageId,$language);
        }
        return new WysiwygPage($row['id'],$pageId,$language,$row['content']);
    }

    static function updateWysiwygPage ($pageId, $language, $content) {
        $pageId = mysql_real_escape_string($pageId);
        $language = mysql_real_escape_string($language);
        $content = mysql_real_escape_string($content);
        Database::query("update t_wysiwygpage set content='$content' where pageid='$pageId' and lang='$language'");
    }

    static function createWysiwygPage ($pageId, $language, $content) {
        $pageId = mysql_real_escape_string($pageId);
 	$language = mysql_real_escape_string($language);
 	$content = mysql_real_escape_string($content);
 	Database::query("INSERT INTO t_wysiwygpage(pageid,lang,content) VALUES('$pageId','$language','$content')");
    }

    static function deleteWysiwygPage ($id) {
        $id = mysql_real_escape_string($id);
        Database::query("delete from t_wysiwygpage where id = $id;");
    }

    static function deleteWysiwygPageByPageId ($id) {
        $id = mysql_real_escape_string($id);
        Database::query("delete from t_wysiwygpage where pageid = $id;");
    }
}


?>
