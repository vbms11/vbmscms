<?php

require_once('core/plugin.php');

class CurrentUserModule extends XModule {

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {

        switch (parent::getAction()) {
            case 'save':
                if (Context::hasRole("users.current.edit")) {
                    parent::param("users.current.text",$_POST['text']);
                }
                break;
            default:
        }
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {

        switch (parent::getAction()) {
            case 'edit':
                if (Context::hasRole("users.current.edit")) {
                    $this->printEditView();
                }
                break;
            default:
                $this->printMainView();
                break;
        }
    }

    /**
     * returns an array of the translations used by this module
     * @return <type>
     */
    function getTranslations () {
        return array(
            'en' => array(
                'users.current.label.text' => 'The welcome text %username% is replaced with the current users name.'
            ),'de' => array(
                'users.current.label.text' => 'Das willkommensnachricht %username% wird mit den benutzername ersatz.'
            )
        );
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("users.current.edit");
    }

    /**
     * prints the main view
     * @param <type> $moduleId
     */
    function printMainView () {
        if (Context::isLoggedIn()) {
            $user = Context::getUser();
            ?>
            <div class="panel currentUserPanel">
                <?php echo str_replace("%username%",$user->username,parent::param("users.current.text")); ?>
            </div>
            <?php
        }
    }

    /**
     * the edit view for this module
     */
    function printEditView () {
        ?>
        <div class="panel currentUserPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"save")); ?>">
                <label><?php echo parent::getTranslation('users.current.label.text'); ?></label>
                <textarea name="text" row="3" class="expand"><?php echo Common::htmlEscape(parent::param('users.current.text')); ?></textarea>
                <hr/>
                <div class="alignRight">
                    <button type="submit">Save</button>
                    <button type="button" onclick="callUrl('<?php echo parent::link(array("action"=>"cancel")); ?>'); return false;">Cancel</button>
                </div>
            </form>
        </div>
        <?php
    }
}

?>