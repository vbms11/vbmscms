<?php

require_once('core/model/moduleModel.php');

class SearchResult {
    const type_page = 1;
    const type_module = 2;
    public $type;
    public $pageId;
    public $moduleId;
    public $params;
    public $text;
    public $title;
    function SearchResult ($pageId="", $text="", $title="") {
        $this->pageId = $pageId;
        $this->text = $text;
        $this->title = $title;
        $this->type = type_page;
    }
    static function pageResult ($pageId, $text, $title) {
        $var = new SearchResult();
        $var->pageId = $pageId;
        $var->text = $text;
        $var->title = $title;
        $var->type = self::type_page;
        return $var;
    }
    static function moduleResult ($moduleId, $params, $text, $title) {
        $var = new SearchResult();
        $var->moduleId = $moduleId;
        $var->params = $params;
        $var->text = $text;
        $var->title = $title;
        $var->type = self::type_module;
        return $var;
    }
    function getLink () {
        switch ($this->type) {
            case self::type_page:
                return NavigationModel::createPageLink($this->pageId);
            case self::type_module:
                return NavigationModel::createModuleLink($this->moduleId,$this->params);
            default:
                return NavigationModel::createPageLink($this->pageId);
        }
    }
}

class SearchModel {

    static function search ($text) {

        $searchText = trim($text);
        $searchResultsOut = array();
        if ($searchText != "") {

            $pageTypes = ModuleModel::getModules();
            foreach ($pageTypes as $pageType) {
                
                $moduleClass = ModuleModel::getModuleClass($pageType);
                $result = $moduleClass->search($searchText,Context::getLang());
                if (is_array($result)) {
                    $searchResultsOut = array_merge($searchResultsOut,$result);
                }
            }
        }
        
        return $searchResultsOut;
    }

    static function makeSearchSql ($searchText,$feildName) {
        $searchText = Database::escape(strtolower($searchText));
        $searchWords = explode(" ",$searchText);
        $sql = "";
        foreach ($searchWords as $searchWord) {
            if ($sql != "") {
                $sql .= " and ";
            }
            $regexp = "";
            for ($i=0; $i<strlen($searchWord); $i++) {
                $char = substr($searchWord, $i, 1);
                if (is_numeric($char)) {
                    $regexp .= "[".$char."]";
                } else {
                    $regexp .= "[".strtolower($char).strtoupper($char)."]";
                }
            }
            $sql .= "$feildName REGEXP '$regexp'";
        }
        return $sql;
    }

    static function cleanPreviewText ($text,$searchText) {

        $searchTextPadding = 250;

        $searchWords = explode(" ",$searchText);
        $text = strip_tags($text);
        $startIndex = -1;
        foreach ($searchWords as $searchWord) {
            $startIndex = strpos($text,$searchWord);
            if ($startIndex != -1)
                break;
        }

        $subStart;
        $subEnd;
        if ($startIndex - $searchTextPadding > -1) {
            $subStart = $startIndex - $searchTextPadding;
        } else {
            $subStart = 0;
        }

        if ($startIndex + $searchTextPadding >= strlen($text)) {
            $subEnd = strlen($text);
        } else {
            $subEnd = $startIndex + $searchTextPadding;
        }

        $text = substr($text, $subStart, $subEnd - $subStart);
        
        foreach ($searchWords as $searchWord) {
            $text = str_replace(strtolower($searchWord), "<b>".strtolower($searchWord)."</b>", $text);
            $text = str_replace(strtoupper($searchWord), "<b>".strtoupper($searchWord)."</b>", $text);
        }

        return $text;
    }
}


?>