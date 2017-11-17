<?php
/** @author SarbacaneSoftware
 * Pour éviter les soucis de backslash suite à l'activation de magic_quote_gpc, on utilise stripslashes
 * Normalement désactivé avec php 5.4
 */
?>
<script text="text/javascript">
	var emailField = "<?php echo _e('email','sarbacane-desktop') ?>";

</script>
<aside class="widget widget_meta">
	<h2 class="widget-title"><?php  echo stripslashes($title)?></h2>
	<p class="site-description"><?php echo stripslashes($description)?></p>
	<form action="<?php echo  get_site_url().'/index.php?my-plugin=sarbacane'  ?>" method="POST" id="sarbacane_desktop_widget_form_<?php echo $list_type ?>">
		<?php foreach($fields as $field){?>
			<p><label><?php echo stripslashes($field->label)?> <?php if($field->mandatory){echo '*';}?></label>
			<?php
			if (__ ( 'email', 'sarbacane-desktop' ) == $field->label || __ ( 'email', 'sarbacane-desktop' ) == strtolower($field->label)  ) {
				$field_type = 'email';
			} else {
				$field_type = 'text';
			}
			?><br />
			<input type="<?php echo $field_type ?>" id="<?php echo stripslashes(esc_html($field->label))?>_<?php echo $list_type ?>" name="<?php echo stripslashes(esc_html($field->label))?>" placeholder="<?php echo stripslashes(esc_html($field->placeholder))?>" <?php if($field->mandatory){echo 'required class="required"';}?> /></p>
		<?php }?>
		<p><?php _e('Fields marked with * are mandatory','sarbacane-desktop')?></p>
		<input type="hidden" value="<?php echo $list_type ?>" name="list_type" />
		<?php wp_nonce_field('newsletter_registration', 'sarbacane_form_token') ?>
		<input type="button" value="<?php echo stripslashes($registration_button); ?>" onclick="javascript:submitWidget('<?php echo $list_type ?>')" />
	</form>
</aside>