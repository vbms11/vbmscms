<?php

require_once 'core/plugin.php';

class InstallView extends XModule {
	
    function onProcess () {

        switch (isset($_GET['action']) ? $_GET['action'] : null) {
            case "saveDbConfig":
                $_SESSION['hostname'] = $_POST['hostname'];
                $_SESSION['dbusername'] = $_POST['username'];
                $_SESSION['dbpassword'] = $_POST['password'];
                $_SESSION['database'] = $_POST['database'];
                
                $link = @mysqli_connect($_SESSION['hostname'],$_SESSION['dbusername'],$_SESSION['dbpassword']);
                if (!$link) {
                    $_SESSION['installMsg'] = "Unable to connect to the database!";
                    NavigationModel::redirect("?action=dbConfig&session=nodb",false);
                } else {
                    $check = @mysqli_select_db($link,$_SESSION['database']);
                    if (!$check) {
                        $_SESSION['installMsg'] = "Connection established but invalid database name!";
                        NavigationModel::redirect("?action=dbConfig&session=nodb",false);
                    } else {
                        //NavigationModel::redirect("?action=printInstallingView&session=nodb",false);
                        NavigationModel::redirect("?action=install&session=nodb",false);
                    }
                }
                break;
            case "setInitialUser":
                // save user detail in session
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['firstname'] = $_POST['firstname'];
                $_SESSION['lastname'] = $_POST['lastname'];
                $_SESSION['password'] = $_POST['password'];
                $_SESSION['email'] = $_POST['email'];
                $_SESSION['birthdate'] = $_POST['birthdate'];
                $_SESSION['gender'] = $_POST['gender'];
                NavigationModel::redirect("?action=dbConfig&session=nodb",false);
                break;
            case "install":
                // create config file
                echo "build config<br/>";
                InstallerController::buildConfig($_SESSION['hostname'],$_SESSION['dbusername'],$_SESSION['dbpassword'],$_SESSION['database'],$_SESSION['email']);
                // install datamodel
                echo "install model<br/>";
                InstallerController::installModel();
                // create initial user
                echo "create initial user<br/>";
                InstallerController::createInitialUser($_SESSION['username'], $_SESSION['firstname'], $_SESSION['lastname'], $_SESSION['password'], $_SESSION['email'], $_SESSION['birthdate'], $_SESSION['gender']);
                // redirect to startpage
                NavigationModel::redirect("?session=nodb",false);
                break;
            case "progress":
                echo $_SESSION['installProgress'];
                return false;
                break;
        }
        return true;
    }
	
    function onView () {

        switch (isset($_GET['action']) ? $_GET['action'] : null) {
            case "dbConfig":
                $this->printDbConfigView();
                break;
            case "initialUser":
                $this->printInitialUserView();
                break;
            case "printInstallingView":
                $this->printInstallingView();
                break;
            default:
                if (!Config::getInstalled()) {
                    $this->printWelcomeView();
                } else if (Config::getDbInstalled()) {
                    $this->printDatabaseEmptyView();
                }
                break;
        }
    }
	
    function printInstallingView () {
        ?>
        <div class="panel installPanel">
            <h2>Installation Progress</h2>
            <p>The cms is installing the datamodel, This may take several minutes.</p>
            <hr/>
            <div id="progressbar"></div>
            <script>
            $("#progressbar").progressbar({
                value: 100
            });
            function gotoLogin (data) {
                callUrl("");
            }
            $.ajax({
                "url": "?action=install&<?php echo session_name()."=".session_id(); ?>",
                "context": document.body,
                "success": function(data){
                    gotoLogin(data);
                }
            });
            </script>
        </div>
        <?php
    }
    
    function printDatabaseEmptyView () {
        
        $backups = BackupModel::getBackupFiles();
        ?>
        <div class="panel installPanel">
            <h2>Database Empty</h2>
            <p>
            The database seems to be missing its tables. 
            They will have to be reinstalled from a backup or the original dataset. 
            Select backup to reload. 
            </p>
            <div class="divTable">
                <?php
                foreach ($backups as $backup) {
                    $fullPath = ResourceModel::resourcePath("backup", $backup);
                    ?>
                    <div>
                        <div>
                            <?php echo $backup; ?>
                        </div>
                        <div>
                            <?php echo filemtime($fullPath); ?>
                        </div>
                        <div>
                            <a href="<?php echo parent::link("loadBackup", array("file"=>$backup)); ?>">
                                Restore
                            </a>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <hr/>
            <div class="alignRight">
                <button type="submit" class="jquiButton btnInstallNext">Load Default</button>
            </div>
        </div>
        <?php
    }

    function printInitialUserView () {
        ?>
        <div class="panel installPanel">
            <h2>Create Admin User</h2>
            Fill in the details for the initial user. This user will then have all system rights.
            <hr/>
            <form method="post" action="?action=setInitialUser&session=nodb">
                <table class="formTable"><tr>
                    <td>Username: </td>
                    <td><?php InputFeilds::printTextFeild("username","","expand"); ?></td>
                </tr><tr>
                    <td>FirstName: </td>
                    <td><?php InputFeilds::printTextFeild("firstname","","expand"); ?></td>
                </tr><tr>
                    <td>LastName: </td>
                    <td><?php InputFeilds::printTextFeild("lastname","","expand"); ?></td>
                </tr><tr>
                    <td>Gender: </td>
                    <td><?php InputFeilds::printSelect("gender","1",array("0"=>parent::getTranslation("common.female"),"1"=>parent::getTranslation("common.male"))); ?></td>
                </tr><tr>
                    <td>Password: </td>
                    <td><?php InputFeilds::printTextFeild("password","","expand"); ?></td>
                </tr><tr>
                    <td>E-mail: </td>
                    <td><?php InputFeilds::printTextFeild("email","","expand"); ?></td>
                </tr><tr>
                    <td>Birthdate: </td>
                    <td><?php InputFeilds::printDataPicker("birthdate",""); ?></td>
                </tr></table>
                <hr/>
                <div class="alignRight">
                    <button type="submit" class="jquiButton btnInstallNext">Next</button>
                </div>
            </form>
        </div>
        <?php
    }

    function printWelcomeView () {
        ?>
        <div class="panel installPanel">
            <h2>Welcome to vbmscms</h2>
            <p>This is a step by step wizard that will install vbmscms 
            on the server where this script is being executed! The only 
            requirement is a working mysqlserver and php 5+</p>
            <hr/>
            <div class="alignRight">
                <button type="button" class="jquiButton btnInstallNext">Next</button>
            </div>
            <script>
            $(".btnInstallNext").click(function(e){
                callUrl('?action=initialUser&session=nodb');
            });
            </script>
        </div>
        <?php
    }

    function printDbConfigView() {
        ?>
        <div class="panel installPanel">
            <h2>Database Configuration</h2>
            <p>Enter the database credentials so that the datamodel can be installed!</p>
            <hr/>
            <?php
            if (isset($_SESSION['installMsg']) && !Common::isEmpty($_SESSION['installMsg'])) {
                echo "<span style='color:red;'>";
                echo $_SESSION['installMsg'];
                echo "</span><hr/>";
            }
            ?>
            <form method="post" action="?action=saveDbConfig&session=nodb">
                <table class="formTable"><tr>
                    <td>Hostname: </td>
                    <td><?php InputFeilds::printTextFeild("hostname",isset($_POST['hostname']) ? $_POST['hostname'] : "","expand"); ?></td>
                </tr><tr>
                    <td>Database: </td>
                    <td><?php InputFeilds::printTextFeild("database",isset($_POST['database']) ? $_POST['database'] : "","expand"); ?></td>
                </tr><tr>
                    <td>Username: </td>
                    <td><?php InputFeilds::printTextFeild("username",isset($_POST['username']) ? $_POST['username'] : "","expand"); ?></td>
                </tr><tr>
                    <td>Password: </td>
                    <td><?php InputFeilds::printTextFeild("password",isset($_POST['password']) ? $_POST['password'] : "","expand"); ?></td>
                </tr></table>
                <hr/>
                <div class="alignRight">
                    <button type="submit" class="jquiButton btnInstallNext">Next</button>
                </div>
            </form>
        </div>
        <?php
    }

}

?>