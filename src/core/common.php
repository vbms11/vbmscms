<?php

if (!defined("vbmscms_allowAccess") || vbmscms_allowAccess != true) {
    //NavigationModel::redirect($pageId, $params)
    die("direct access not allowed!");
}

@set_magic_quotes_runtime(0);

if (!@include_once('config.php')) {
    $GLOBALS['noDatabase'] = true;
} else {
    $GLOBALS['noDatabase'] = false;
}

include_once 'core/util/common.php';
include_once 'core/model/translationsModel.php';
include_once 'core/model/sessionModel.php';
include_once 'core/model/resourcesModel.php';
include_once 'core/context.php';
include_once 'core/model/navigationModel.php';
include_once 'core/model/confirmModel.php';
include_once 'core/model/domainsModel.php';
include_once 'core/model/moduleModel.php';
include_once 'core/model/pagesModel.php';
include_once 'core/model/templateModel.php';
include_once 'core/model/usersModel.php';
include_once 'core/model/eventsModel.php';
include_once 'core/model/languagesModel.php';
include_once 'core/model/logDataModel.php';
include_once 'core/util/infoMessages.php';
include_once 'core/util/captcha.php';
include_once 'core/ddm/dmObject.php';
include_once 'core/ddm/dmSerializer.php';
include_once 'core/ddm/dataModel.php';
include_once 'core/ddm/dataView.php';
include_once 'core/model/menuModel.php';
include_once 'core/template/templateParser.php';
include_once 'core/template/templateRenderer.php';
include_once 'core/template/editableTemplate.php';
include_once 'resource/js/valums-file-uploader/server/php.php';
include_once 'core/model/installerModel.php';

?>