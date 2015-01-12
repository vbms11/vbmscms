<?php

include_once 'core/plugin.php';
include_once 'modules/editor/wysiwygPageModel.php';

class WysiwygPageView extends XModule {

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {
        
        if (Context::hasRole("wysiwyg.edit")) {
            
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
            }
             
        }
    }

    /**
     * called when page is viewed and html created
     */
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

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("pinboard.edit", "pinboard.admin", "pinboard.createNote");
    }
    
    function getStyles () {
    	return array("css/mapStyles");
    }
    
    function getScripts () {
    	return array("https://maps.googleapis.com/maps/api/js");
    }



    /**
     * returns search results for given text
     */
    function search ($searchText, $lang) {
        // return PinboardModel::search($searchText,$lang);
    }
    
    function printEditView () {
        
    }

    function printMainView () {
        
        $notes = PinboardModel::getNotes(parent::get("pinboardId"));
        
        ?>
        <div class="panel pinboardPanel <?php echo parent::alias("pinboardPanel"); ?>">
            <div class="pinboardButtons">
                <a href="#">
                    <img src="" alt="+"></img>
                    <ul>
                        <li><a href="<?php echo parent::link(array("action"=>"newNote","pinboardId"=>parent::get("pinboardId"))); ?>"><?php echo parent::getTranslation("pinboard.options.note"); ?></a></li>
                    </ul>
                <a>
            </div>
            <?php
            foreach ($notes as $note) {
                ?>
                <div class="pinboardNote">
                    <div class="noteInfo">
                    </div>
                    <div clas="noteMessage">
                        <?php echo $note->message; ?>
                    </div>
                </div>
                <?php
            }
            ?>
	    </div>
	    <script type="text/javascript">
	    $(".<?php echo parent::alias("pinboardPanel"); ?>").pinboard({
	        
	    });
	    </script>
	    <?php
	}
	
    function printCreateNoteView () {
        ?>
        <div class="panel createNotePanel <?php echo parent::alias("pinboardPanel"); ?>">
            <div class="pinboardNote">
                <div class="noteInfo">
                </div>
                <div clas="noteMessage">
                    <form method="post" action="<?php echo parent::link(array("action"=>"createNote","pinboarId"=>parent::post("pinboarId"))) ?>">
                        <textarea cols="10" rows="5" name="message"/>
                            <?php echo htmlspecialchars(parent::post("message")); ?>
                        </textarea>
                        <?php
                        $message = parent::getMessage("message");
                        if (!empty($message)) {
                            echo '<span class="validateTips">'.$message.'</span>';
                        }
                        ?>
                        <hr/>
                        <div class="alignRight">
                            <button name="createNote"><?php echo parent::getTranslation("poinboard.new.button.createPinboard"); ?></button>
                            <button name="cancel"><?php echo parent::getTranslation("poinboard.new.button.cancel"); ?></button>
                        </div>
                    </form>
                </div>
                <?php
            }
            ?>
	    </div>
	    <script type="text/javascript">
	    $(".<?php echo parent::alias("createNotePanel"); ?>").pinboard({
	        
	    });
	    </script>
	    <?php
    }
    
    
}

?>
