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

include_once 'core/template/templateParser.php';
include_once 'core/template/baseRenderer.php';
include_once 'core/template/ajaxRenderer.php';
include_once 'core/template/vcmsRenderer.php';
include_once 'core/template/templateRenderer.php';
include_once 'core/template/editableTemplate.php';
include_once 'core/template/editableTemplatePreview.php';

include_once 'core/util/common.php';
include_once 'resource/js/valums-file-uploader/server/php.php';

require_once 'core/model/galleryModel.php';
require_once 'core/model/socialNotificationsModel.php';
require_once 'core/model/countriesModel.php';
require_once 'core/model/rolesModel.php';
include_once 'core/model/piwikModel.php';
include_once 'core/model/sitesModel.php';
include_once 'core/model/cmsCustomerModel.php';
include_once 'core/model/resourcesModel.php';
include_once 'core/model/translationsModel.php';
include_once 'core/model/sessionModel.php';
include_once 'core/model/resourcesModel.php';
include_once 'core/model/navigationModel.php';
include_once 'core/model/confirmModel.php';
include_once 'core/model/domainsModel.php';
include_once 'core/model/moduleInstanceModel.php';
include_once 'core/model/moduleModel.php';
include_once 'core/model/pagesModel.php';
include_once 'core/model/templateModel.php';
require_once 'core/model/codeModel.php';
include_once 'core/model/menuModel.php';
include_once 'core/model/usersModel.php';
include_once 'core/model/userAddressModel.php';
include_once 'core/model/userFriendModel.php';
include_once 'core/model/eventsModel.php';
include_once 'core/model/languagesModel.php';

include_once 'core/controller/installerController.php';
include_once 'core/controller/socialController.php';
include_once 'core/controller/navigationController.php';
include_once 'core/controller/moduleController.php';

include_once 'core/context.php';
include_once 'core/session.php';
include_once 'core/util/infoMessages.php';
include_once 'core/util/captcha.php';
include_once 'core/ddm/dmObject.php';
include_once 'core/ddm/dmSerializer.php';
include_once 'core/ddm/dataModel.php';
include_once 'core/ddm/dataView.php';

?>