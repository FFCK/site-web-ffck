<?php
/**
 * @package sarbacane
 * @version 1.4
 */
/*
 * Plugin Name: Sarbacane
 * Plugin URI: http://wordpress.org/plugins/sarbacane/
 * Description: This plugin allows you to synchronize your WordPress data in Sarbacane Desktop
 * Author: Sarbacane Software
 * Version: 1.4
 * Author URI: http://sarbacane.com/?utm_source=module-wordpress&utm_medium=plugin&utm_content=lien-sarbacane&utm_campaign=wordpress
 * Text Domain: sarbacane-desktop
 * Domain Path: /locales
 */
define ( 'SARBACANE__PLUGIN_DIR', plugin_dir_path ( __FILE__ ) );
define ( 'SARBACANE__PLUGIN_DIRNAME', 'sarbacane-desktop' );

require_once ('class.sarbacane.php');
require_once ('class.sarbacane-widget.php');
require_once ('class.sarbacane-newsletterwidget.php');
require_once ('class.sarbacane-lists-sync.php');
require_once ('class.sarbacane-about.php');
require_once ('class.sarbacane-allcontent.php');
require_once ('class.sarbacane-content.php');
require_once ('class.sarbacane-settings.php');
require_once ('class.sarbacane-medias.php');

$sarbacane_instance = new Sarbacane ();
$sarbacane_widget = new SarbacaneWidget ();
$sarbacane_news_instance = new SarbacaneNewsWidget ();
$sarbacane_lists_sync = new SarbacaneListsSync ();
$sarbacane_about = new SarbacaneAbout ();
$sarbacane_allcontent = new SarbacaneAllContent ();
$sarbacane_content = new SarbacaneContent ();

$sarbacane_settings = new SarbacaneSettings ();
$sarbacane_medias = new SarbacaneMedias ();

register_activation_hook ( __FILE__, array ('Sarbacane','plugin_activation' ) );
register_deactivation_hook ( __FILE__, array ('Sarbacane','plugin_deactivation' ) );

// Locale init, menu init and widget init
add_action ( 'plugins_loaded', array ($sarbacane_instance,'sarbacane_load_locales' ) );
add_action ( 'admin_menu', array ($sarbacane_instance,'sarbacane_admin_menu' ) );
add_action ( 'sarbacane-getlist', array ($sarbacane_instance,'sarbacane_get_list' ), 10, 3 );
add_action ( 'sarbacane-deletesdid', array ($sarbacane_instance,'sarbacane_delete_sdid' ), 10, 1 );
add_action ( 'sarbacane-paramssaved', array ($sarbacane_instance,'sarbacane_flash_message' ) );
add_action ( 'sarbacane-savewidget', array ($sarbacane_widget,'sarbacane_save_widget' ) );
add_action ( 'sarbacane_allarticles', array ($sarbacane_allcontent,'get_articles_rss' ), 10,1 );
add_action ( 'sarbacane_article', array ($sarbacane_content,'get_article_rss' ), 10, 1 );
add_action ( 'sarbacane_settings', array ($sarbacane_settings,'get_settings' ) );
add_action ( 'sarbacane_medias', array ($sarbacane_medias,'get_medias' ) );
add_action ('profile_update', array($sarbacane_instance,'trigger_user_update'), 10, 2);
add_action ('delete_user', array($sarbacane_instance,'trigger_user_delete'));
add_action('parse_request', array($sarbacane_instance, 'sarbacane_process_request'));
add_filter('query_vars', array($sarbacane_instance, 'sarbacane_query_vars'));
$sd_list_news = get_option('sarbacane_news_list',false);
if($sd_list_news){
	add_action ( 'widgets_init', array (SarbacaneNewsWidget,'sarbacane_init_widget' ) );
}
