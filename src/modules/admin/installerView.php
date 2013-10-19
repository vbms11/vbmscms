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
				
				$link = @mysql_connect($_SESSION['hostname'],$_SESSION['dbusername'],$_SESSION['dbpassword']);
				if (!$link) {
					$_SESSION['installMsg'] = "Unable to connect to the database!";
					NavigationModel::redirect("?action=dbConfig&session=nodb",false);
				} else {
					$check = @mysql_select_db($_SESSION['database']);
					if (!$check) {
						$_SESSION['installMsg'] = "Connection established but invalid database name!";
						NavigationModel::redirect("?action=dbConfig&session=nodb",false);
					} else {
						NavigationModel::redirect("?action=printInstallingView&session=nodb",false);
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
				NavigationModel::redirect("?action=dbConfig&session=nodb",false);
				break;
			case "install":
				// create config file
				InstallerModel::buildConfig($_SESSION['hostname'],$_SESSION['dbusername'],$_SESSION['dbpassword'],$_SESSION['database']);
				require_once('config.php');
				// install datamodel
                                InstallerModel::installModel();
				// create initial user
                                InstallerModel::createInitialUser($_SESSION['username'], $_SESSION['firstname'], $_SESSION['lastname'], $_SESSION['password'], $_SESSION['email'], $_SESSION['birthdate']);
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
				$this->printWelcomeView();
				break;
		}
	}
	
	function printInstallingView () {
		?>
		<div class="panel installPanel">
			<h2>Installation Progress</h2>
			The cms is installing the datamodel, This may take several minutes.
			<hr/>
			<div id="progressbar"></div>
                        <a href="?action=install&<?php echo session_name()."=".session_id(); ?>">install</a>
			<script>
			$("#progressbar").progressbar({
				value: 100
				
			});
			function gotoLogin (data) {
				callUrl("");
			}
		/*	$.ajax({
                    "url": "?action=install&<?php echo session_name()."=".session_id(); ?>",
                    "context": document.body,
                    "success": function(data){
                        gotoLogin(data);
                    }
                });*/
			</script>
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
				<table class="expand"><tr>
				<td class="contract">Username: </td>
				<td class="expand"><?php InputFeilds::printTextFeild("username","","expand"); ?></td>
				</tr><tr>
				<td class="contract">FirstName: </td>
				<td class="expand"><?php InputFeilds::printTextFeild("firstname","","expand"); ?></td>
				</tr><tr>
				<td class="contract">LastName: </td>
				<td class="expand"><?php InputFeilds::printTextFeild("lastname","","expand"); ?></td>
				</tr><tr>
				<td class="contract">Password: </td>
				<td class="expand"><?php InputFeilds::printTextFeild("password","","expand"); ?></td>
				</tr><tr>
				<td class="contract">E-mail: </td>
				<td class="expand"><?php InputFeilds::printTextFeild("email","","expand"); ?></td>
				</tr><tr>
				<td class="contract">Birthdate: </td>
				<td class="expand"><?php InputFeilds::printDataPicker("birthdate",""); ?></td>
				</tr></table>
				<hr/>
				<div class="alignRight">
					<button type="submit" class="btnInstallNext">Next</button>
				</div>
			</form>
			<script>
			$(".btnInstallNext").button();
			</script>
		</div>
		<?php
	}

	function printWelcomeView () {
		?>
		<div class="panel installPanel">
			<h2>Welcome to vbmscms</h2>
			This is a step by step wizard that will install vbmscms on the server 
			where this script is being executed! The only requirement is a working mysqlserver and php 5+
			<hr/>
			<div class="alignRight">
				<button type="button" class="btnInstallNext">Next</button>
			</div>
			<script>
			$(".btnInstallNext").button().click(function(e){
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
			Enter the database credentials so that the datamodel can be installed! 
			<hr/>
			<?php
			if (isset($_SESSION['installMsg']) && !Common::isEmpty($_SESSION['installMsg'])) {
				echo "<span style='color:red;'>";
				echo $_SESSION['installMsg'];
				echo "</span><hr/>";
			}
			?>
			<form method="post" action="?action=saveDbConfig&session=nodb">
				<table class="expand"><tr>
				<td class="contract">Hostname: </td>
				<td class="expand"><?php InputFeilds::printTextFeild("hostname",isset($_POST['hostname']) ? $_POST['hostname'] : "","expand"); ?></td>
				</tr><tr>
				<td class="contract">Database: </td>
				<td class="expand"><?php InputFeilds::printTextFeild("database",isset($_POST['database']) ? $_POST['database'] : "","expand"); ?></td>
				</tr><tr>
				<td class="contract">Username: </td>
				<td class="expand"><?php InputFeilds::printTextFeild("username",isset($_POST['username']) ? $_POST['username'] : "","expand"); ?></td>
				</tr><tr>
				<td class="contract">Password: </td>
				<td class="expand"><?php InputFeilds::printTextFeild("password",isset($_POST['password']) ? $_POST['password'] : "","expand"); ?></td>
				</tr></table>
				<hr/>
				<div class="alignRight">
					<button type="submit" class="btnInstallNext">Next</button>
				</div>
			</form>
			<script>
			$(".btnInstallNext").button();
			</script>
		</div>
		<?php
	}

}

?>