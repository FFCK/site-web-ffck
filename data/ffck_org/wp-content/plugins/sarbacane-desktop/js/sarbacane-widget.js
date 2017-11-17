function submitWidget(list_type){
	//On va gérer les navigateurs sans support du required
	var isSubmitable = true;
	jQuery(".sarbacane_desktop_configuration_input_red").removeClass("sarbacane_desktop_configuration_input_red");
	jQuery("#sarbacane_desktop_widget_form_"+list_type+" .required").each(function(){
		if(jQuery(this).val() == null || jQuery(this).val() == ""){
			isSubmitable = false;
			jQuery(this).addClass("sarbacane_desktop_configuration_input_red");
		}
	})
	var emailValue = jQuery("#sarbacane_desktop_widget_form_"+list_type+" #"+emailField+"_"+list_type).val();
	var regex = new RegExp("[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?","ig");
	if(!regex.test(emailValue)){
		isSubmitable=false;
		jQuery("#sarbacane_desktop_widget_form_"+list_type+" #"+emailField+"_"+list_type).addClass("sarbacane_desktop_configuration_input_red");
	}
	if(isSubmitable){
		jQuery("#sarbacane_desktop_widget_form_"+list_type).submit();
	}
}