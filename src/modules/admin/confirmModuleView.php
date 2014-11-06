<?php

require_once 'core/plugin.php';

class ConfirmView extends XModule {

	function onProcess () {
		switch (parent::getAction()) {
			case "confirm":
				$hash = $_GET['code'];
				$confirm = ConfirmModel::getConfirm($hash);
				$confirmAction = NavigationModel::createModuleLink($confirm->moduleid,$confirm->params);
				NavigationModel::redirect($confirmAction);
				break;
		}
	}

	function onView () {
	}

	

}

?>