<?php

if (!defined("vbmscms_allowAccess") || vbmscms_allowAccess != true) {
    //NavigationModel::redirect($pageId, $params)
    die("direct access not allowed!");
}

// @set_magic_quotes_runtime(0);

include_once __DIR__.'/config.php';

Config::load();


require_once __DIR__.'/database/sdbau.php';

$db = sdbau\getDatabaseConnection(Config::getDBHost(),Config::getDBUser(),Config::getDBPassword(),Config::getDBName());
$db->driver->tablePrefix = Config::getDbTablePrefix();

require_once __DIR__.'/errorHandler.php';
require_once __DIR__.'/selection.php';
require_once __DIR__.'/template/templateParser.php';
require_once __DIR__.'/template/baseRenderer.php';
require_once __DIR__.'/template/ajaxRenderer.php';
require_once __DIR__.'/template/vcmsRenderer.php';
require_once __DIR__.'/template/templateRenderer.php';
require_once __DIR__.'/template/adminIframeRenderer.php';
require_once __DIR__.'/template/editableTemplate.php';
require_once __DIR__.'/template/editableTemplatePreview.php';

require_once __DIR__.'/util/log.php';
require_once __DIR__.'/util/http.php';
require_once __DIR__.'/util/image.php';
require_once __DIR__.'/util/video.php';
require_once __DIR__.'/util/gradient.php';
require_once __DIR__.'/util/input.php';
require_once __DIR__.'/util/email.php';
require_once __DIR__.'/util/common.php';
require_once __DIR__.'/util/countries.php';
require_once __DIR__.'/util/fileSystem.php';

require_once 'resource/js/valums-file-uploader/server/php.php';

require_once __DIR__.'/model/iconModel.php';
require_once __DIR__.'/model/galleryModel.php';
require_once __DIR__.'/model/socialNotificationsModel.php';
require_once __DIR__.'/model/rolesModel.php';
include_once __DIR__.'/model/sitesModel.php';
include_once __DIR__.'/model/cmsVersionModel.php';
include_once __DIR__.'/model/cmsCustomerModel.php';
include_once __DIR__.'/model/resourcesModel.php';
include_once __DIR__.'/model/translationsModel.php';
include_once __DIR__.'/model/sessionModel.php';
include_once __DIR__.'/model/resourcesModel.php';
include_once __DIR__.'/model/navigationModel.php';
include_once __DIR__.'/model/confirmModel.php';
include_once __DIR__.'/model/domainsModel.php';
include_once __DIR__.'/model/moduleInstanceModel.php';
include_once __DIR__.'/model/moduleModel.php';
include_once __DIR__.'/model/pagesModel.php';
include_once __DIR__.'/model/templateModel.php';
require_once __DIR__.'/model/codeModel.php';
include_once __DIR__.'/model/menuModel.php';
include_once __DIR__.'/model/usersModel.php';

include_once __DIR__.'/model/userAddressModel.php';
include_once __DIR__.'/model/userFriendModel.php';
include_once __DIR__.'/model/eventsModel.php';
include_once __DIR__.'/model/languagesModel.php';

include_once __DIR__.'/serialize/serializer.php';
include_once __DIR__.'/serialize/roleSerializer.php';
include_once __DIR__.'/serialize/userSerializer.php';
include_once __DIR__.'/serialize/siteSerializer.php';
include_once __DIR__.'/serialize/moduleSerializer.php';
include_once __DIR__.'/serialize/templateSerializer.php';

include_once __DIR__.'/controller/installerController.php';
include_once __DIR__.'/controller/socialController.php';
include_once __DIR__.'/controller/navigationController.php';
include_once __DIR__.'/controller/templateController.php';
include_once __DIR__.'/controller/moduleController.php';
include_once __DIR__.'/controller/siteController.php';

include_once __DIR__.'/context.php';
include_once __DIR__.'/session.php';
include_once __DIR__.'/util/infoMessages.php';
include_once __DIR__.'/util/captcha.php';
include_once __DIR__.'/ddm/dmObject.php';
include_once __DIR__.'/ddm/dmSerializer.php';
include_once __DIR__.'/ddm/dataModel.php';
include_once __DIR__.'/ddm/dataView.php';

//SiteController::exportSite(Context::getSiteId(), ResourcesModel::getResourcePath("export/test"));
                    
//exit;
