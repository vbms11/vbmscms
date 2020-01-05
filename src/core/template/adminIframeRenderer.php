<?php

require_once 'core/plugin.php';

class AdminIframeRenderer extends XTemplate {
    
    /**
     * returns the names of the areas defined by this template
     */
    function getAreas () {
        return array("center");
    }

    /**
     * renders this template
     */
    function render () {
      	
    	$href = NavigationModel::getSitePath()."/".NavigationModel::createPageLink(Context::getPage()->id);
    	$adminPageId = Context::getPageId();
    	?>
    	<div class="ui-widget-header adminHeaderDiv">
            <div class="adminHeaderModesDiv">
                <div class="ui-widget-header <?php echo !Context::isAdminMode() ? "ui-state-hover" : ""; ?> adminHeaderModeDiv">
                    <a href="<?php echo NavigationModel::createPageLink($adminPageId,array("setAdminMode"=>"0")); ?>">
                        <?php echo parent::getTranslation("admin.template.header.view"); ?>
                    </a>
                </div>
                <div class="ui-widget-header <?php echo Context::isAdminMode() ? "ui-state-hover" : ""; ?> adminHeaderModeDiv">
                    <a href="<?php echo NavigationModel::createStaticPageLink("adminPages", array("action"=>"editPage","setAdminMode"=>"adminPages","adminPageId"=>$adminPageId)); ?>">
                        <?php echo parent::getTranslation("admin.template.header.edit"); ?>
                    </a>
                </div>
            </div>
            <div class="adminHeaderLeftDiv">
                
                <a id="addContent">
                    <?php echo parent::getTranslation("admin.template.header.addContent"); ?>
                </a>
            </div>
        </div>
    	<div class="adminContentDiv">
            <iframe id="adminIframe" class="adminIframe" src="<?php echo $href; ?>" />
    	</div>
    	<?php
    }
	
    function getTemplate () {
    	return $this;
    }
    
    /**
     * returns script used by this template
     */
    function getScripts () {
        return array("/core/template/js/admin.js");
    }
    
    /**
     * @return string
     */
    static function getAdminStyle () {
        return "core/template/css/admin.css";
    }
    
    /**
     * returns styles used by this template
     */
    function getStyles () {
        return array("/".self::getAdminStyle());
    }
    
    /**
     * returns the codes of the static modules
     */
    function getStaticModules () {
    	return array();
    }
}

?>