<?php

/*
 * ie:
 * 
 * template.area.left
 * template.main.center
 * template.menu.top
 * template.wysiwyg.banner
 * config.currencySign
 * context.request.abc = $_REQUEST['abc']
 * 
 * $object->attribute;
 */

class PlaceholderReplacer {
    
    // parsed template parts
    public $areas = null;
    public $parts = null;
    public $mainArea = null;
    // 
    public $objects = array();
    
    function renderValue ($name) {
        $valid = (preg_match("[a-z0-9\.\-\>]", $name) === 1);
        if ($valid) {
            $parseValue = true;
            $theObject = $this->objects[$name];
            while ($parseValue) {
                $nextToken = strpos($name, array("->","."));
                $theObjectsVars = get_object_vars($theObject);
            }
        }
        echo eval($name);
    }
    
    function setTemplate ($html) {
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
            $type = null;
            $offset = "";
            if (stripos($area, "template.main") === 0) {
                $type = "main";
                $offset = 14;
            }
            if (stripos($area, "template.area") === 0) {
                $type = "area";
                $offset = 14;
            }
            if (stripos($area, "$") === 0) {
                $type = "value";
                $offset = 1;
            }
            if (stripos($area, "object") === 0) {
                $type = "object";
                $offset = 7;
            }
            if (empty($type)) {
                $areaObj;
                $areaObj->name = substr($area, $offset);
                $areaObj->type = $type;
                $this->areas[] = $areaObj;
                unset($areaObj);
            }
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
            if ($this->areas[$i]->type !== "area") {
                $retAreas[] = $this->areas[$i]->name;
            }
        }
        return $retAreas;
    }
    
    /**
     * replaces the placeholders in the template
     * @return string 
     */
    function render () {
        $cntParts = count($this->parts);
        for ($i=0; $i<$cntParts; $i++) {
            echo $this->parts[$i];
            if ($i+1 < $cntParts) {
                $area = $this->areas[$i];
                switch ($area->type) {
                    case "main":
                        Context::getRenderer()->renderMainTemplateArea(Context::getPageId(), $area->name);
                        break;
                    case "area":
                        Context::getRenderer()->renderTemplateArea(Context::getPageId(), $area->name);
                        break;
                    case "menu":
                        Context::getRenderer()->renderMenu(Context::getPageId(), $area->name);
                        break;
                    case "value":
                        $this->renderValue($area->name);
                        break;
                }
            }
        }
    }
    
    /**
     * returns the codes of the static modules
     */
    function getStaticModules () {
        $staticModules = array();
        foreach ($this->areas as $area) {
            switch ($area->type) {
                case "area":
                case "value":
                case "main":
                    break;
                case "menu":
                default:
                    $staticModules[] = array(
                        "name" => $area->name,
                        "type" => $area->type
                    );
            }
        }
        return $staticModules;
    }
    
    /**
     * returns name value array of objects
     */
    function getObjects () {
        $this->objects;
    }
    
    /**
     * adds an object to get values from
     * @param type $name
     * @param type $value
     */
    function addObject ($name, $value) {
        $this->objects[$name] = $value;
    }
}

?>