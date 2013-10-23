<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'core/plugin.php';

class FilesystemView extends XModule {

    /**
     * called when page is viewed before output stream is filled
     */
    function onProcess () {
        
        switch (parent::getAction()) {
            
            case "update":
                parent::param("domain",$_POST["domain"]);
                break;
        }
        
    }

    /**
     * called when page is viewed and html created
     */
    function onView () {

        switch (parent::getAction()) {
            case "edit":
                $this->printEditView();
                break;
            default:
                $this->printMainView();
        }
    }

    /**
     * returns the roles defined by this module
     */
    function getRoles () {
        return array("filesystem.edit");
    }

    function printMainView () {
        
        Context::addRequiredScript("resource/js/elfinder/js/elfinder.min.js");
        Context::addRequiredStyle("resource/js/elfinder/css/elfinder.css");
        
        ?>
        <div class="panel filesystemPanel">
            <div id="myelfinder" ></div>
            <script>
            $('#myelfinder').elfinder({
                url : '<?php echo NavigationModel::createServiceLink("fileSystem", array("action"=>parent::param("domain"))); ?>',
                lang : 'en',
                docked: true,
                dialog : { width : 900, modal : true, title : 'elFinder - file manager for web' },
                closeOnEditorCallback : true
            })
            $('#myelfinder').elfinder("open");
            </script>
        </div>
        <?php
    }

    function printEditView () {
        ?>
        <div class="panel filesystemPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"update")); ?>">
                <div>
                    <b>Please select the group of files to display:</b>
                </div>
                <br/>
                <div>
                    <?php InputFeilds::printSelect("domain", parent::param("domain"), array("www"=>"www","user"=>"user","all"=>"all")) ?>
                </div>
                <hr noshade/>
                <div class="formFeildButtons" align="right">
                    <button type="submit">Speichern</button>
                    <button type="submit" onclick="callUrl('<?php echo parent::link(array("action"=>"cancel")); ?>'); return false;">Abbrechen</button>
                </div>
            </form>
            <script>
            $(".filesystemPanel button").button();
            </script>
        </div>
        <?php
    }
}

?>