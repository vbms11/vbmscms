<?php

require_once 'core/plugin.php';

class EditableTemplatePreview extends XTemplate {
    
    public $templateParser;
    
    /**
     * 
     */
    function __construct() {
        $this->templateParser = new TemplateParser();
    }
    
    /**
     * 
     * @param type $html
     * @return type
     */
    function setData ($html) {
        return $this->templateParser->setTemplate($html);
    }
    
    /**
     * returns the names of the areas defined by this template
     */
    function getAreas () {
        return $this->templateParser->getAreas();
    }

    /**
     * renders this template
     */
    function render () {
        $this->templateParser->render();
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
        return $this->templateParser->getStaticModules();
    }
    
    /**
     * 
     */
    function invokeRender() {
        
        ob_start();
        $this->render();
        $bodyHtml = ob_get_clean();
        
        echo '<?xml version="1.0" encoding="ISO-8859-1" ?>'.PHP_EOL;
        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">'.PHP_EOL;
        echo '<html xmlns="http://www.w3.org/1999/xhtml">'.PHP_EOL.'<head>'.PHP_EOL;
        $this->renderHtmlHeader();
        echo '</head>'.PHP_EOL.'<body>'.PHP_EOL;
        echo $bodyHtml;
        echo '</body>'.PHP_EOL.'</html>'.PHP_EOL;
    }
    
    function renderMainTemplateArea ($areaName, $pageId = null) {
        
    }
    
    function renderTemplateArea ($areaName, $pageId = null) {
        
    }
    
    function renderMenu ($areaName) {
        
    }
}

?>