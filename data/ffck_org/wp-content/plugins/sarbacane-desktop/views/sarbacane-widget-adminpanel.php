<?php 
/**
 * @author Sarbacane Software
 */
?>
<script type="text/javascript">
	var fieldNumber = <?php echo sizeof($fields)?>;
	var labelLegend = "<?php _e('Name','sarbacane-desktop')?>"
	var fieldLegend= "<?php _e('placeholder','sarbacane-desktop')?>"
	var mandatoryLegend= "<?php _e('Required fields','sarbacane-desktop')?>"
	
</script>
<div id="sarbacane_desktop_content">
	<p class="<?php _e('sarbacane_desktop','sarbacane-desktop')?>_logo"></p>
	<!-- ========================================================================================== -->
	<!-- =====================================WIDGET SETUP========================================= -->
	<!-- ========================================================================================== -->
	<div id="sarbacane_desktop_widget">
		<form method="POST" action="" id="sarbacane_desktop_widget_form">
			<p class="sarbacane_desktop_configuration_title">
				<?php _e('Widget settings','sarbacane-desktop')?>
			</p>
			
			<p class="sarbacane_desktop_div_splitter"></p>
			<!-- ================================WIDGET FIELDS================================= -->
			<label class="sarbacane_desktop_configuration_label" for="sarbacane_desktop_widget_title">
				<?php _e('Title','sarbacane-desktop')?> : 
			</label>
			<input type="text" name="sarbacane_widget_title" id="sarbacane_desktop_widget_title" onkeyup="javascript:displayPreview()" class="sarbacane_desktop_configuration_input sarbacane_desktop_configuration_input_large" value="<?php echo esc_html(stripslashes($title))?>"/>
			
			<p class="sarbacane_desktop_div_splitter"></p>
			
			<label class="sarbacane_desktop_configuration_label" for="sarbacane_desktop_widget_description">
				<?php _e('Description','sarbacane-desktop')?> : 
			</label>
			<textarea name="sarbacane_widget_description" id="sarbacane_desktop_widget_description" class="sarbacane_desktop_configuration_input sarbacane_desktop_configuration_input_large sarbacane_desktop_huge_field" onkeyup="javascript:displayPreview()"><?php echo esc_html(stripslashes($description))?></textarea>
			
			<p class="sarbacane_desktop_div_splitter"></p>
			
			<!-- ================================CUSTOM FIELDS================================= -->
			<?php 
			$i = 0;
			foreach($fields as $field){
				$isEmail = false;		
				if($field->label == __('email','sarbacane-desktop') || $field->label == strtolower(__('email','sarbacane-desktop'))){
					$isEmail = true;
				}	
			?>
			<div id="sarbacane_desktop_widget_field_<?php echo $i?>">
				<div class="sarbacane_desktop_widget_summary">
					<label class="sarbacane_desktop_field_number"><?php _e('Field','sarbacane-desktop'); echo ' '.($i+1)?></label>
					<ul class="sarbacane_widget_menu">
						<li class="sarbacane_desktop_menu_item sarbacane_desktop_trash <?php if($isEmail){ echo "sarbacane_desktop_menu_item_disabled_email";}?>" <?php if(!$isEmail){?> onclick="javascript:supprimerChamp(<?php echo $i?>)" <?php }?>></li>
						<li class="sarbacane_desktop_menu_item sarbacane_desktop_down" onclick="javascript:moveDown(<?php echo $i?>)"></li>
						<li class="sarbacane_desktop_menu_item sarbacane_desktop_up" onclick="javascript:moveUp(<?php echo $i?>)"></li>
					</ul>
				</div>
				<p class="sarbacane_desktop_widget_confguration">
				<label class="sarbacane_desktop_inline_configuration_label " for="sarbacane_desktop_label_<?php echo $i?>"><?php _e('Name','sarbacane-desktop')?>&nbsp;:&nbsp;</label>
				<input type="text" name="sarbacane_label_<?php echo $i?>" id="sarbacane_desktop_label_<?php echo $i?>" value="<?php echo stripslashes(esc_html($field->label))?>" class="sarbacane_desktop_configuration_input" <?php if($isEmail){ echo 'readonly="readonly"';}?> onkeyup="javascript:displayPreview()"/><br />
				<label class="sarbacane_desktop_inline_configuration_label " for="sarbacane_desktop_field_<?php echo $i?>"><?php _e('placeholder','sarbacane-desktop')?>&nbsp;:&nbsp;</label>
				<input type="text" name="sarbacane_field_<?php echo $i?>" id="sarbacane_desktop_field_<?php echo $i?>" class="sarbacane_desktop_configuration_input " value="<?php echo stripslashes(esc_html($field->placeholder)) ?>" onkeyup="javascript:displayPreview()"/><br />
				<label class="sarbacane_desktop_inline_configuration_label " for="sarbacane_desktop_mandatory_<?php echo $i?>"><?php _e('Mandatory','sarbacane-desktop')?>&nbsp;:&nbsp;</label>
				<input type="radio" name="sarbacane_mandatory_<?php echo $i?>" id="sarbacane_desktop_mandatory_true_<?php echo $i?>" value="true" <?php if($field->mandatory){echo ' checked="checked" ';} ?> <?php if($isEmail){ echo 'disabled="disabled"';}?> onclick="javascript:displayPreview()"/><label class="sarbacane_desktop_yes_no_label" for="sarbacane_desktop_mandatory_true_<?php echo $i?>"><?php _e('yes','sarbacane-desktop')?></label>
				<input type="radio" name="sarbacane_mandatory_<?php echo $i?>" id="sarbacane_desktop_mandatory_false_<?php echo $i?>" value="false" <?php if(!$field->mandatory ){echo ' checked="checked" ';} ?> <?php if($isEmail){ echo 'disabled="disabled"';}?> onclick="javascript:displayPreview()"/><label class="sarbacane_desktop_yes_no_label" for="sarbacane_desktop_mandatory_false_<?php echo $i?>"><?php _e('no','sarbacane-desktop')?></label>
				</p>
				<p class="sarbacane_desktop_div_splitter"></p>
			</div>
			<?php 
				$i++;
			 }
			 ?>
			<p id="sarbacane_desktop_champs_complementaires">
				<p><input type="button" class="sarbacane_desktop_configuration_button" value="<?php _e('Add field','sarbacane-desktop')?>" onclick="javascript:ajouterChamp()" id="sarbacane_desktop_add_field"/></p>
				<p style="clear:both;"></p>
			</p>
			
			<p class="sarbacane_desktop_div_splitter"></p>
			
 			<!-- =============================COMPLEMENT FIELDS============================== -->
			<input type="hidden" name="sarbacane_widget_list_type" id="sarbacane_desktop_widget_list_type" />
			
			<label class="sarbacane_desktop_configuration_label" for="sarbacane_desktop_widget_registration_button"><?php _e('Button name','sarbacane-desktop')?> : </label>
				<label class="sarbacane_desktop_inline_configuration_label " for="sarbacane_desktop_widget_registration_button"><?php _e('Name','sarbacane-desktop')?> : </label>
						<input type="text" name="sarbacane_widget_registration_button" id="sarbacane_desktop_widget_registration_button" class="sarbacane_desktop_configuration_input required" required="required"   value="<?php echo esc_html(stripslashes($registration_button))?>" onkeyup="javascript:displayPreview()" />

			<p class="sarbacane_desktop_div_splitter"></p>
			
			<label class="sarbacane_desktop_configuration_label" for="sarbacane_desktop_widget_registration_message"><?php _e('Successful form submission message','sarbacane-desktop')?> : </label>
			<textarea name="sarbacane_widget_registration_message" id="sarbacane_desktop_widget_registration_message" class="sarbacane_desktop_configuration_input sarbacane_desktop_configuration_input_large sarbacane_desktop_huge_field required" required="required" onkeyup="javascript:displayPreview()"><?php echo esc_html(stripslashes($registration_message))?></textarea>

			<p class="sarbacane_desktop_div_splitter"></p>		
			<input type="hidden" name="sarbacane_field_number" id="sarbacane_desktop_field_number" value="" />
			<input type="hidden" name="sarbacane_save_configuration" id="sarbacane_desktop_save_configuration" value="true" />
		</form>
		<div id="sarbacane_desktop_configuration_footer">
			<input type="button" class="sarbacane_desktop_configuration_button sarbacane_desktop_configuration_button_green" value="<?php _e('Save','sarbacane-desktop')?>" onclick="javascript:submitForm()" />
		</div>
	</div>
	<!-- ========================================================================================== -->
	<!-- ===================================WIDGET PREVIEW========================================= -->
	<!-- ========================================================================================== -->
	<div id="sarbacane_widget_preview">
		<p class="sarbacane_widget_configuration_title"><?php _e('preview','sarbacane-desktop')?></p>
		<div id="sarbacane_preview">
			<iframe draggable="false" width="100%" height="500px;" seamless="seamless" scrolling="no" contenteditable="false" border="0"  src="<?php echo plugins_url ( "/views/sarbacane-widget-preview.php", dirname(__FILE__) ) .'?list_type=N'; ?>" ></iframe>
		</div>
	</div>
	<div id="sarbacane_desktop_vertical_splitter"></div>
	<!-- ========================================================================================== -->
	<!-- =================================WIDGET INFORMATIONS====================================== -->
	<!-- ========================================================================================== -->
	<div id="sarbacane_desktop_widget_info">
		<div class="sarbacane_desktop_help_title">
			<?php _e('Information','sarbacane-desktop')?>
		</div>
		<p><?php _e('This tool allows you to create a form widget that you can add to WordPress','sarbacane-desktop')?></p>
		<p><?php _e('The widget will sync subscribers with your Sarbacane Desktop contact list','sarbacane-desktop')?></p>
		<p><?php _e('All data from the widget will be available in your list','sarbacane-desktop')?></p>
		<p><?php _e('Any changes in the structure of the form will cause a refresh of the associated list in Sarbacane Desktop.','sarbacane-desktop')?></p>
		<p class="sarbacane_desktop_div_splitter"></p>
		<div class="sarbacane_desktop_help_title">
			<?php _e('Need help ?','sarbacane-desktop')?>
		</div>
		<p><?php _e('email','sarbacane-desktop')?> : <?php _e('support@sarbacane.com','sarbacane-desktop')?><br />
		<?php _e('tel','sarbacane-desktop')?> : <?php _e('+33(0) 328 328 040','sarbacane-desktop')?></p>
		<p><?php _e('For more informations, please take a look to our website','sarbacane-desktop')?> : <br /> <a href="<?php _e('http://sarbacane.com/?utm_source=module-wordpress&utm_medium=plugin&utm_content=lien-sarbacane&utm_campaign=wordpress','sarbacane-desktop')?>"><?php _e('http://www.sarbacane.com','sarbacane-desktop')?></a></p>
	</div>
	<!-- ========================================================================================== -->
	<!-- =====================================FIELDS PATTERN======================================= -->
	<!-- ========================================================================================== -->
	<div style="display:none" id="fieldPattern">
		<div id="sarbacane_desktop_widget_field_FIELDNUMBER">
			<div class="sarbacane_desktop_widget_summary">
				<label class="sarbacane_desktop_field_number"><?php _e('Field','sarbacane-desktop');?> PLUSONEFIELD </label>
				<ul class="sarbacane_widget_menu">
					<li class="sarbacane_desktop_menu_item sarbacane_desktop_trash" onclick="javascript:supprimerChamp(FIELDNUMBER)"></li>
					<li class="sarbacane_desktop_menu_item sarbacane_desktop_down" onclick="javascript:moveDown(FIELDNUMBER)"></li>
					<li class="sarbacane_desktop_menu_item sarbacane_desktop_up" onclick="javascript:moveUp(FIELDNUMBER)"></li>
				</ul>
			</div>
			<p class="sarbacane_desktop_widget_confguration">
			<label class="sarbacane_desktop_inline_configuration_label " for="sarbacane_desktop_label_FIELDNUMBER"><?php _e('Name','sarbacane-desktop')?> : </label>
			<input type="text" name="sarbacane_label_FIELDNUMBER" id="sarbacane_desktop_label_FIELDNUMBER" value="" class="sarbacane_desktop_configuration_input " onkeyup="javascript:displayPreview()" /><br />
			<label class="sarbacane_desktop_inline_configuration_label " for="sarbacane_desktop_field_FIELDNUMBER"><?php _e('placeholder','sarbacane-desktop')?> : </label>
			<input type="text" name="sarbacane_field_FIELDNUMBER" id="sarbacane_desktop_field_FIELDNUMBER" class="sarbacane_desktop_configuration_input " value="" onkeyup="javascript:displayPreview()" /><br />
			<label class="sarbacane_desktop_inline_configuration_label " for="sarbacane_desktop_mandatory_FIELDNUMBER"><?php _e('Mandatory','sarbacane-desktop')?> : </label>
			<input type="radio" name="sarbacane_mandatory_FIELDNUMBER" id="sarbacane_desktop_mandatory_true_FIELDNUMBER" value="true" onclick="javascript:displayPreview()"/> <label class="sarbacane_desktop_yes_no_label" for="sarbacane_desktop_mandatory_true_FIELDNUMBER"><?php _e('yes','sarbacane-desktop')?></label>
			<input type="radio"  checked="checked"  name="sarbacane_mandatory_FIELDNUMBER" id="sarbacane_desktop_mandatory_false_FIELDNUMBER" value="false"  onclick="javascript:displayPreview()"/><label class="sarbacane_desktop_yes_no_label" for="sarbacane_desktop_mandatory_false_FIELDNUMBER"><?php _e('no','sarbacane-desktop')?></label>
			</p>
			<p class="sarbacane_desktop_div_splitter"></p>
		</div>
	</div>
	<!-- ========================================================================================== -->
	<!-- ============================================DIALOGS======================================= -->
	<!-- ========================================================================================== -->
</div>