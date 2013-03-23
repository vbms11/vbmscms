<?php

require_once 'core/plugin.php';

class EditableTemplate extends XTemplate {
    
    public $areas = null;
    public $parts = null;
    public $mainArea = null;
    
    function setData ($html) {
        // parse the template to find parts and areas
        $this->parts = array();
        $this->areas = array();
        $tAreas = array();
        $parts = explode("&lt;?cms", $html);
        $first = true;
        foreach ($parts as $partStart) {
            if ($first) {
                $first = false;
                $this->parts[] = $partStart;
                continue;
            }
            $subParts = explode("cms?&gt;", $partStart);
            $tAreas[] = trim($subParts[0]);
            $this->parts[] = $subParts[1];
        }
        // find areas
        foreach ($tAreas as $area) {
            $type = "";
            if (stripos($area, "template.main") === 0) {
                $type = "main";
            }
            if (stripos($area, "template.area") === 0) {
                $type = "area";
            }
            if (stripos($area, "template.menu") === 0) {
                $type = "menu";
            }
            $areaObj;
            $areaNamePos = strripos($area, ".")+1;
            if ($areaNamePos > 0 && !Common::isEmpty($type)) {
                $areaName = substr($area, $areaNamePos);
                $areaObj->name = $areaName;
                $areaObj->type = $type;
                $this->areas[] = $areaObj;
            }
            unset($areaObj);
        }
    }
    
    /**
     * returns the names of the areas defined by this template
     */
    function getAreas () {
        $retAreas = array();
        $len = count($this->areas);
        for ($i=0; $i<$len; $i++) {
            if ($this->areas[$i]->type === "main") {
                $retAreas[] = $this->areas[$i]->name;
            }
        }
        for ($i=0; $i<$len; $i++) {
            if ($this->areas[$i]->type === "area") {
                $retAreas[] = $this->areas[$i]->name;
            }
        }
        for ($i=0; $i<$len; $i++) {
            if ($this->areas[$i]->type === "menu") {
                $retAreas[] = $this->areas[$i]->name;
            }
        }
        return $retAreas;
    }

    /**
     * renders this template
     */
    function render () {
        $cntParts = count($this->parts);
        for ($i=0; $i<$cntParts; $i++) {
            echo $this->parts[$i];
            if ($i+1 < $cntParts) {
                $area = $this->areas[$i];
                // echo $area->name ." - ". $area->type." <br/> ";
                switch ($area->type) {
                    case "main":
                        parent::renderMainTemplateArea(Context::getPageId(), $area->name);
                        break;
                    case "area":
                        parent::renderTemplateArea(Context::getPageId(), $area->name);
                        break;
                    case "menu":
                        parent::renderMenu(Context::getPageId(), $area->name);
                        break;
                }
            }
        }
    }

    /**
     * returns script used by this template
     */
    function getScripts () {
        return array("template.js");
    }

    /**
     * returns styles used by this template
     */
    function getStyles () {
        return array("template.css");
    }
    
    /**
     * returns the codes of the static modules
     */
    function getStaticModules () {
        $staticModules = array();
        foreach ($this->areas as $area) {
            switch ($area->type) {
                case "menu":
                    $staticModules[] = $area->name;
            }
        }
        return $staticModules;
    }
}

?>