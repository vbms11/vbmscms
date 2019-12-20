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
                        NavigationModel::redirect("?action=selectSetup&session=nodb",false);
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
            case "setSetup":
                if (isset($_POST["setup"])) {
                    if (isset($_SESSION["setups"][$_POST["setup"]])) {
                        $_SESSION["setup"] = $_SESSION["setups"][$_POST["setup"]];
                        $_SESSION["siteName"] = $_POST["siteName"];
                        $_SESSION["siteDescription"] = $_POST["siteDescription"];
                        unset($_SESSION["setups"]);
                        $_SESSION["installStatus"] = "buildConfig";
                        NavigationModel::redirect("?action=printInstallingView&session=nodb",false);
                    }
                }
                
                break;
            
            case "install":
                
                $status = array();
                
                switch ($_SESSION["installStatus"]) {
                    
                    case "buildConfig":
                        
                        try {
                            $_SESSION["installStatus"] = "wait";
                            InstallerController::buildConfig($_SESSION['hostname'],$_SESSION['dbusername'],$_SESSION['dbpassword'],$_SESSION['database'],$_SESSION['email']);
                            $status = array(
                                "status" => "ok",
                                "message" => "config files written.",
                                "progress" => 20
                            );
                            $_SESSION["installStatus"] = "installModel";
                        } catch (Exception $e) {
                            $status = array(
                                "status" => "error",
                                "message" => "could not write config files."
                            );
                        }
                        Context::setReturnValue(json_encode($status));
                        break;
                        
                    case "installModel":
                        
                        try {
                            $_SESSION["installStatus"] = "wait";
                            InstallerController::installModel($_SESSION["setup"]);
                            $status = array(
                                "status" => "ok",
                                "message" => "database setup installed.",
                                "progress" => 40
                            );
                            $_SESSION["installStatus"] = "createInintialSite";
                        } catch (Exception $e) {
                            $status = array(
                                "status" => "error",
                                "message" => "could not install database."
                            );
                        }
                        Context::setReturnValue(json_encode($status));
                        break;
                        
                    case "createInintialSite":
                        
                        try {
                            $_SESSION["installStatus"] = "wait";
                            $_SESSION["site"] = InstallerController::createInitialSite($_SESSION["siteName"], $_SESSION["siteDescription"]);
                            $status = array(
                                "status" => "ok",
                                "message" => "initial site created.",
                                "progress" => 60
                            );
                            $_SESSION["installStatus"] = "createInintialUser";
                        } catch (Exception $e) {
                            $status = array(
                                "status" => "error",
                                "message" => "could not create initial site."
                            );
                        }
                        Context::setReturnValue(json_encode($status));
                        break;
                        
                    case "createInintialUser":
                        
                        try {
                            $_SESSION["installStatus"] = "wait";
                            InstallerController::createInitialUser($_SESSION['username'], $_SESSION['firstname'], $_SESSION['lastname'], $_SESSION['password'], $_SESSION['email'], $_SESSION['birthdate'], $_SESSION['gender'], $_SESSION["site"]["cmsCustomer"], $_SESSION["site"]["siteId"]);
                            $status = array(
                                "status" => "ok",
                                "message" => "initial user created.",
                                "progress" => 80
                            );
                            $_SESSION["installStatus"] = "gotoApplication";
                        } catch (Exception $e) {
                            $status = array(
                                "status" => "error",
                                "message" => "could not create initial user.",
                                "exception" => $e->getTraceAsString()
                            );
                        }
                        Context::setReturnValue(json_encode($status));
                        break;
                        
                    case "gotoApplication":
                        
                        $status = array(
                            "status" => "finnished",
                            "message" => "install complete.",
                            "progress" => 100
                        );
                        unset($_SESSION["installStatus"]);
                        InstallerController::confirmInstall();
                        Context::setReturnValue(json_encode($status));
                        break;
                    case "wait":
                        // when a step is already being taken
                        $status = array(
                            "status" => "wait"
                        );
                        Context::setReturnValue(json_encode($status));
                        break;
                }
                /*
                // create config file
                InstallerController::buildConfig($_SESSION['hostname'],$_SESSION['dbusername'],$_SESSION['dbpassword'],$_SESSION['database'],$_SESSION['email']);
                // install datamodel
                echo "install model<br/>";
                
                InstallerController::installModel();
                // create initial user
                echo "create initial user<br/>";
                InstallerController::createInitialUser($_SESSION['username'], $_SESSION['firstname'], $_SESSION['lastname'], $_SESSION['password'], $_SESSION['email'], $_SESSION['birthdate'], $_SESSION['gender']);
                // redirect to startpage
                NavigationModel::redirect("?session=nodb",false);
                */
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
            case "selectSetup":
                $this->printSelectSetupView();
                break;
            default:
                unset($_SESSION['installMsg']);
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
            <div id="messages"></div>
            <script>
            $("#progressbar").progressbar({
                value: 0
            });
            function tryStep () {
                window.setTimeout(function(){
                    $.get("?action=install&session=nodb&<?php echo session_name()."=".session_id(); ?>", function(data) {
                        try {
                            var response = JSON.parse(data);
                            switch (response["status"]) {
                                case "ok":
                                        $("#messages").append($("<div>",{"class":"ok"}).text(response["message"]));
                                        $("#progressbar").progressbar({value: response["progress"]});
                                        tryStep();
                                        break;
                                case "error":
                                        $("#messages").append($("<div>",{"class":"error"}).text(response["message"]));
                                        $("#messages").append($("<div>",{"class":"error"}).text(response["exception"]));
                                        $("#progressbar").progressbar("option", "disabled", true);
                                        break;
                                case "finnished":
                                        callUrl("<?php echo parent::link(null); ?>");
                                        break;
                                case "wait":
                                        break;
                                }
                            } catch (e) {
                                $("#messages").append($("<div>",{"class":"error"}).html(data));
                            }
                        });
                },1000);
            }
            tryStep();
            </script>
        </div>
        <?php
    }
    
    function printSelectSetupView () {
        
        $setups = array();
        if ($handle = opendir('core/model/install/setups')) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    $setups []= $entry;
                }
            }
        }
        
        $_SESSION["setups"] = $setups;
        
        ?>
        <div class="panel installPanel">
            <h2>Select Setup</h2>
            <p>Please select the setup type that you would like to install.</p>
            <form method="post" action="?action=setSetup&session=nodb">
                <div class="table">
                	<div>
                		<div>
                			<label for="setup">Setups</label>
                    	</div>
                		<div>
                			<select name="setup" class="expand">
                            	<?php
                            	foreach ($setups as $pos => $setup) {
                            	    ?><option value="<?php echo $pos; ?>"<?php if ($pos == 0) echo " selected"; ?>><?php echo substr($setup, 0, -4); ?></option><?php
                            	}
                            	?>
                            </select>
                        </div>
                    </div>
                	<div>
                		<div>
                			<label for="siteName">Name</label>
                		</div>
                		<div>
                			<input type="text" name="siteName" class="expand" value="" placeholder="Name of the website">
                		</div>
                	</div>
                	<div>
                		<div>                
                            <label for="siteDescription">Description</label>
                        </div>
                		<div>
                		    <textarea name="siteDescription" class="expand" placeholder="Description of the website" cols="3" rows="3"></textarea>
                		</div>
                	</div>
                </div>
                <hr/>
                <div class="alignRight">
                    <button type="submit" class="jquiButton btnInstallNext">Load Setup</button>
                </div>
            </form>
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
                    $fullPath = ResourcesModel::resourcePath("backup", $backup);
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