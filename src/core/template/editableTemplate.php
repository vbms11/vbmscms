<?php

require_once 'core/plugin.php';

class EditableTemplate extends XTemplate {
    
    public $templateParser;
    
    /**
     * 
     */
    function __construct() {
        $this->templateParser = new TemplateParser();
    }
    
    /**
     * 
     * @param String $html
     */
    function setData ($html) {
        $this->templateParser->setTemplate($html);
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
}

?>