<?php

require_once 'core/plugin.php';
include_once 'modules/editor/wysiwygPageModel.php';

class SocialModule extends XModule {

    function onProcess () {
        
        if (Context::hasRole("social.edit")) {
            
            switch (parent::getAction()) {
                case "save":
                    $socialNetworkValues = array();
                    $socialNetworks = $this->getSocialNetworks();
                    foreach ($_POST["socialButtons"] as $key) {
                        $socialNetworkValues[$key] = $socialNetworks[$key];
                    }
                    parent::param("socialButtons",$socialNetworkValues);
                    parent::redirect();
                    parent::blur();
                    break;
                case "edit":
                    parent::focus();
                    break;
                case "cancel":
                    parent::blur();
            }
        }
    }

    function onView () {
        
        switch (parent::getAction()) {
            case "edit":
                if (Context::hasRole("social.edit")) {
                    $this->printEditView();
                }
                break;
            default:
                $this->printMainView();
        }
    }

    function getRoles () {
        return array("social.edit");
    }

    function getStyles () {
        return array("css/social.css");
    }

    function getScripts () {
        return array("js/social.js");
    }

    function getSocialNetworks () {
        return array(
            "st_formspring_large"=>"Formspring",
            "st_vkontakte_large"=>"Vkontakte",
            "st_yammer_large"=>"Yammer",
            "st_yigg_large"=>" Yigg",
            "st_xing_large"=>"Xing",
            "st_voxopolis_large"=>"VOXopolis",
            "st_xerpi_large"=>"Xerpi",
            "st_xanga_large"=>"Xanga",
            "st_wordpress_large"=>"WordPress",
            "st_reddit_large"=>"Reddit",
            "st_netlog_large"=>"Netlog",
            "st_virb_large"=>"Virb",
            "st_viadeo_large"=>"Viadeo",
            "st_tumblr_large"=>"Tumblr",
            "st_typepad_large"=>"TypePad",
            "st_technorati_large"=>"Technorati",
            "st_stumbleupon_large"=>"StumbleUpon",
            "st_sonico_large"=>"Sonico",
            "st_startlap_large"=>"Startlap",
            "st_startaid_large"=>"Startaid",
            "st_slashdot_large"=>"Slashdot",
            "st_sina_large"=>"Sina",
            "st_segnalo_large"=>"Segnalo",
            "st_newsvine_large"=>"Newsvine",
            "st_raise_your_voice_large"=>"Raise Your Voice",
            "st_orkut_large"=>"Orkut",
            "st_oknotizie_large"=>"Oknotizie",
            "st_mail_ru_large"=>"mail.ru",
            "st_netvouz_large"=>"Netvouz",
            "st_mister_wong_large"=>"Mr Wong",
            "st_moshare_large"=>"moShare",
            "st_mixx_large"=>"Mixx",
            "st_messenger_large"=>"Messenger",
            "st_meneame_large"=>"Meneame",
            "st_google_translate_large"=>"Google Translate",
            "st_livejournal_large"=>"LiveJournal",
            "st_linkagogo_large"=>"linkaGoGo",
            "st_kaboodle_large"=>"Kaboodle",
            "st_jumptags_large"=>"Jumptags",
            "st_instapaper_large"=>"Instapaper",
            "st_identi_large"=>"identi.ca",
            "st_hyves_large"=>"Hyves",
            "st_hatena_large"=>"Hatena",
            "st_google_reader_large"=>"Google Reader",
            "st_google_bmarks_large"=>"Bookmarks",
            "st_fwisp_large"=>"fwisp",
            "st_google_large"=>"Google",
            "st_friendfeed_large"=>"FriendFeed",
            "st_funp_large"=>"Funp",
            "st_fresqui_large"=>"Fresqui",
            "st_sharethis_large"=>"ShareThis",
            "st_folkd_large"=>"folkd.com",
            "st_fashiolista_large"=>"Fashiolista",
            "st_fark_large"=>"Fark",
            "st_evernote_large"=>"Evernote",
            "st_care2_large"=>"Care2",
            "st_edmodo_large"=>"Edmodo",
            "st_dzone_large"=>"DZone",
            "st_dotnetshoutout_large"=>".net Shoutout",
            "st_diigo_large"=>"Diigo",
            "st_digg_large"=>"Digg",
            "st_delicious_large"=>"Delicious",
            "st_dealsplus_large"=>"Dealspl.us",
            "st_current_large"=>"Current",
            "st_corkboard_large"=>"Corkboard",
            "st_corank_large"=>"coRank",
            "st_connotea_large"=>"Connotea",
            "st_citeulike_large"=>"CiteULike",
            "st_chiq_large"=>"chiq",
            "st_bus_exchange_large"=>"Add to BX",
            "st_brainify_large"=>"Brainify",
            "st_buddymarks_large"=>"BuddyMarks",
            "st_googleplus_large"=>"Google +",
            "st_blogger_large"=>"Blogger",
            "st_blogmarks_large"=>"Blogmarks",
            "st_blip_large"=>"Blip",
            "st_blinklist_large"=>"Blinklist",
            "st_bebo_large"=>"Bebo",
            "st_arto_large"=>"Arto",
            "st_baidu_large"=>"Baidu",
            "st_amazon_wishlist_large"=>"Amazon Wishlist",
            "st_allvoices_large"=>"Allvoices",
            "st_adfty_large"=>"Adfty",
            "st_facebook_large"=>"Facebook",
            "st_twitter_large"=>"Tweet",
            "st_linkedin_large"=>"LinkedIn",
            "st_pinterest_large"=>"Pinterest",
            "st_email_large"=>"Email",
            "st_myspace_large"=>"MySpace",
            "st_n4g_large"=>"N4G",
            "st_nujij_large"=>"NUjij",
            "st_odnoklassniki_large"=>"Odnoklassniki",
            "st_speedtile_large"=>"Speedtile",
            "st_stumpedia_large"=>"Stumpedia"
        );
    }

    function printMainView () {
        ?>
        <div class="panel socialPanel">
            <?php
            if (!Common::isEmpty(parent::param("socialButtons"))) {
                foreach (parent::param("socialButtons") as $key => $value) {
                    ?><span class="<?php echo $key; ?>" displayText="<?php echo $value; ?>"></span><?php
                }
            }
            ?>
        </div>
        <?php
    }

    function printEditView () {
        ?>
        <div class="panel socialPanel">
            <form method="post" action="<?php echo parent::link(array("action"=>"save")); ?>">
                <?php
                InputFeilds::printMultiSelect("socialButtons", $this->getSocialNetworks(), parent::param("socialButtons"))
                ?>
                <hr/>
                <div class="alignRight">
                    <button type="submit">Save</button>
                </div>
            </form>
        </div>
        <?php
    }
}

?>