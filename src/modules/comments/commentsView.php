<?php

require_once('core/plugin.php');
require_once('modules/comments/commentsModel.php');

class CommentsView extends XModule {

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {
        
        switch (parent::getAction()) {

            case "save":
                if (isset($_GET['id']) && !Common::isEmpty($_GET['id'])) {
                    if (Context::hasRole("comment.edit")) {
                        CommentsModel::saveComment(parent::getId(), $_GET['id'], $_POST['name'], $_POST['comment']);
                    }
                } else {
                    if (Context::hasRole("comment.post")) {
                        if (Captcha::validateInput("captcha")) {
                            CommentsModel::saveComment(parent::getId(), null, $_POST['name'], $_POST['comment']);
                        }
                    }
                }
                parent::redirect();
                break;
            case "delete":
                if (Context::hasRole("comment.delete")) {
                    CommentsModel::deleteComment($_GET['id']);
                }
                break;
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {
        
        switch (parent::getAction()) {
            
            case "editcomment":
                if (Context::hasRole("comment.edit")) {
                    $this->renderEditView(isset($_GET['id']) && !common::isEmpty($_GET['id']) ? $_GET['id'] : null);
                }
                break;
            default:
                $this->renderMainView();
        }
        
        
        
    }

    function getStyles () {
        return array("css/comments.css");
    }

    function getRoles () {
        return array("comment.post","comment.edit","comment.delete");
    }
    
    function renderMainView () {
        
        $page = isset($_GET['page']) ? $_GET['page'] : 0;
        $comments = CommentsModel::getComments(parent::getId(),$page);
        $pages = floor(count($comments) / 20);
        
        if ($pages > 1) {
            ?>
            <div class="commentsPages">
                Seite: 
                <?php
                for ($i=1; $i<=$pages; $i++) {
                    echo "<a href='".parent::link(array("page"=>$i))."'>".$i."</a>";
                }
                ?>
            </div>
            <br/>
            <?php
        }
        if ($comments != null) {
            foreach ($comments as $comment) {
                ?>
                <div class="panel commentsPanel">
                    <div class="commentsAvatar"></div>
                    <div class="commentsBody">
                        <div class="commentsHeader">
                            <?php
                            if (Context::hasRole("comment.edit")) {
                                ?>
                                <div style="float: right;">
                                    <a href="<?php echo parent::link(array("action"=>"editcomment","id"=>$comment->id)); ?>"><img src="resource/img/edit.png" alt=""/></a>
                                    <a href="<?php echo parent::link(array("action"=>"delete","id"=>$comment->id)); ?>"><img src="resource/img/delete.png" alt=""/></a>
                                </div>
                                <?php
                            }
                            echo "Posted on: ".Common::htmlEscape($comment->date)." by ".Common::htmlEscape($comment->name);
                            ?>
                        </div>
                        <div class="commentsComment">
                            <?php echo Common::htmlEscape($comment->comment); ?>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
        <div class="panel commentsPanel">
            <div class="commentsAvatar"></div>
            <div class="commentsBody">
                <form id="commentForm" method="post" action="<?php echo parent::link(array("action"=>"save")); ?>">
                    <div class="commentsHeader">
                        Your Name:<br/>
                        <input type="textbox" name="name" class="expand" value=""/>
                    </div>
                    <div class="commentsComment">
                        Message:<br/>
                        <textarea name="comment" class="expand" rows="4" cols="3"></textarea>
                    </div>
                    <div class="commentsCaptcha">
                        Confirm code:<br/>
                        <?php InputFeilds::printCaptcha("captcha"); ?>
                    </div>
                    <div class="commentsButtons">
                        <button id="sendComment">Send Comment</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
        if ($pages > 1) {
            ?>
            <br/>
            <div class="commentsPages">
                Seite: 
                <?php
                for ($i=1; $i<=$pages; $i++) {
                    echo "<a href='".parent::link(array("page"=>$i))."'>".$i."</a>";
                }
                ?>
            </div>
            <?php
        }
        ?>
        <script type="text/javascript">
        $(function() {
            $( "button", ".commentsPanel" ).button();
            $( "#sendComment" ).click(function() { 
                $("#commentForm").submit();
            });
	});
        </script>
        <?php
    }
    
    function renderEditView ($id=null) {
        if ($id!=null) {
            $comment = CommentsModel::getComment($id);
        }
        ?>
        <div class="panel commentsPanel">
            <div class="commentsAvatar"></div>
            <div class="commentsBody">
                <form id="commentForm" method="post" action="<?php echo parent::link(array("action"=>"save","id"=>$id)); ?>">
                    <div class="commentsHeader">
                        Name:<br/>
                        <input type="textbox" name="name" value="<?php if ($id!=null) echo Common::htmlEscape($comment->name); ?>" class="expand"/>
                    </div>
                    <div class="commentsComment">
                        Message:<br/>
                        <textarea name="comment" class="expand" rows="4" cols="3"><?php if ($id!=null) echo Common::htmlEscape($comment->comment); ?></textarea>
                    </div>
                    <div class="commentsButtons">
                        <button id="sendComment">Save Comment</button>
                        <button id="cancel">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
        $(function() {
            $( "button", ".commentsPanel" ).button();
            $( "#sendComment" ).click(function() { 
                $("#commentForm").submit();
            });
            $( "#cancel" ).click(function() { 
                history.back();
            });
	});
        </script>
        <?php
    }
}

?>