<?php

require_once('core/plugin.php');

class CompanySearchBaseModule extends XModule {
    
    public $resultsPerPageOptions = array("50","100","200");
    
    function getResultsPerPage () {
        
        $resultsPerPage = parent::get("resultsPerPage");
        if (empty($resultsPerPage)) {
            $resultsPerPage = current($this->resultsPerPageOptions);
        }
        return $resultsPerPage;
    }
    
    function printImportButton () {
        
    }
    
    function listResults ($results, $linkParams = array()) {
        
        $resultsCount = count($results);
        
        $resultsPerPage = $this->getResultsPerPage();
        
        $pagerPages = ceil($resultsCount / $resultsPerPage);
        
        $page = parent::get("page");
        if (empty($page)) {
            $page = 0;
        }
        
        $iStart = $page * $resultsPerPage;
        $iEnd = count($results) > $iStart + $resultsPerPage ? $iStart + $resultsPerPage : count($results);
        
        ?>
        <div class="resultList">
            <?php
            for ($i=$iStart; $i<$iEnd; $i++) {
                $result = $results[$i];
                
                ?>
                <div class="resultListResultDiv shadow">
                    <div class="resultListResultImage">
                        <a href="<?php echo NavigationModel::createStaticPageLink('companyProfile', array('userId' => $result->id), true, false); ?>" title="<?php echo $result->username; ?>">
                            <img width="170" height="170" src="<?php echo UsersModel::getUserImageUrl($result->id); ?>" alt="<?php echo $result->username; ?>"/>
                        </a>
                    </div>
                    <div class="resultListResultDetails">
                        <a href="<?php echo NavigationModel::createStaticPageLink('companyProfile', array('userId' => $result->id), true, false); ?>">
                            <?php 
                            echo $result->name;
                            echo ' ('.$result->amount.')'; 
                            ?>
                        </a>
                    </div>
                </div>
                <?php
            }
            ?>
            <div class="clear"></div>
        </div>
	<?php  
        if ($pagerPages > 1) {
            ?>
            <div class="resultListPager">
                <?php
                for ($i=0; $i<$pagerPages; $i++) {
                    ?>
                    <div>
                        <a href="<?php echo parent::link(array_merge($linkParams,array("page" => $i))); ?>">
                            <?php echo $i + 1; ?>
                        </a>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="clear"></div>
            <?php
        } 

    }

}

?>