<?php

require_once('core/plugin.php');
require_once('modules/comments/commentsModel.php');

class CommentsView extends XModule {

    const modePageComments = 1;
    const modeCurrentUserComments = 2;
    const modeSelectedUserComments = 3;
    
    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {
        
        switch (parent::getAction()) {
            case "save":
                if (Context::hasRole("comment.edit")) {
                    parent::param("mode",$_POST['mode']);
                }
                break;
            case "saveComment":
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
            case "deleteComment":
                if (Context::hasRole("comment.delete")) {
                    CommentsModel::deleteComment(parent::get('id'));
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
    
    function getTranslations () {
        return array(
            "en" => array(
                "comments.postedon" => "Posted on:",
                "comments.by" => "by",
                "comments.email" => "Email:",
                "comments.name" => "Name (username):",
                "comments.message" => "Your Comment:"
            ),
            "de" => array(
                "comments.postedon" => "Posted am: ",
                "comments.by" => "von",
                "comments.email" => "E-Mail:",
                "comments.name" => "Name (Benutzername):",
                "comments.message" => "Dein Commentar:"
            )
        );
    }
    
    function renderConfigView () {
        ?>
        <div class="panel commentsEditPanel">
            <form method="post" action="<?php echo parent::link(array("action" => "save")); ?>">
                <table><tr>
                    <td><?php echo parent::getTranslation("comments.edit.mode"); ?></td>
                    <td><?php InputFeilds::printSelect("mode", parent::param("mode"), array("Page Comments" => self::modePageComments, "Current User Comments" => self::modeCurrentUserComments, "Selected User Comments" => self::modeSelectedUserComments)); ?></td>
                </tr></table>
                <hr/>
                <div class="alignRight">
                    <button type="submit"><?php echo parent::getTranslation("common.save"); ?></button>
                </div>
            </form>
        </div>
        <?php
    }
    
    function renderMainView () {
        
        $comments = array();
        switch (parent::param("mode")) {
            case self::modePageComments:
                $comments = CommentsModel::getComments("t_moduleinstance", parent::get("id"));
                break;
            case self::modeCurrentUserComments:
                $comments = CommentsModel::getComments("t_users", Context::getUserId());
                break;
            case self::modeSelectedUserComments:
                $comments = CommentsModel::getComments("t_users", Context::getSelectedUserId());
                break;
        }
        
        $page = isset($_GET['page']) ? $_GET['page'] : 0;
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
                Context::getUserHome();
                ?>
                <div class="panel commentsPanel">
                    <div class="commentsAvatar">
                        <a href="<?php echo Context::getUserHome($comment->userid); ?>" title="<?php echo $comment->username; ?>">
                            <?php
                            if (!empty($comment->userimage)) {
                                ?>
                                <img src="<?php echo ResourcesModel::createResourceLink("gallery/small", $comment->userimage); ?>" alt="<?php echo $comment->username; ?>" />
                                <?php
                            } else {
                                ?>
                                <img src="resouce/img/icons/User.png" alt="" />
                                <?php
                            }
                            ?>
                        </a>
                    </div>
                    <div class="commentsBody">
                        <div class="commentsHeader">
                            <?php
                            if (Context::hasRole("comment.edit")) {
                                ?>
                                <div style="float: right;">
                                    <a href="<?php echo parent::link(array("action"=>"editComment","id"=>$comment->id)); ?>"><img src="resource/img/edit.png" alt=""/></a>
                                    <a href="<?php echo parent::link(array("action"=>"deleteComment","id"=>$comment->id)); ?>"><img src="resource/img/delete.png" alt=""/></a>
                                </div>
                                <?php
                            }
                            echo parent::getTranslation("comments.postedon")." ".Common::htmlEscape($comment->date)." ".parent::getTranslation("comments.by")." ".Common::htmlEscape($comment->name);
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
            <div class="commentsAvatar">
                <?php
                if (Context::isLoggedIn()) {
                    ?>
                    <img src="<?php echo ResourcesModel::createResourceLink("gallery/small", $comment->userimage); ?>" alt="<?php echo $comment->username; ?>" />
                    <?php
                } else {
                    ?>
                    <img src="resouce/img/icons/User.png" alt="" />
                    <?php
                }
                ?>
            </div>
            <div class="commentsBody">
                <form id="commentForm" method="post" action="<?php echo parent::link(array("action"=>"save")); ?>">
                    <div class="commentsHeader">
                        <?php echo parent::getTranslation("comments.name"); ?><br/>
                        <input type="textbox" name="name" class="expand" value=""/>
                    </div>
                    <div class="commentsHeader">
                        <?php echo parent::getTranslation("comments.email"); ?><br/>
                        <input type="textbox" name="name" class="expand" value=""/>
                    </div>
                    <div class="commentsComment">
                        <?php echo parent::getTranslation("comments.comment"); ?><br/><br/>
                        <textarea name="comment" class="expand" rows="4" cols="3"></textarea>
                    </div>
                    <div class="commentsCaptcha">
                        <?php echo parent::getTranslation("common.captcha"); ?><br/><br/>
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
            <div class="commentsAvatar">
                <?php
                if (!empty($comment->userimage)) {
                    ?>
                    <img src="<?php echo ResourcesModel::createResourceLink("gallery/small", $comment->userimage); ?>" alt="<?php echo $comment->username; ?>" />
                    <?php
                } else {
                    ?>
                    <img src="resouce/img/icons/User.png" alt="" />
                    <?php
                }
                ?>
            </div>
            <div class="commentsBody">
                <form id="commentForm" method="post" action="<?php echo parent::link(array("action"=>"saveComment","id"=>$id)); ?>">
                    <div class="commentsHeader">
                        <?php echo parent::getTranslation("comments.name"); ?><br/>
                        <input type="textbox" name="name" class="expand" value="<?php echo $id != null ? Common::htmlEscape($comment->username) : ""; ?>" disabled="true"/>
                    </div>
                    <div class="commentsComment">
                        <?php echo parent::getTranslation("comments.comment"); ?><br/>
                        <?php echo InputFeilds::printTextArea("comment", $id != null ? $comment->comment : ""); ?>
                    </div>
                    <div class="commentsButtons">
                        <button id="sendComment"><?php echo parent::getTranslation("common.save"); ?></button>
                        <button id="cancel"><?php echo parent::getTranslation("common.cancel"); ?></button>
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