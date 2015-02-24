<?php

require_once('core/plugin.php');

class ProcessModule extends XModule {
    
    const modeCurrentUser = 1;
    const modeSelectedUser = 2;

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {
        switch (parent::getAction()) {
            case "save":
                if (Context::hasRole("user.profile.edit")) {
                    parent::param("mode",$_POST["mode"]);
                }
                parent::blur();
                parent::redirect();
                break;
            case "edit":
                if (Context::hasRole("user.profile.edit")) {
                    parent::focus();
                }
                break;
          	case "collectGeodataPoll":
          		
          		$info = array();
          		
          		// collect continents
          		
          		$continents = CountriesModel::getContinents();
          		if (empty($continents)) {
          			$continentsCount = CountriesModel::updateContinentList();
          			$info["continents"] = $continentsCount;
          		} else {
          			
          			// get continents that need collecting
          			$targetContinent = null;
          			foreach ($continents => $continent) {
          				if ($continent->collected == false) {
          					$targetContinent = $continent;
          				}
          			}
          			
          			if ($targetContinent != null) {
          				
          				// collect countries
          				
          				$countries = CountriesModel::getCountries();
          				if (empty($continents)) {
          			$continentsCount = CountriesModel::updateContinentList();
          			$info["continents"] = $continentsCount;
          		} else {
          			
          			// get countries that need collecting
          			$targetContinent = null;
          			foreach ($continents => $continent) {
          				if ($continent->collected == false) {
          					$targetContinent = $continent;
          				}
          			}
          			
          			if ($targetContinent != null) {
          				
          				// collect 
          				
          				
          				
          				// if none left to collect set collected to 1
          			}
          		}
          		
          		Context::setReturnValue(json_encode($info));
          		
          		// do we have continents
          		// countries
          		// states
          		// regions
          		
          		break;
          		
          	case "getGeonameIds":
          		
          		$info = array();
          		
          		$places = CountriesModel::getPlacesThatNeedUpdating(10,parent::post("type"));
          		if (empty($places)) {
          			$info["status"] = "stop";
          		} else {
          			$info["status"] = "continue";
          			$info["geonameIds"] = $places;
          		}
          		
          		Context::setReturnValue(json_encode($info));
          		break;
          	
          	case "reportGeodata":
          		
          		$info = array();
          		
          		$geonameId = parent::get("geonameId");
          		$data = json_decode(parent::post("geodata"));
          		$type = parent::get("type");
          		
          		if (!empty($geonameId) && !empty($data)) {
          			
          			// save the data
          			$rowsAffected = CountriesModel::updatePlace($type, $geonameId, $data);
          			$info["status"] = "continue";
          			$info["updated"] = $rowsAffected;
          			
          		} else {
          			$info["status"] = "error";
          		}
          		
          		Context::setReturnValue(json_encode($info));
          		break;
          	
          	case "wikiNote":
          		
          		$message = parent::post("message");
          		$url = parent::get("url");
          		
          		PinboardModel::createNote();
          		
          		break;
          	
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {

        switch (parent::getAction()) {
            case "edit":
                if (Context::hasRole("user.profile.edit")) {
                    $this->printEditView();
                }
                break;
            default:
                if (Context::hasRole("user.profile.view")) {
					$this->printMainView();
                }
                break;
        }
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("user.profile.edit","user.profile.view","user.profile.owner","user.profile.privateDetails");
    }
    
    function getStyles () {
    	return array("css/process.css");
    }
    
    function printEditView () {
        ?>
        <div class="panel userInfoEditPanel">
            <form action="<?php echo parent::link(array("action"=>"save")); ?>" method="post">
                <table class="formTable"><tr><td>
                    <?php echo parent::getTranslation("users.profile.edit.mode"); ?>
                </td><td>
                    <?php InputFeilds::printSelect("mode", parent::param("mode"), array(self::modeCurrentUser => parent::getTranslation("common.user.current"), self::modeSelectedUser => parent::getTranslation("common.user.selected"))); ?>
                </td></tr>
                </table>
                <hr/>
                <div class="alignRight">
                    <button type="submit" class="jquiButton"><?php echo parent::getTranslation("common.save"); ?></button>
                </div>
            </form>
        </div>
        <?php
    }
	
    function printMainView () {
    	
    	$userId = $this->getModeUserId();
    	
    	?>
    	<div class="panel processPanel">
	    	
	    	<h1><?php echo parent::getTranslation("process.title"); ?></h1>
	    	<p><?php echo parent::getTranslation("process.description"); ?></p>
	    	
	    	<div class="processItem">
		    	<div class="processEdit">
		    		<a class="jquiButton" href="<?php echo parent::link(array("action"=>"geodata")); ?>"><?php echo parent::getTranslation("common.edit"); ?></a>
		    	</div>
		    	<h3><?php echo parent::getTranslation("process.collectGeodata.title"); ?></h3>
		    	<p><?php echo parent::getTranslation("process.collectGeodata.description"); ?></p>
	    	</div>
	    	
	    	<div class="processItem">
		    	<div class="processEdit">
		    		<a class="jquiButton" href="<?php echo parent::link(array("action"=>"createPinboards")); ?>"><?php echo parent::getTranslation("common.edit"); ?></a>
		    	</div>
		    	<h3><?php echo parent::getTranslation("process.createPinboards.title"); ?></h3>
		    	<p><?php echo parent::getTranslation("process.createPinboards.description"); ?></p>
	    	</div>
	    	
	    	<div class="processItem">
	    		<div class="processEdit">
	    			<a class="jquiButton" href="<?php echo parent::staticLink("userInfo",array("action"=>"editInfo", "userId"=>$userId)); ?>"><?php echo parent::getTranslation("common.edit"); ?></a>
	    		</div>
	    		<h3><?php echo parent::getTranslation("process.createWikiNotes.title"); ?></h3>
		    	<p><?php echo parent::getTranslation("process.userInfo.description"); ?></p>
	    	</div>
	    	
	    	
    	</div>
    	<?php
    }
    
    function printCollectGeodataView () {
    	
    	?>
    	<div class="panel collectGeodataPanel">
    		<div class="controls">
    			<button class="start">Start</button>
    			<button class="stop">Stop</button>
    		</div>
    		<div> class="info">
    			<div class="stoppedInfo">
    				<h3>Not Started<h3>
    				<p>not started, click start then info will be shown here!</p>
    			</div>
    			<div class="startedInfo">
    				<table><tr><td>
    				
    				</td></tr></table>
    			</div>
    		</div>
    	</div>
    	<script>
    	function crawl () {
    		$.getJSON("<?php echo parent::ajaxLink(array("action"=>"collectGeodataPoll")); ?>", function (data) {
    			// update info
    		});
    	}
    	function startCrawling() {
    		window.setInterval(5,crawl,this);
    	}
    	$(".collectGeodataPanel .start").click(function (){
    		startCrawling();
    	});
    	$(".collectGeodataPanel .stop").click(function (){
    		startCrawling();
    	});
    	</script>
    	<?php
    }
}

?>