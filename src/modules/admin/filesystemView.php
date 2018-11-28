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
        
        $params = array();
        
        if (parent::get("companyId")) {
            $id = parent::get("companyId");
            if (empty($id)) {
                $id = Context::getSelection()->company;
            }
            $params = array(
                "action" => "company", 
                "id" => $id
            );
        } else if (parent::get("userId")) {
            $id = parent::get("userId");
            if (empty($id)) {
                $id = Context::getSelection()->user;
            }
            $params = array(
                "action" => "user", 
                "id" => $id
            );
        }
        
        if ($params == null) {
            $params = array(
                "action" => "user" 
            );
        }
        
        Context::addRequiredScript("resource/js/elfinder/js/elfinder.min.js");
        Context::addRequiredStyle("resource/js/elfinder/css/elfinder.min.css");
        
        ?>
        <div class="panel filesystemPanel">
            <div id="myelfinder" ></div>
            <script>
            $('#myelfinder').elfinder({
                url : '<?php echo NavigationModel::createServiceLink("fileSystem", $params); ?>',
                lang : 'en',
                docked: true
            });
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
                    <?php InputFeilds::printSelect("domain", parent::param("domain"), array("www"=>"www","user"=>"user","all"=>"all","all"=>"all")) ?>
                </div>
                <hr/>
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