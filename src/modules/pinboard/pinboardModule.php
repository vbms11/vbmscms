<?php

include_once 'core/plugin.php';
include_once 'modules/pinboard/pinboardModel.php';

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
                    NavigationModel::staticRedirect("pinboardMap");
                    break;
                case "newNote":
                	parent::focus();
                	break;
                case "createNote":
                    
                    if (parent::post("createNote")) {
                        
                        $message = parent::post("message");
                        $pinboardId = parent::get("pinboardId");
                        $type = parent::get("type");
                        $typeId = parent::post("typeId");
                        
                        $userId = Context::getUserId();
                        $x = parent::post("x");
                        $y = parent::post("y");
                        
                        PinboardModel::validateNote($message, $pinboardId, $type, $typeId, $userId, $x, $y);
                        if (empty($messages)) {
                            PinboardModel::createNote($message, $pinboardId, $type, $typeId, $userId, $x, $y);
                            parent::blur();
                            parent::redirect();
                        } else {
                            parent::setMessages($messages);
                        }
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
                    Context::setReturnValue(json_enode($notes));
                    break;
                case "setNotePosition":
                    $note = PinboardModel::getNote(parent::get("noteId"));
                    if (!empty($note) && ($note->userid == Context::getUserId() || Context::hasRole("pinboard.admin"))) {
                        PinboardModel::setNotePosition(parent::get("x"), parent::get("y"));
                    }
         			break;
                
                case "noteCmd":
                	// "move" "delete" "edit" "new":
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
            case "newNote":
                if (Context::hasRole("pinboard.createNote")) {
                    $this->printCreateNoteView();
                }
                break;
            default:
                $this->printMainView();
        }
    }
    
    function getRoles () {
        return array("pinboard.edit", "pinboard.admin", "pinboard.createNote");
    }
    
    function getStyles () {
    	return array("css/pinboard.css");
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
				<a href="#" class="pinboardNewButton">
					<img src="modules/pinboard/img/newNote.png" alt="+" />
				<a>
				<a href="<?php echo parent::link(array("action"=>"closePinboard")); ?>" class="pinboardCloseButton">
					<img src="modules/pinboard/img/closePinboard.png" alt="-" />
				<a>
				<div class="pinboardNewButtons">
					<div>
						<a href="<?php echo parent::link(array("action"=>"newNote","pinboardId"=>parent::get("pinboardId"))); ?>"><?php echo parent::getTranslation("pinboard.options.note"); ?></a>
					</div>
					<div>
						<a href="<?php echo parent::link(array("action"=>"newNote","pinboardId"=>parent::get("pinboardId"))); ?>"><?php echo parent::getTranslation("pinboard.options.offer"); ?></a>
					</div>
					<div>
						<a href="<?php echo parent::link(array("action"=>"newNote","pinboardId"=>parent::get("pinboardId"))); ?>"><?php echo parent::getTranslation("pinboard.options.blog"); ?></a>
					</div>
				</div>
			</div>
            <?php
            if (!empty($notes)) {
	            foreach ($notes as $note) {
	                ?>
	                <div class="pinboardNote" style="left: <?php $note->x; ?>; top: <?php $note->y; ?>;">
						<div class="noteInfo"></div>
						<div clas="noteMessage">
	                        <?php echo $note->message; ?>
	                    </div>
					</div>
	                <?php
	            }
            } else {
            	// no notes
            }
            ?>
	    </div>
		<script type="text/javascript">
	    $(".<?php echo parent::alias("pinboardPanel"); ?>").pinboard({
	    	cmdUrl: "<?php echo parent::ajaxLink(array("action"=>"noteCmd")); ?>"
	    });
	    </script>
		<?php
	}
	
    function printCreateNoteView () {
    	
    	?>
		<div class="panel createNotePanel <?php echo parent::alias("pinboardPanel"); ?>">
			<div class="pinboardNote">
				<div class="noteInfo"></div>
				<div clas="noteMessage">
					<form method="post" action="<?php echo parent::link(array("action"=>"createNote","pinboarId"=>parent::post("pinboarId"))) ?>">
						<textarea cols="10" rows="5" name="message" /><?php 
							echo htmlspecialchars(parent::post("message")); 
						?></textarea>
                        <?php
                        $message = parent::getMessage("message");
                        if (!empty($message)) {
                            echo '<span class="validateTips">'.$message.'</span>';
                        }
                        ?>
                        <hr />
						<div class="alignRight">
							<button type="submit" name="createNote" value="1"><?php echo parent::getTranslation("poinboard.new.button.createPinboard"); ?></button>
							<button name="cancel"><?php echo parent::getTranslation("poinboard.new.button.cancel"); ?></button>
						</div>
					</form>
				</div>
            </div>
	    </div>
	    <?php
	    
    }
}

?>