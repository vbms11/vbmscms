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
			<div class="adminHeaderLogoDiv"></div>
		</div>
    	<div class="adminContentDiv">
    		<iframe class="adminIframe" src="<?php echo $href; ?>" />
    	</div>
    	<script type="text/javascript">
		// register event handeler
		window.addEventListener('message', function (m) {
			if (m.action == "close") {
				document.location.href = $(".adminIframe")[0].location.href;
			}
		}, false);
    	</script>
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