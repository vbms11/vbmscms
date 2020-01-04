<?php

require_once 'core/plugin.php';

class LanguagesModule extends XModule {
    
    function onProcess () {
        
        switch (parent::getAction()) {
            
            case "save":
                $languages = LanguagesModel::getLanguages();
                foreach ($languages as $language) {
                    $uploadedFile = $language->flag;
                    $uploadedFile = $_FILES["flag_".$language->local]['name'];
                    $targetPath = Resource::getResourcePath("flags",$uploadedFile);
                    if(!move_uploaded_file($_FILES["flag_".$language->local]['tmp_name'], $targetPath)) {
                        echo "error moving uploaded file!";
                    } else {
                        $language->flag = $uploadedFile;
                    }
                    LanguagesModel::saveLanguage($language->id,$language->flag,isset($_POST["active_".$language->local]) ? "1" : "0");
                }
                //parent::redirect(array("action"=>"edit"));
                parent::redirect();
                break;
            case "edit":
                parent::focus();
                break;
            default:
                break;
        }
    }
    
    function onView () {
        
        switch (parent::getAction()) {
            case "edit":
                $this->renderEditView();
                break;
            default:
                $this->renderMainView();
        }
    }
    
    function getStyles() {
        array("css/languages.css");
    }
    
    function renderMainView () {
        $languages = LanguagesModel::getActiveLanguages();
        ?>
        <div class="panel languagePanel">
            <?php
            foreach ($languages as $language) {
                ?>
                <a class="langSelectLink" href="<?php echo NavigationModel::createLangSelectLink($language->name); ?>">
                    <img class="imageLink" src="<?php echo Resource::createResourceLink("flags",$language->flag); ?>" alt="" />
                </a>
                <?php
            }
            ?>
        </div>
        <?php
    }
    
    function renderEditView () {
	$languages = LanguagesModel::getLanguages();
	?>
	<div class="panel languageEditPanel">
		<form method="post" action="<?php echo parent::link(array("action"=>"save")); ?>" enctype="multipart/form-data">
		<table width="100%">
		<tr><td>
			Active
		</td><td>
			Local
		</td><td>
			Flag
		</td><td>
			Change Flag
		</td></tr>
		<?php
		foreach ($languages as $language) {
			?>
			<tr><td>
				<?php InputFeilds::printCheckbox("active_".$language->local,$language->active); ?>
			</td><td>
				<?php echo $language->local; ?>
			</td><td>
				<img src="<?php echo Resource::createResourceLink("flags",$language->flag); ?>" alt="" />
			</td><td>
				<?php InputFeilds::printFileUpload("flag_".$language->local,$language->flag); ?>
			</td></tr>
			<?php
		}
		?>
		</table>
		<hr/>
		<div class="alignRight">
			<button type="submit">Save</button>
		</div>
		</form>
		
	</div>
	<script>
	$(".languageEditPanel .alignRight button").each(function (index, object) {
		$(object).button();
	});
	</script>
	<?php
	
    }
}

?>