function newsListChange(checkbox) {
	if(!jQuery(checkbox).is(":checked")){
		jQuery("#modalBox").dialog({
			resizable : false,
			modal : true,
			dialogClass : "no-close",
			width : "50%",
			buttons: [{
				text: okButton,
				"id": "btnOk",
				click: function () {
					jQuery(this).dialog("close");
				},
			}, {
				text: noButton,
				click: function () {
					jQuery(checkbox).attr("checked","checked");
					jQuery(this).dialog("close");
				},
			}],
		});
		
	}
}
