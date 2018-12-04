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
                if (Context::hasRole("process.edit")) {
                    parent::param("crawlPlacesInGeoname", $_POST["crawlPlacesInGeoname"]);
                    parent::param("crawlPlaces", $_POST["crawlPlaces"]);
                    parent::param("crawlGooglePlaces", $_POST["crawlGooglePlaces"]);
                    parent::param("crawlWikiPlaces", $_POST["crawlWikiPlaces"]);
                    parent::param("crawlPlacesInGooglePictures", $_POST["crawlPlacesInGooglePictures"]);
                    parent::param("crawlPlacesInGoogleNews", $_POST["crawlPlacesInGoogleNews"]);
                }
                parent::blur();
                parent::redirect();
                break;
            case "edit":
                if (Context::hasRole("process.edit")) {
                    parent::focus();
                }
                break;
          	case "collectGeodataPoll":
          		/*
          		$info = array();
          		
          		// collect continents
          		
          		$continents = CountriesModel::getContinents();
          		if (empty($continents)) {
          			$continentsCount = CountriesModel::updateContinentList();
          			$info["continents"] = $continentsCount;
          		} else {
          			
          			// get continents that need collecting
          			$targetContinent = null;
          			foreach ($continents as $id => $continent) {
          				if ($continent->collected == false) {
          					$targetContinent = $continent;
          				}
          			}
          		}
          			
      			if ($targetContinent == null) {
      			    $continentsCount = CountriesModel::updateContinentList();
      			    $info["continents"] = $continentsCount;
      			    
          				// collect countries
          				
          				$countries = CountriesModel::getCountries();
          				if (empty($continents)) {
          			    $continentsCount = CountriesModel::updateContinentList();
          			$info["continents"] = $continentsCount;
          		} else {
          			
          			// get countries that need collecting
          			$targetContinent = null;
          			foreach ($continents as $id => $continent) {
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
          		*/
          	case "getPlaceGeonameTasks":
          		
          		$info = array();
          		
          		$places = CountryModel::getPlacesThatNeedUpdating(10,parent::post("type"));
          		if (empty($places)) {
          			$info["status"] = "stop";
          		} else {
          			$info["status"] = "continue";
          			$info["geonameIds"] = $places;
          		}
          		
          		Context::setReturnValue(json_encode($info));
          		break;
          	
          	case "reportPlaceGeoname":
          		
          		$info = array();
          		
          		$geonameId = parent::get("geonameId");
          		$data = json_decode(parent::post("geodata"));
          		$type = parent::get("type");
          		
          		if (!empty($geonameId) && !empty($data)) {
          			
          			// save the data
          			//$rowsAffected = CountriesModel::updatePlace($type, $geonameId, $data);
          			$info["status"] = "continue";
          			$info["updated"] = $rowsAffected;
          			
          		} else {
          			$info["status"] = "error";
          		}
          		
          		Context::setReturnValue(json_encode($info));
          		break;
      		case "getPlaceNewsTask":
          		
          		$info = array();
          		
          		//$places = CountriesModel::getPlacesThatNeedNewsUpdating(10);
          		if (empty($places)) {
          			$info["status"] = "stop";
          		} else {
          			$info["status"] = "continue";
          			$info["places"] = $places;
          		}
          		
          		Context::setReturnValue(json_encode($info));
          		break;
  		    case "reportPlaceNews":
  		        
          		$info = array();
          		
          		$data = json_decode(parent::post("news"));
          		
          		if (!empty($data)) {
          			
          			$rowsAffected = 0;
          			
          			foreach ($data["responseData"]["results"] as $news) {
          			    // Sat, 04 Apr 2015 11:28:28 -0700
          			    // date_parse_from_format("D, d M Y H:i:s O", $news["publishedDate"]);
          			    $date = date_parse_from_format("D, d M Y H:i:s O", $news["publishedDate"]);
          			    //$dateStr = {$date[]}/{$date[]}/{$date[]} {$date[]}:{$date[]}:{$date[]}
          			    STR_TO_DATE('11:59:59', '%m/%d/%Y %h:%i:%s'); 
          			    
          			    NewsModel::createNews($news["content"], $news["unescapedUrl"], $news["titleNoFormatting"], $news["publisher"], $news["image"]["url"], $news["image"]["tbUrl"], $date);
          			    
          			    $rowsAffected++;
          			}
          			
          			$info["status"] = "continue";
          			$info["updated"] = $rowsAffected;
          			
          		} else {
          			$info["status"] = "error";
          		}
          		
          		Context::setReturnValue(json_encode($info));
  		        
  		        break;
          	case "getPlacePictureTasks"::
          	    break;
      	    case "reportPlacePicture":
      	        break;
      	    case "reportPlaceCompanies":
      	        
      	        $placeId = null; // google places id
      	        break;
      	    case "reportCompanies":
      	        
      	        break;
      	    case "sendAdvertEmails":
      	        /*
      	        $limit = 30;
      	        $productCode = parent::get("productCode");
      	        $product = ProductModel::getByCode($productCode);
      	        foreach (PersonModel::byRole("advert") as $persons => $person) {
      	            $formBuilder = FormBuilderModule::getAsHtml($_GET["form"]);
      	        }
      	        $companies = CompanyModel::getByCode($productCode, $limit);
      	        EmailTaskModel::set($productCode);
      	        break;
      	        */
          	case "getPlaceWikiTasks":
          	
          		$info = array();
          		
          		$places = CountryModel::getPlacesThatNeedWikiUpdating(10);
          		if (empty($places)) {
          			$info["status"] = "stop";
          		} else {
          			$info["status"] = "continue";
          			$info["places"] = $places;
          		}
          		
          		Context::setReturnValue(json_encode($info));
          		break;
          	case "reportPlaceWiki":
          		
          		$message = parent::post("message");
          		$url = parent::get("url");
          		$pinboardId = parent::get("pinboardId");

          		PinboardModel::createNote($message, $pinboardId, PinboardModel::$noteType_placeWiki, null, null);
          		
          		break;
          	case "getProcesses":
          	    
          	    $result = array("status"=>"none", "processes"=>array());
          	    
          	    
          	    // get places
          	    if (parent::param("crawlPlacesInGeoname")) {
          	        if (CountryModel::hasPlacesThatNeedUpdating()) {
          	            $result["processes"][] = array("name"=>"crawlPlaces", "url"=>parent::getResourcePath("js/crawlPlaces.js"));
          	        }
          	    }
          	    
          	    // get google place information
          	    if (parent::param("crawlPlacesInGooglePlaces")) {
          	        $result["processes"][] = array("name"=>"crawlGooglePlaces", "url"=>parent::getResourcePath("js/crawlGooglePlaces.js"));
          	    }
          	    
          	    // make wiki notes
          	    if (parent::param("crawlPlacesInWiki")) {
          	        $result["processes"][] = array("name"=>"crawlWikiPlaces", "url"=>parent::getResourcePath("js/crawlWikiPlaces.js"));
          	    }
          	    
          	    // make picture notes
          	    if (parent::param("crawlPlacesInGooglePictures")) {
          	        $result["processes"][] = array("name"=>"crawlGooglePicturePlaces", "url"=>parent::getResourcePath("js/crawlGooglePicturePlaces.js"));
          	    }

          	    // make news notes
          	    if (parent::param("crawlPlacesInGoogleNews")) {
          	        $result["processes"][] = array("name"=>"crawlGoogleNewsPlaces", "url"=>parent::getResourcePath("js/crawlGoogleNewsPlaces.js"));
          	    }
          	    
          	    if (count($result["processes"]) > 0) {
          	        $result["status"] = "tasks";
          	    }
          	    
          	    Context::setReturnValue(json_encode($result));
          	    
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
	    	
	    	<div class="processStatistics">
	    	    <table class="formTable"><tr>
	    	        <td><?php echo parent::getTranslation("process.statistic.places"); ?></td>
	    	        <td></td>
    	        </tr><tr>
	    	        <td><?php echo parent::getTranslation("process.statistic.pinboards"); ?></td>
	    	        <td></td>
    	        </tr><tr>
	    	        <td><?php echo parent::getTranslation("process.statistic.news"); ?></td>
	    	        <td></td>
    	        </tr><tr>
	    	        <td><?php echo parent::getTranslation("process.statistic.pictures"); ?></td>
	    	        <td></td>
    	        </tr><tr>
	    	        <td><?php echo parent::getTranslation("process.statistic.wikipedia"); ?></td>
	    	        <td></td>
    	        </tr><tr>
	    	        <td><?php echo parent::getTranslation("process.statistic.googlePlaces"); ?></td>
	    	        <td></td>
    	        </tr></table>
    	    </div>
	    	
	    	<div class="proocessItems">
	    	
    	    	<div class="processItem">
    		    	<div class="processEdit">
    		    		<a class="jquiButton" href="<?php echo parent::link(array("action"=>"geodata")); ?>"><?php echo parent::getTranslation("common.edit"); ?></a>
    		    	</div>
    		    	<h3><?php echo parent::getTranslation("process.collectGeodata.title"); ?></h3>
    		    	<p><?php echo parent::getTranslation("process.collectGeodata.description"); ?></p>
    	    	</div>
	    	
    	    	<div class="processItem">
    		    	<div class="processEdit">
    		    		<a class="jquiButton" href="<?php echo parent::link(array("action"=>"geodata")); ?>"><?php echo parent::getTranslation("common.edit"); ?></a>
    		    	</div>
    		    	<h3><?php echo parent::getTranslation("process.collectCompanies.title"); ?></h3>
    		    	<p><?php echo parent::getTranslation("process.collectCompanies.description"); ?></p>
    	    	</div>
	    	
    	    	<div class="processItem">
    		    	<div class="processEdit">
    		    		<a class="jquiButton" href="<?php echo parent::link(array("action"=>"geodata")); ?>"><?php echo parent::getTranslation("common.edit"); ?></a>
    		    	</div>
    		    	<h3><?php echo parent::getTranslation("process.sendAdvertEmails.title"); ?></h3>
    		    	<p><?php echo parent::getTranslation("process.sendAdvertEmails.description"); ?></p>
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