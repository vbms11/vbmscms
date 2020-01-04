<?php

require_once 'core/plugin.php';

class ArticleModule extends XModule {
    
    function onProcess () {
        
        switch (parent::getAction()) {
            case "createDomain":
                if (Context::hasRole("domains.edit")) {
                    DomainsModel::createDomain(parent::post("domainName"), Context::getSiteId(), parent::post("domainTrackerScript"));
                }
                break;
            case "editSaveDomain":
                if (Context::hasRole("domains.edit")) {
                    DomainsModel::updateDomain(parent::get("id"), parent::post("domainName"), Context::getSiteId(), parent::post("domainTrackerScript"));
                }
                break;
            case "deleteDomain":
                if (Context::hasRole("domains.edit")) {
                    DomainsModel::deleteDomain(parent::get("id"));
                }
                break;
        }
    }
    
    function onView () {
        
        switch (parent::getAction()) {
            case "addDomain":
                if (Context::hasRole("domains.edit")) {
                    $this->renderRegisterTabs();
                }
                break;
            case "editDomain":
                if (Context::hasRole("domains.edit")) {
                    $domain = DomainsModel::getDomain(parent::get("id"));
                    $this->renderEditTabs($domain);
                }
                break;
            default:
                if (Context::hasRole("domains.view")) {
                    $this->renderMainView(parent::param("articleId"));
                }
        }
    }
    
    function getRoles() {
        return array("article.edit","article.view");
    }
    
    function renderEditArticleView ($articleId) {
    	
    	$article = ArticleModel::getArticle($articleId);
    	?>
    	<div class="panel articleEditPanel">
    		<form method="post" action="<?php echo parent::link(array("action"=>"save","id"=>$article->id)); ?>">
    		<tr>
    		<td><label="articleName"><?php echo  ?></td>
    		<td><input type="textbox" value="<?php $article->name; ?>" /></td>
    		</tr><tr>
    		<td></td>
    		<td></td>
    		</tr></form>
    	</div>
    	<?php
    }
    
    function renderMainView () {
    	
    	$article = ArticleModel::getArticle($articleId);
    	$keywords = ArticleModel::getArticleKeywords($articleId);
    	$galleryModel::getImage($article->image);
    	
    	?>
    	<div class="panel articlePanel">
    		<div class="articleTitle">
    			<h1><?php echo htmlentities($article->title); ?></1>
    		</div>
    		<div class="articleImage">
    			<img src="" alt="" />
    			<img class="imageLink" width="170" height="170" src="<?php 
					if (empty($image->filename)) {
						echo "resource/img/icons/Clipboard.png";
                    } else {
                      	echo Resource::createResourceLink("gallery/small",$category->filename);
                    }
                    ?>" alt=""/>
    		</div>
    		<div class="articleContent">
    			
    			<?php echo echo htmlentities($article->content); ?>
    		</div>
    		<div class="articleKeywords">
    			<?php
    			foreach ($keywords as $keyword) {
    				?>
    				.articleKeywords span:last-child {
    					display: none;
    				}
    				<a href="<?php echo parent::staticLink("articleKeyword", array("keywordId"=>$keyword->id)); ?>">
    					<?php echo htmlentities($keyword->name); ?>
    				</a>
    				<span>, </span>
    				<?php
    			}
    			?>
    		</div>
    	</div>
    	<?php
    }
    
}

?>