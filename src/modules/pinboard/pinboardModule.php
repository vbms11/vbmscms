<?php

include_once 'core/plugin.php';
include_once 'modules/pinboard/pinboardModel.php';
include_once 'modules/users/userWallModel.php';

class PinboardModule extends XModule {
	
    function onProcess () {
        
            switch (parent::getAction()) {
                case "update":
					
                    parent::redirect();
                    parent::blur();
                    break;
                case "edit":
                    parent::focus();
                    break;
                case "cancel":
                    parent::blur();
                case "closePinboard":
                    parent::redirect("pinboardMap");
                    break;
                case "newNote":
                	parent::focus();
                	break;
                case "createNote":
                    
                	if (Context::hasRole("pinboard.createNote")) {
                		
	                    if (parent::post("createNote")) {
	                        
	                    	
	                    	
	                        $message = parent::post("message");
	                        $pinboardId = parent::get("pinboardId");
	                        $type = parent::get("type");
	                        $typeId = parent::post("typeId");
	                        
	                        $userId = Context::getUserId();
	                        $x = parent::post("x");
	                        $y = parent::post("y");
	                        
	                        $messages = PinboardModel::validateNote($message, $pinboardId, $type, $typeId, $userId, $x, $y);
	                        
	                        $human = Captcha::validate("security");
	                        if (!$human) {
	                        	$messages["security"] = "Wrong answer please try again!";
	                        }
	                        
	                        if (empty($messages)) {
	                            $noteId = PinboardModel::createNote($message, $pinboardId, $type, $typeId, $userId, $x, $y);
	                            UserWallModel::createUserWallEventNote($userId, $noteId);
	                            if (!Context::isAjaxRequest()) {
	                            	parent::blur();
	                            	parent::redirect(array("pinboardId"=>$pinboardId));
	                            } else {
	                            	parent::redirect(array("action"=>"noteCreated", "noteId"=>$noteId, "pinboardId"=>$pinboardId));
	                            }
	                        } else {
	                            parent::setMessages($messages);
	                        }
	                    } else if (parent::post("cancel") == "1") {
	                    	if (!Context::isAjaxRequest()) {
	                    		parent::redirect(array("pinboardId"=>$pinboardId));
	                    	}
	                    }
                    } else {
                   		parent::redirect("login");
                    }
                    
                    break;
                case "deleteNote":
                    
                    $note = PinboardModel::getNote(parent::get("noteId"));
                    if (!empty($note) && ($note->userid == Context::getUserId() || Context::hasRole("pinboard.admin"))) {
                        PinboardModel::deleteNote($note->id);
                    }
                    break;
                case "getNotes":
                    $notes = PinboardModel::getNotes(parent::get("pinboardId"));
                    foreach ($notes as $note) {
                    	if (Context::hasRole("pinboard.admin") || $note->userid == Context::getUserId()) {
                    		$note->editable = "true";
                    	}
                    }
                    Context::setReturnValue(json_enode($notes));
                    break;
                case "setNotePosition":
                    $note = PinboardModel::getNote(parent::get("noteId"));
                    if (!empty($note) && ($note->userid == Context::getUserId() || Context::hasRole("pinboard.admin"))) {
                        PinboardModel::setNotePosition(parent::get("x"), parent::get("y"));
                    }
         			break;
     	}
     	
    }

    function onView () {
        
        switch (parent::getAction()) {
            case "edit":
                if (Context::hasRole("pinboard.edit")) {
                    $this->printEditView();
                }
                break;
            case "noteCreated":
            	if (Context::isAjaxRequest()) {
            		$this->renderNoteCreated();
            	}
            case "newNote":
            case "viewNote":
            	$this->renderNote(parent::get("noteId"));
            	break;	
            case "createNote":
                if (Context::hasRole("pinboard.createNote")) {
                	$this->printCreateNoteView();
                }
                break;
            case "saveMessage":
            default:
                $this->printMainView();
        }
    }
    
    function getRoles () {
        return array("pinboard.edit", "pinboard.admin", "pinboard.createNote");
    }
    
    function getStyles () {
    	return array("css/pinboard.css", "/resource/css/captcha.css");
    }
    
    function getScripts () {
    	return array("js/pinboard.js");
    }
    
    function printEditView () {
    	?>
		<div class="panel pinboardEditPanel <?php echo parent::alias("pinboardPanel"); ?>">
    		<h1><?php echo parent::getTranslation("pinboard.edit.title"); ?></h1>
    		<p><?php echo parent::getTranslation("pinboard.edit.description"); ?></p>
    		
    		<hr/>
    		<form method="post" action="<?php echo parent::link(array("action"=>"update")); ?>">
	    		<div class="alignRight">
	    			<button class="jquiButton" name="save"><?php echo parent::getTranslation("common.save"); ?></button>
	    			<button class="jquiButton" name="cancel"><?php echo parent::getTranslation("common.cancel"); ?></button>
	    		</div>
    		</form>
    	</div>
    	<?php
    }
    
    function printMainView () {
        
        $notes = PinboardModel::getNotes(parent::get("pinboardId"));
        
        ?>
		<div class="panel pinboardPanel <?php echo parent::alias("pinboardPanel"); ?>">
			<div class="pinboardButtons">
				<a href="<?php echo parent::link(array("action"=>"createNote","pinboardId"=>parent::get("pinboardId"))); ?>" class="pinboardNewButton">
					<img src="modules/pinboard/img/newNote.png" alt="+" />
				</a>
				<a href="<?php echo parent::link(array("action"=>"closePinboard","pinboardId"=>parent::get("pinboardId"))); ?>" class="pinboardCloseButton">
					<img src="modules/pinboard/img/closePinboard.png" alt="-" />
				</a><?php /*
				<a href="<?php echo parent::link(array("action"=>"createNote","pinboardId"=>parent::get("pinboardId"))); ?>" class="pinboardNewButton">
					<img src="modules/pinboard/img/newNote.png" alt="+" />
				<a>
				
				<div class="pinboardNewButtons">
					<div>
						<a class="newNoteButton" href="<?php echo parent::link(array("action"=>"newNote","pinboardId"=>parent::get("pinboardId"))); ?>"><?php echo parent::getTranslation("pinboard.options.note"); ?></a>
					</div>
					<div>
						<a href="<?php echo parent::link(array("action"=>"newNote","pinboardId"=>parent::get("pinboardId"))); ?>"><?php echo parent::getTranslation("pinboard.options.offer"); ?></a>
					</div>
					<div>
						<a href="<?php echo parent::link(array("action"=>"newNote","pinboardId"=>parent::get("pinboardId"))); ?>"><?php echo parent::getTranslation("pinboard.options.blog"); ?></a>
					</div>
				</div> 
				*/ ?>
			</div>
            <?php
            if (!empty($notes)) {
	            foreach ($notes as $note) {
	                $this->renderNoteByObject($note);
	            }
            } else {
            	// no notes
            }
            ?>
	    </div>
		<script type="text/javascript">
	    $(".<?php echo parent::alias("pinboardPanel"); ?>").pinboard({
	    	cmdUrl: "<?php echo parent::ajaxLink(array("pinboardId"=>parent::get("pinboardId"))); ?>"
	    });
	    </script>
	    <noscript>
	    	<style type="text/css">
	    	.pinboardPanel .pinboardNote {
	    		position: relative;
	    		float: left;
	    		display: block;
	    		overflow-y: auto;
	    		overflow-x: none;
	    	}
	    	</style>
	    </noscript>
		<?php
	}
	
	function renderNoteCreated () {
		?>
		<script>
		$(".<?php echo parent::alias("pinboardPanel"); ?>")
			.pinboard("hideCreateNotePanel")
			.pinboard("loadNote", "<?php echo parent::get("noteId"); ?>");
		</script>
		<?php
	}
	
	function renderNote ($noteId) {
		$note = PinboardModel::getNote($noteId);
		if (!empty($note)) {
			$this->renderNoteByObject($note);
		}
	}
	
	function renderNoteByObject ($note) {
		?>
		<div id="note_<?php echo $note->id; ?>" class="pinboardNote notex_<?php $note->x; ?> notey_<?php $note->y; ?>" style="left: <?php $note->x; ?>; top: <?php $note->y; ?>;">
			<div class="noteInfo"></div>
			<div class="noteMessage">
				<?php echo $note->message; ?>
			</div>
		</div>
		<?php
	}
	
    function printCreateNoteView () {
    	
    	?>
		<div class="panel createNotePanel <?php echo parent::alias("pinboardPanel"); ?>">
			<h1><?php echo parent::getTranslation("pinboard.create.title"); ?></h1>
			<p><?php echo parent::getTranslation("pinboard.create.description"); ?></p>
			<form method="post" action="<?php echo parent::link(array("action"=>"createNote","pinboardId"=>parent::get("pinboardId"))) ?>">
				<table class="formTable"><tr><td>
					<?php echo parent::getTranslation("pinboard.create.message.label"); ?>
				</td><td>
					<textarea class="expand" cols="10" rows="5" name="message" placeholder="<?php echo parent::getTranslation("pinboard.create.message.placeholder"); ?>"><?php 
						echo htmlspecialchars(parent::post("message")); 
					?></textarea>
					<?php
	                $message = parent::getMessage("message");
	                if (!empty($message)) {
	                	echo '<span class="validateTips">'.$message.'</span>';
	                }
	                ?>
				</td></tr><tr><td>
					<?php echo parent::getTranslation("pinboard.create.security.label"); ?>
				</td><td>
					<?php InputFeilds::printCaptcha("security");
	                $message = parent::getMessage("security");
	                if (!empty($message)) {
	                	echo '<span class="validateTips">'.$message.'</span>';
	                }
	                ?>
				</td></tr></table>
                <hr/>
				<div class="alignRight">
					<button type="submit" name="createNote" value="1"><?php echo parent::getTranslation("poinboard.new.button.createPinboard"); ?></button>
					<button name="cancel" name="cancel" value="1"><?php echo parent::getTranslation("poinboard.new.button.cancel"); ?></button>
				</div>
			</form>
		</div>
		<script type="text/javascript">
		$(".createNotePanel .alignRight button").button();
		</script>
	    <?php
    }
}

?>