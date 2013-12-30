<?php

require_once 'core/plugin.php';

class StatisticsModule extends XModule {
    
    function onProcess () {
        
        switch (parent::getAction()) {
            default:
                break;
        }
    }
    
    function onView () {
        
        switch (parent::getAction()) {
            default:
                $this->renderMainView();
        }
    }
    
    function renderMainView() {
        $statisticsUrl = "modules/statistics/piwik/index.php?module=Widgetize&action=iframe&moduleToWidgetize=Dashboard&actionToWidgetize=index&period=week&date=today";
        $customer = CmsCustomerModel::getCmsCustomer(Context::getUserId());
        $piwikUserName = PiwikModel::getCmsCustomerUserName($customer->id);
        $piwikAuthToken = PiwikModel::getAdminAuthToken($piwikUserName,md5(Common::hash($piwikUserName)));
        $site = SiteModel::getSite(Context::getSiteId());
        $statisticsUrl .= "&idSite=".$site->piwikid."&token_auth=".$piwikAuthToken;
        ?>
        <div class="panel adminStatisticsPanel">
            <div class="adminStatisticsTabs">
                <ul>
                    <li><a href="#statisticsTab"><?php echo parent::getTranslation("admin.statistics.tab.label"); ?></a></li>
                </ul>
                <div id="statisticsTab">
                    <iframe id="statisticsIFrame" style="width:100%; overflow:hidden; border:0px none;" src="<?php echo $statisticsUrl; ?>" ></iframe>
                </div>
            </div>
        </div>
        <script type="text/javascript">
        $(".adminStatisticsTabs").tabs();
        function autoIframe(frameId) {
            try {
               frame = document.getElementById(frameId);
               innerDoc = (frame.contentDocument) ? frame.contentDocument : frame.contentWindow.document;
               $("#"+frameId).css({height:innerDoc.body.scrollHeight});
            }
            catch(err) {
            }
         }
         function resizeStatisticsIFrame () {
             autoIframe("statisticsIFrame");
         }
         window.setInterval("resizeStatisticsIFrame()",1000);
        </script>
        <?php
    }
    
}

?>