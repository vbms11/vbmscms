<?php

/*
 * ie:
 * 
 * template.area.left
 * template.main.center
 * template.menu.top
 * template.module.static.wysiwyg.banner
 * $config.currencySign
 * $context.request.abc = $_REQUEST['abc']
 * $object->attribute;
 * 
 * //TODO
 * render xobject display types
 * object.list
 * object.display
 * object.search
 * object.edit


render module 
template.module.scope.moduleSysName.instanceName

example:
template.module.static.wysiwyg.banner
template.module.static.wysiwyg.banner
 



 */

class TemplateParser {
    
    // parsed template parts
    public $areas = null;
    public $parts = null;
    public $mainArea = null;
    public $objects = array();
    public $staticModules = array();
    
    /**
     * 
     * @param String $name
     */
    function renderValue ($name) {
        $valid = (preg_match("[a-z0-9\.\-\>]", $name) === 1);
        if ($valid) {
            
            $parseTokens = false;
            
            // parse tokens = true parses tokens manualy anddose not use eval
            if ($parseTokens) {
                $parseValue = true;
                $currentPos = 0;
                $currentObject = null;
                while ($parseValue) {
                    $pos = strpos($name,array(".","->"));
                    $tokenName = substr($name, $currentPos, $pos - $currentPos);
                    $currentPos = $pos;
                    if ($currentObject == null) {
                        $currentObject = $this->objects[$name];
                    } else {
                        // method, array or object
                        $lastChar = substr($tokenName, strlen($tokenName) - 1, 1);
                        if ($lastChar == ")") {
                            $theObject = $currentObject->__call($tokenName);
                        } else if ($lastChar == "]") {
                            // $theObject = $currentObject[];
                        } else {
                            $theObjectsVars = get_object_vars($currentObject);
                            if (isset($theObjectsVars[$tokenName])) {
                                $theObject = $currentObject->__get($tokenName);
                            } else {
                                return;
                            }
                        }
                    }
                }
            } else {
                
                // validate that the first object is in the object list
                $pos = strpos(array(".","->"), $name);
                if ($pos > 0) {
                    $tokenName = substr($name, 1, $pos - 1);
                } else {
                    $tokenName = substr($name, 1);
                }
                if (isset($this->objects[$tokenName])) {
                    echo eval("return $name;");
                } else {
                    Log::error("object not found: $tokenName in value $name");
                }
            }
        }
    }
    
    /**
     * 
     * @param String $html
     */
    function setTemplate ($html) {
        // parse the template to find parts and areas
        $this->parts = array();
        $this->areas = array();
        $this->staticModules = array();
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
        // handel tags in template
        foreach ($tAreas as $area) {
            $areaObj = new stdClass();
            if (stripos($area, "template.main.") === 0) {
                $areaObj->type = "main";
                $areaObj->name = substr($area, 14);
                $areaObj->scope = "instance";
                $areaObj->hasArea = true;
            }
            if (stripos($area, "template.area.") === 0) {
                $areaObj->type = "area";
                $areaObj->name = substr($area, 14);
                $areaObj->scope = "instance";
                $areaObj->hasArea = true;
            }
            if (stripos($area, "template.menu.") === 0) {
                $areaObj->type = "menu";
                $areaObj->name = substr($area, 14);
                $areaObj->scope = "static";
                $areaObj->moduleType = "menu";
            }
            if (stripos($area, "$") === 0) {
                $areaObj->type = "value";
                $areaObj->name = substr($area, 1);
                $areaObj->scope = "output";
            }
            if (stripos($area, "object") === 0) {
                $areaObj->type = "object";
                $areaObj->name = substr($area, 7);
                $areaObj->scope = "output";
            }
            if (stripos($area, "template.module.") === 0) {
                $areaObj->type = "module";
                $areaObj->name = substr($area, 16);
                $parts = explode(".", $areaObj->name);
                $areaObj->scope = $parts[0];
                $areaObj->moduleType = $parts[1];
                $areaObj->name = $parts[2];
            }
            if (isset($areaObj->type)) {
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
            if ($this->areas[$i]->type !== "main" && isset($this->areas[$i]->hasArea) && $this->areas[$i]->hasArea == true) {
                $retAreas[] = $this->areas[$i]->name;
            }
        }
        return $retAreas;
    }
    
    /**
     * handels a module tag in the template
     * @param Object $module
     */
    function renderModule ($module) {
        switch ($module->scope) {
            case "static":
                Context::getRenderer()->renderStaticModule($module->moduleType, $module->name, null, true);
                break;
            case "instance":
            default;
                Context::getRenderer()->renderInstanceModule($module->moduleType, $module->name, null, true);
                break;
        }
    }
    
    /**
     * replaces the placeholders in the template return the result
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
                        Context::getRenderer()->renderMainTemplateArea($area->name, Context::getPageId());
                        break;
                    case "area":
                        Context::getRenderer()->renderTemplateArea($area->name, Context::getPageId());
                        break;
                    case "menu":
                        Context::getRenderer()->renderMenu($area->name);
                        break;
                    case "value":
                        $this->renderValue($area->name);
                        break;
                    case "module":
                        $this->renderModule($area);
                        break;
                }
            }
        }
    }
    
    /**
     * returns the codes of the static modules
     */
    function getStaticModules () {
        if (empty($this->staticModules)) {
            $this->staticModules = array();
            foreach ($this->areas as $area) {
                switch ($area->type) {
                    case "value":
                    case "object":
                    case "area":
                    case "main":
                        break;
                    case "module":
                        if ($area->scope != "static") {
                            break;
                        }
                        $this->staticModules[] = array(
                            "name" => $area->name,
                            "type" => $area->moduleType
                        );
                        break;
                    case "menu":
                    default:
                        $this->staticModules[] = array(
                            "name" => $area->name,
                            "type" => $area->type
                        );
                }
            }
        }
        return $this->staticModules;
    }
    
    /**
     * returns name value array of objects
     */
    function getObjects () {
        $this->objects;
    }
    
    /**
     * adds an object to get values from
     * @param String $name
     * @param String $value
     */
    function addObject ($name, $value) {
        $this->objects[$name] = $value;
    }
}

?>