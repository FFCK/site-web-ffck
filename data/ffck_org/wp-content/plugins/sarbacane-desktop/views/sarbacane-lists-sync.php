<?php
/**
 * @author Sarbacane Software
 */
if ( is_plugin_active( SARBACANE__PLUGIN_DIRNAME."/sarbacane.php" ) ) {
	wp_enqueue_style ( "sarbacane_global.css", plugins_url ( "css/sarbacane_global.css" , dirname(__FILE__) ) );
	wp_enqueue_style ( "sarbacane_lists_config.css", plugins_url ( "css/sarbacane_lists_config.css", dirname(__FILE__) ) );
	wp_enqueue_style ( "jquery-ui.min.css", plugins_url ( "css/jquery-ui.min.css", dirname(__FILE__) ) );
	wp_enqueue_style ( "jquery-ui.theme.min.css", plugins_url ( "css/sarbacane_lists_config.css", dirname(__FILE__) ) );
	wp_enqueue_script( "sarbacanedesktop-lists-sync.js",plugins_url("js/sarbacanedesktop-lists-sync.js", dirname(__FILE__)),array('jquery','jquery-ui-dialog'));
}
$sarbacane_news_list = get_option('sarbacane_news_list',false);
$sarbacane_users_list = get_option('sarbacane_users_list',false);

$sarbacane_theme_sync = get_option('sarbacane_theme_sync',false);
$sarbacane_blog_content = get_option('sarbacane_blog_content',false);
$sarbacane_media_content = get_option('sarbacane_media_content',false);
$sarbacane_rss_data = get_option('sarbacane_rss_data',false);
?>
<script type="text/javascript">
	var okButton = "<?php _e('yes','sarbacane-desktop')?>";
	var noButton = "<?php _e('no','sarbacane-desktop')?>";
</script>
<div id="sarbacane_desktop_content">
	<p class="<?php _e('sarbacane_desktop','sarbacane-desktop')?>_logo"></p>
	<div id="sarbacane_desktop_configuration">
		<form method="POST" action="">
			<div class="sarbacane_desktop_configuration_panel">
				<p class="sarbacane_desktop_configuration_title">
					<?php _e('Sarbacane Desktop\'s plugin setup','sarbacane-desktop')?>
				</p>
			
				<p class="sarbacane_desktop_div_splitter"></p>
				<p class="sarbacane_desktop_configuration_subtitle">
					<?php _e('Lists synchronization','sarbacane-desktop')?>
				</p>	
				
				<p class="sarbacane_desktop_config_label">
					<input type="checkbox" name="sarbacane_users_list" id="sarbacane_users_list" value="true" <?php if($sarbacane_users_list){ echo 'checked="checked"';}?> /><label for="sarbacane_users_list"><?php _e('Synchronize a \'\'WordPress Users\'\' list','sarbacane-desktop')?></label><br />
					<?php _e('Creates a WordPress users list in Sarbacane Desktop with all users who have an account on your blog or website.','sarbacane-desktop')?>
				</p>
				<p class="sarbacane_desktop_config_label">
					<input type="checkbox" name="sarbacane_news_list" onclick="newsListChange(this)" id="sarbacane_news_list" value="true" <?php if($sarbacane_news_list){ echo 'checked="checked"';}?> /><label for="sarbacane_news_list"><?php _e('Automatically synchronize your subscriber list','sarbacane-desktop')?></label><br />
					<?php _e('Enables the widget menu on the left menu. It allows you to create an opt-in form which adds subscribers to a list in Sarbacane Desktop. This contact list will only be accessible in Sarbacane Desktop','sarbacane-desktop')?>
				</p>
			</div>		
			<div class="sarbacane_desktop_configuration_panel">
				<p class="sarbacane_desktop_div_splitter"></p>
				<p class="sarbacane_desktop_configuration_subtitle">
					<?php _e('Advanced settings','sarbacane-desktop')?>
				</p>
				<p class="sarbacane_desktop_config_label">
					<input type="checkbox" name="sarbacane_theme_sync" id="sarbacane_theme_sync" value="true" <?php if($sarbacane_theme_sync){ echo 'checked="checked"';}?> /><label for="sarbacane_theme_sync"><?php _e('Synchronize your WordPress theme','sarbacane-desktop')?></label><br />
					<?php _e('Import the four main colors of your blog into a custom theme for the EmailBuilder','sarbacane-desktop')?>
				</p>
				<p class="sarbacane_desktop_config_label">
					<input type="checkbox" name="sarbacane_blog_content" id="sarbacane_blog_content" value="true" <?php if($sarbacane_blog_content){ echo 'checked="checked"';}?> /><label for="sarbacane_blog_content"><?php _e('Synchronize blog content','sarbacane-desktop')?></label><br />
					<?php _e('Import all your post content in the EmailBuilder\'s blocks','sarbacane-desktop')?>
				</p>
				<p class="sarbacane_desktop_config_label" style="display:none;">
					<input type="checkbox" name="sarbacane_media_content" id="sarbacane_media_content" value="true" <?php if($sarbacane_media_content){ echo 'checked="checked"';}?> /><label for="sarbacane_media_content"><?php _e('Synchronize media library','sarbacane-desktop')?></label><br />
					<?php _e('Import elements from your WordPress media library into the EmailBuilder image blocks','sarbacane-desktop')?>
				</p>
				<p class="sarbacane_desktop_config_label">
					<input type="checkbox" name="sarbacane_rss_data" id="sarbacane_rss_data" value="true" <?php if($sarbacane_rss_data){ echo 'checked="checked"';}?> /><label for="sarbacane_rss_data"><?php _e('Synchronize RSS data','sarbacane-desktop')?></label><br />
					<?php _e('Add your blog as a source for the EmailBuilder\'s RSS module','sarbacane-desktop')?>
				</p>
			</div>
			<div id="sarbacane_desktop_configuration_footer">
				<p class="sarbacane_desktop_configuration_footer_help sarbacane_desktop_configuration_button_container">
					<input type="submit" class="sarbacane_desktop_configuration_button sarbacane_desktop_configuration_button_green" value="<?php _e('save','sarbacane-desktop')?>"/>
				</p>
			</div>
			<input type="hidden" name="sarbacane_config" value="1"/>
		</form>
	</div>
	<div id="sarbacane_desktop_help">
		<div class="sarbacane_desktop_help_title">
			<?php _e('Need help ?','sarbacane-desktop')?>
		</div>
		<p><?php _e('email','sarbacane-desktop')?> : <?php _e('support@sarbacane.com','sarbacane-desktop')?><br />
		<?php _e('tel','sarbacane-desktop')?> : <?php _e('+33(0) 328 328 040','sarbacane-desktop')?></p>
		<p><?php _e('For more informations, please take a look to our website','sarbacane-desktop')?> : <br /> <a href="<?php _e('http://sarbacane.com/?utm_source=module-wordpress&utm_medium=plugin&utm_content=lien-sarbacane&utm_campaign=wordpress','sarbacane-desktop'); ?>"><?php _e('http://www.sarbacane.com','sarbacane-desktop')?></a>
		</p>
	</div>
</div>
<div id="modalBox" style="display:none;">
<?php _e('caution_disabling_this_list_will_also_disable_the_widget_sarbacane_desktop_s_list_will_be_deleted_do_you_want_to_continue','sarbacane-desktop')?>
</div>
