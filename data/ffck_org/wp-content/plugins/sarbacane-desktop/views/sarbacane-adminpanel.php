<?php
/**
 * @author Sarbacane Software
 */
if ( is_plugin_active( SARBACANE__PLUGIN_DIRNAME."/sarbacane.php" ) ) {
	wp_enqueue_style ( "sarbacane_global.css", plugins_url ( "/css/sarbacane_global.css", dirname(__FILE__) ) );
	wp_enqueue_style ( "sarbacane_admin_panel.css", plugins_url ( "/css/sarbacane_admin_panel.css", dirname(__FILE__) ) );
}
?>
<div id="sarbacane_desktop_content">

	<p class="<?php _e('sarbacane_desktop','sarbacane-desktop')?>_logo"></p>

	<div id="sarbacane_desktop_configuration">
		<div class="sarbacane_desktop_configuration_panel">
			<p class="sarbacane_desktop_configuration_title">
				<?php _e('configuration','sarbacane-desktop')?>
			</p>
			<p class="sarbacane_desktop_div_splitter"></p>
			<form method="POST">
				<label for="url" class="sarbacane_desktop_configuration_label"><?php _e('URL to paste in Sarbacane Desktop','sarbacane-desktop')?> : </label>
				<input type="text" class="sarbacane_desktop_configuration_input" id="url" name="url" value="<?php echo get_site_url().'/'?>" readonly="readonly" onclick="javascript:this.select()" />
				<p class="sarbacane_desktop_div_splitter"></p>
				<label for="key" class="sarbacane_desktop_configuration_label">
					<?php _e('Synchronization key to enter in Sarbacane Desktop','sarbacane-desktop')?> : 
					<span class="sarbacane_desktop_connection_status">
						<?php 
						if($sdid_array != null && sizeof($sdid_array)>0){
						?>
							<span class='sarbacane_desktop_connection_ok'>
						<?php
							_e('Connected','sarbacane-desktop');
						?>
							</span>
						<?php
						}else{
						?>
							<span class='sarbacane_desktop_connection_nok'>
						<?php
							_e('Disconnected','sarbacane-desktop');
						?>
							</span>
						<?php
						}
						?>
					</span>
				</label> 
				<input type="text" class="sarbacane_desktop_configuration_input" id="key" name="key" value="<?php echo $cle ?>" readonly="readonly" onclick="javascript:this.select()" /> 
				<input type="hidden" name="sarbacane_redo_token" id="sarbacane_redo_token" value="1" />
				<p class="">
				<?php if($cle != null && $cle != ""){?>
					<input type="submit" class="sarbacane_desktop_configuration_button" value="<?php _e('Generate another key','sarbacane-desktop')?>" />
				<?php }else{ ?>
					<input type="submit" class="sarbacane_desktop_configuration_button" value="<?php _e('Generate a key','sarbacane-desktop')?>" />
				<?php }?>
				</p>
			</form>
		</div>
		<div id="sarbacane_desktop_configuration_footer">
			<p class="sarbacane_desktop_configuration_footer_help sarbacane_desktop_configuration_button_container">
				<?php if($sd_list_news){?>
					<input type="button" onclick="javascript:goWidget()" class="sarbacane_desktop_configuration_button sarbacane_desktop_configuration_button_green" value="<?php _e('Setup the widget','sarbacane-desktop')?>"/>
				<?php }?>
			</p>
		</div>
	</div>

	<div id="sarbacane_desktop_help">
		<div class="sarbacane_desktop_help_title">
			<?php _e('How to set up the module ?','sarbacane-desktop')?>
		</div>
		<p><?php _e('Go in the plugins menu of Sarbacane Desktop and activate wordpress plugin','sarbacane-desktop')?></p>
		<!--<p><img src="<?php echo plugin_dir_url(__FILE__)?>/../../images/sd_wordpress_activation.png" /></p>-->
		<p class="sarbacane_desktop_help_subtitle">
			<?php _e('For more details','sarbacane-desktop')?> : <a href="<?php _e('https://www.sarbacane.com/ws/soft-redirect.asp?key=9Y4OtEZzaz&com=WordpressInfo','sarbacane-desktop')?>"><?php _e('Take a look at the help section online','sarbacane-desktop')?></a></p>
		
		<p class="sarbacane_desktop_div_splitter"></p>
		<div class="sarbacane_desktop_help_title">
			<?php _e('Need help ?','sarbacane-desktop')?>
		</div>
		<p><?php _e('email','sarbacane-desktop')?> : <?php _e('support@sarbacane.com','sarbacane-desktop')?><br />
		<?php _e('tel','sarbacane-desktop')?> : <?php _e('+33(0) 328 328 040','sarbacane-desktop')?></p>
		<p><?php _e('For more informations, please take a look to our website','sarbacane-desktop')?> : <br /> <a href="<?php _e('http://sarbacane.com/?utm_source=module-wordpress&utm_medium=plugin&utm_content=lien-sarbacane&utm_campaign=wordpress','sarbacane-desktop')?>"><?php _e('http://www.sarbacane.com','sarbacane-desktop')?></a></p>
	</div>
</div>
<script type="text/javascript">
	function goWidget(){
		document.location = "admin.php?page=wp_news_widget";
	}
</script>
