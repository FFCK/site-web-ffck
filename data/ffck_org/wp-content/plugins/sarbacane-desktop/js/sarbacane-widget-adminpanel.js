jQuery(document).ready(function(){
	displayPreview();
	enableDisabledItemMenu();
});
/**
 * This function copies the pattern and add it to the fields list.
 * It triggers the preview rendering
 */
function ajouterChamp(){
	var fieldNumberPlusOne = fieldNumber + 1;
	if(fieldNumber< 10 ){
		jQuery("#sarbacane_desktop_champs_complementaires").append(
			jQuery("#fieldPattern").clone().html().replace(/(FIELDNUMBER)/gi,fieldNumber).replace(/(PLUSONEFIELD)/g,fieldNumberPlusOne)
		);
	}else{
		jQuery("#tooMuchField").dialog();
	}
	fieldNumber++;
	displayPreview();
	enableDisabledItemMenu();
}
/**
 * @param numeroChamp
 */
function supprimerChamp(numeroChamp){
	jQuery("#sarbacane_desktop_widget_field_"+numeroChamp).remove();
	fieldNumber--;
	reorderFields();
}

function submitForm(){
	jQuery(".sarbacane_desktop_configuration_input_red").removeClass("sarbacane_desktop_configuration_input_red");
	var isSubmitable = true;
	console.log(fieldNumber);
	jQuery("#sarbacane_desktop_field_number").val(fieldNumber);
	for(var i = 0;i<fieldNumber;i++){
		var labelField = jQuery("input[id^='sarbacane_desktop_label_"+i+"']").val();
		var placeholderField = jQuery("input[id^='sarbacane_desktop_field_"+i+"']").val();
		if((labelField == null || labelField == "") && (placeholderField == null || placeholderField == "")){
			jQuery("input[id^='sarbacane_desktop_label_"+i+"']").addClass("sarbacane_desktop_configuration_input_red");
			jQuery("input[id^='sarbacane_desktop_field_"+i+"']").addClass("sarbacane_desktop_configuration_input_red");
			isSubmitable = false;
		} 
	}
	jQuery("#sarbacane_desktop_widget_form .required").each(function(){
		if(jQuery(this).val() == null && jQuery(this).val() == ""){
			isSubmitable = false;
			jQuery(this).addClass("sarbacane_desktop_configuration_input_red");
		}
	});
	if(jQuery("#sarbacane_desktop_widget_registration_button").val() == null || jQuery("#sarbacane_desktop_widget_registration_button").val() == ""){
		isSubmitable = false;
		jQuery("#sarbacane_desktop_widget_registration_button").addClass("sarbacane_desktop_configuration_input_red");
	} 
	if(jQuery("#sarbacane_desktop_widget_registration_message").val() == null || jQuery("#sarbacane_desktop_widget_registration_message").val() == ""){
		isSubmitable = false;
		jQuery("#sarbacane_desktop_widget_registration_message").addClass("sarbacane_desktop_configuration_input_red");
	} 
	if(isSubmitable){
		jQuery(":disabled").removeAttr("disabled");
		jQuery("#sarbacane_desktop_widget_form").submit();
	}
	displayPreview();
}
function moveUp(uppingNumber){
	var uppingFieldNumber = uppingNumber+1;
	var downingNumber = uppingNumber-1;
	var downingFieldNumber = downingNumber+1;
	
	//We ensure fields value are set in the DOM
	jQuery("#sarbacane_desktop_widget_field_"+uppingNumber+" input[type='text']").each(function(){
		jQuery(this).attr("value",jQuery(this).val());
	});
	jQuery("#sarbacane_desktop_widget_field_"+uppingNumber+" input[type='radio']").each(function(){
		if(jQuery(this).is(":checked")){
			jQuery(this).attr("checked","checked");
		}
	});
	
	jQuery("#sarbacane_desktop_widget_field_"+downingNumber+" input[type='text']").each(function(){
		jQuery(this).attr("value",jQuery(this).val());
	});
	jQuery("#sarbacane_desktop_widget_field_"+downingNumber+" input[type='radio']").each(function(){
		if(jQuery(this).is(":checked")){
			jQuery(this).attr("checked","checked");
		}
	});

	var uppingRegex = new RegExp(uppingNumber,"g");
	var uppingFieldRegex = new RegExp(uppingFieldNumber,"g");

	var downingRegex = new RegExp(downingNumber,"g");
	var downingFieldRegex = new RegExp(downingFieldNumber,"g");

	var upping = jQuery("#sarbacane_desktop_widget_field_"+uppingNumber).html();
	upping = upping.replace(uppingRegex,downingNumber);
	upping = upping.replace(uppingFieldRegex,downingFieldNumber);
	
	var downing = jQuery("#sarbacane_desktop_widget_field_"+downingNumber).html();
	downing = downing.replace(downingFieldRegex,uppingFieldNumber);
	downing = downing.replace(downingRegex,uppingNumber);
	
	jQuery("#sarbacane_desktop_widget_field_"+downingNumber).html(upping);
	jQuery("#sarbacane_desktop_widget_field_"+uppingNumber).html(downing);

	
	displayPreview();
	enableDisabledItemMenu();
}
function moveDown(downingNumber){
	
	var downingFieldNumber = downingNumber+1;
	var uppingNumber = downingNumber+1;
	var uppingFieldNumber = uppingNumber+1;

	//We ensure fields value are set in the DOM
	jQuery("#sarbacane_desktop_widget_field_"+uppingNumber+" input[type='text']").each(function(){
		jQuery(this).attr("value",jQuery(this).val());
	});
	jQuery("#sarbacane_desktop_widget_field_"+uppingNumber+" input[type='radio']").each(function(){
		if(jQuery(this).is(":checked")){
			jQuery(this).attr("checked","checked");
		}
	});
	
	jQuery("#sarbacane_desktop_widget_field_"+downingNumber+" input[type='text']").each(function(){
		jQuery(this).attr("value",jQuery(this).val());
	});
	jQuery("#sarbacane_desktop_widget_field_"+downingNumber+" input[type='radio']").each(function(){
		if(jQuery(this).is(":checked")){
			jQuery(this).attr("checked","checked");
		}
	});
	
	var uppingRegex = new RegExp(uppingNumber,"g");
	var uppingFieldRegex = new RegExp(uppingFieldNumber,"g");

	var downingRegex = new RegExp(downingNumber,"g");
	var downingFieldRegex = new RegExp(downingFieldNumber,"g");

	var upping = jQuery("#sarbacane_desktop_widget_field_"+uppingNumber).html();
	upping = upping.replace(uppingRegex,downingNumber);
	upping = upping.replace(uppingFieldRegex,downingFieldNumber);
	
	var downing = jQuery("#sarbacane_desktop_widget_field_"+downingNumber).html();
	downing = downing.replace(downingFieldRegex,uppingFieldNumber);
	downing = downing.replace(downingRegex,uppingNumber);
	
	jQuery("#sarbacane_desktop_widget_field_"+downingNumber).html(upping);
	jQuery("#sarbacane_desktop_widget_field_"+uppingNumber).html(downing);


	displayPreview();
	enableDisabledItemMenu();
}
function reorderFields(){
	var fieldOrder = 0;
	jQuery("#sarbacane_desktop_widget_form div[id^='sarbacane_desktop_widget_field_']").each(function(){
		var selectedField = jQuery(this).attr("id").replace("sarbacane_desktop_widget_field_","");
		var regex = new RegExp(selectedField,"g");
		jQuery("#sarbacane_desktop_widget_field_"+selectedField+" input[type='text']").each(function(){
			jQuery(this).attr("value",jQuery(this).val());
		});
		jQuery("#sarbacane_desktop_widget_field_"+selectedField+" input[type='radio']").each(function(){
			if(jQuery(this).is(":checked")){
				jQuery(this).attr("checked","checked");
			}
		});
		var field=jQuery("#sarbacane_desktop_widget_field_"+selectedField).html().replace(regex,fieldOrder);
		regex = new RegExp(parseInt(selectedField)+1,"g");
		field = field.replace(regex,parseInt(fieldOrder)+1);
		jQuery(this).html(field);
		jQuery(this).attr("id","sarbacane_desktop_widget_field_"+fieldOrder);
		fieldOrder++;
	});
	fieldNumber=fieldOrder;
	displayPreview();
	enableDisabledItemMenu();
}
function enableDisabledItemMenu(){
	jQuery(".sarbacane_desktop_menu_item_disabled").removeClass("sarbacane_desktop_menu_item_disabled");
	jQuery("#sarbacane_desktop_widget_form div[id^='sarbacane_desktop_widget_field_']").first().find("li.sarbacane_desktop_up").addClass("sarbacane_desktop_menu_item_disabled");
	jQuery("#sarbacane_desktop_widget_form div[id^='sarbacane_desktop_widget_field_']").last().find("li.sarbacane_desktop_down").addClass("sarbacane_desktop_menu_item_disabled");
	if(fieldNumber>=10){
		jQuery("#sarbacane_desktop_add_field").addClass("sarbacane_desktop_menu_item_disabled");	
	}else{
		jQuery("#sarbacane_desktop_add_field").removeClass("sarbacane_desktop_menu_item_disabled");
	}
}
function displayPreview(){
	
	var previewHtml = "";
	
	var widgetTitle = jQuery("#sarbacane_desktop_widget_title").val();
	var widgetDesc = jQuery("#sarbacane_desktop_widget_description").val();

	var compiled = _.template("<h3><%-widgetTitle%></h3><h4><%-description%></h4>");

	previewHtml += compiled({widgetTitle: widgetTitle,description : widgetDesc});

	jQuery("#sarbacane_desktop_widget_form div[id^='sarbacane_desktop_widget_field_']").each(function(){
		var template = _.template("<p><label><%-label%> <%=mandatory%> : </label><br /><input type='text' placeholder='<%-placeholder%>' /></p>");
		var label = jQuery(this).find("input[id^='sarbacane_desktop_label_']").val();
		var placeholder = jQuery(this).find("input[id^='sarbacane_desktop_field_']").val();
		var isMandatory = jQuery(this).find("input[id^='sarbacane_desktop_mandatory_true_']").is(":checked");
		if(isMandatory){
			previewHtml += template({label: label,placeholder : placeholder, mandatory : '*'});
		}else{
			previewHtml += template({label: label,placeholder : placeholder, mandatory : ''});
		}
	});
	var buttonValue = jQuery("#sarbacane_desktop_widget_registration_button").val();
	var buttonTemplate = _.template("<p><input type='button' value='<%-buttonValue%>' />");
	previewHtml+= buttonTemplate({buttonValue:buttonValue});
	jQuery("#sarbacane_preview").html(previewHtml);
}