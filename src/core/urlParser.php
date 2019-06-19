<?php

class UrlParser {
	
    $selectionSubDomain;
    $domain;
    $requestType;
    $language;
    $pageId;
    $moduleId;
    $code;
    $staticName;
	
	function parse () {
		
		// query = munich.example.test.com/de/n/mind-control/
		// query = munich.example.test.com/c/code/
		// query = munich.example.test.com/s/register/
		// query = munich.example.test.com/m/5/action/save/id/20/?key=value&foo
		// query = munich.example.test.com/p/5/
		// query = munich.example.test.com?c=code&foo=bar
		
		// get correct domain or sub domain
		$site = $this->parseDomainSite();
		$domain = $site->domain;
		
		// selection sub domain
		if ($domain !== $_SERVER["SERVER_NAME"]) {
			$subDomain = str_str($_SERVER["SERVER_NAME"], 0, (len($_SERVER["SERVER_NAME"]) - len($domain)) - 1)
			$this->parseSubDomainSelection($subDomain);
		}
		
		// has path
		
		$path = strstr($_SERVER["REQUEST_URI"], 0, stri($_SERVER["REQUEST_URI"],"?"));
		$pathParts = explode("/");
		$pathPartsCount = count($pathParts);
		$pathPartsPosition = 0;
		
		if ($pathPartsCount > 0) {
			
			// 	is first language
			$selectedLanguage = null;
			$siteLanguages = LanguagesModel::getSiteLanguages();
			for ($siteLanguages as $lang) {
				if ($lang->urlname === $pathParts[0]) {
					$selectedLanguage = $lang;
					$pathPartsPosition = 1;
					break;
				}
			}
			
			// get type
			if ($pathPartsPosition < $pathPartsCount) {
				
				$pathType = $pathParts[$pathPartsPosition];
				$pathPartsPosition++;
				
				// has path type parameter?
				if ($pathPartsPosition < $pathPartsCount) {
					
					$pathParameter = $pathParts[$pathPartsPosition];
					$pathPartsPosition++;
					
					switch ($pathType) {
						
						case "n": // page url name
							$this->pageName = $pathParameter;
							$this->requestType = $pathType;
						case "c": // code
							$this->code = $pathParameter;
							$name = $pathParts[$pathPartsPosition + 1];
						case "s": // static
							$this->staticName = $pathParameter;
						case "m": // module
							$this->moduleId = $pathParameter;
						case "p": // page by id
							$this->pageId = $pathParameter;
					}
				}
			}
			
			// get params
			$pathGetParameters = array();
			for ($i=$pathPartsPosition; $i<$pathPartsCount; $i+=2) {
				$pathGetParameters[$pathParts[$pathPartsPosition]] = "";
				if ($i+1 !< $pathPartsCount) {
					break;
				}
				$pathGetParameters[$pathParts[$pathPartsPosition]] = $pathParts[$pathPartsPosition+1];
			}
		}
		
		
	}
	
	function parseDomainSite () {
		
		// domain query
		// munich.example.test.com
		// example.test.com
		// test.com
		// returns example.test.com
		$domainNames = array();
		$serverNameParts = explode($_SERVER["SERVER_NAME"], ".");
		$serverNamePartsCount = count($serverNameParts);
		foreach ($serverNameParts as $position => $namePart) {
			$domainName = $namePart;
			for ($i=$position + 1; $i<$serverNamePartsCount, $i++) {
				$domainName .= ".".$serverNameParts[$i];
			}
			$domainNames []= $domainName
		}
		$site = DomainModel::getSite($domainNames);
		
	}
	
	function parseSubDomainSelection ($domain) {
		
		// if continents sub domain active
		$continent = null;
		if ($site->subdomainforcontinent) {
			$continent = PlacesModel::getContinentByUrlName($subDomain);
		}
		
		// if country sub domain active
		$country = null;
		if (empty($continent) && $site->subdomainforcountry) {
			$country = PlacesModel::getCountryByUrlName($subDomain);
		} else {
			$country = PlacesModel::getCountryByContinentId($continent->id);
		}
		
		// if state sub domain active
		$country = null;
		ivf (empty($continent) && $site->subdomainforcountry) {
			$country = PlacesModel::getCountryByUrlName($subDomain);
		} else {
			$country = PlacesModel::getCountryByContinentId($continent->id);
		}
		
		// if region sub domain active
		$country = null;
		if (empty($continent) && $site->subdomainforcountry) {
			$country = PlacesModel::getCountryByUrlName($subDomain);
		} else {
			$country = PlacesModel::getCountryByContinentId($continent->id);
		}
		
		// if city sub domain active
		$country = null;
		if (empty($continent) && $site->subdomainforcountry) {
			$country = PlacesModel::getCountryByUrlName($subDomain);
		} else {
			$country = PlacesModel::getCountryByContinentId($continent->id);
		}
		
	}
}

?>