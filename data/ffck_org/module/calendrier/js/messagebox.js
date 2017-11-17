var MB_ICON_OK = 1;
var MB_ICON_INFO = 2;
var MB_ICON_ERROR = 3;

// MessageBox 
function MessageBox(text, caption, type, fnOk)
{
	if (type == MB_ICON_OK)
	{
		bootbox.dialog({
			title: "<img hspace='2' width='16' height='16' src='./img/16x16_etat_ok.png'>&nbsp;"+caption,
			message: text,
			buttons: {
				success: {
					label: "Fermer",
					className: "btn-success",
					callback: fnOk
				}
			}
		});
	}
	else if (type == MB_ICON_ERROR)
	{
		bootbox.dialog({
			title: "<img hspace='2' width='16' height='16' src='./img/16x16_etat_ko.png'>&nbsp;"+caption,
			message: text,
			buttons: {
				success: {
					label: "Fermer",
					className: "btn-danger",
					callback: fnOk
				}
			}
		});
	}
	else // MB_ICON_INFO
	{
		bootbox.dialog({
			title: "<img hspace='2' width='16' height='16' src='./img/16x16_info.png'>&nbsp;"+caption,
			message: text,
			buttons: {
				success: {
					label: "Fermer",
					className: "btn-info",
					callback: fnOk
				}
			}
		});
	
	}
}

// MessageBoxYesNo 
function MessageBoxYesNo(text, caption, type, fnyes, fnno)
{
	var title;
	if (type == MB_ICON_OK)
		title = "<img hspace='2' width='16' height='16' src='./img/16x16_etat_ok.png'>&nbsp;"+caption;
	else if (type == MB_ICON_ERROR)
		title = "<img hspace='2' width='16' height='16' src='./img/16x16_etat_ko.png'>&nbsp;"+caption;
	else
		title = "<img hspace='2' width='16' height='16' src='./img/16x16_info.png'>&nbsp;"+caption;
	
	bootbox.dialog({
			title: title,
			message: text,
			buttons: {
				yes: {
					label: "Valider",
					className: "btn-success",
					callback: fnyes
				},
				no: {
					label: "Annuler",
					className: "btn-danger",
					callback: fnno
				}
			}
	});
}