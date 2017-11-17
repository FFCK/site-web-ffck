var colOrder = '';
var colAsc = 1;

function FindCalendrier()
{
	WaitProgressShow();
	var param = $('#calendrier_recherche_form').serialize();
//    alert("ajax_calendrier_load.php?"+param);
    $.ajax({ type: "GET", url: "ajax_calendrier_load.php", dataType: "html", data: param, cache: false, 
             success: function(htmlData) { $('#container_calendrier').html(htmlData); InitContainerCalendrier(); WaitProgressHide(); }
	});
}

function FilterCalendrier()
{
	WaitProgressShow();
	var param = $('#calendrier_filter_form').serialize();
//	alert("ajax_calendrier_filter.php?"+param);
	$.ajax({ type: "GET", url: "ajax_calendrier_filter.php", dataType: "html", data: param, cache: false, 
		 success: function(htmlData) { $('#container_calendrier').html(htmlData); InitContainerCalendrier(); WaitProgressHide(); }
	});
}

function DetailCalendrierModal(codex, type)
{
	WaitProgressShow();
	var param = 'codex='+codex;
	if (type == 'FORMATION')
	{
//		alert("ajax_formation_detail.php?"+param);
		$.ajax({ type: "GET", url: "ajax_formation_detail.php", dataType: "html", data: param, cache: false, 
				success: function(htmlData) {	$('#container_calendrier_detail').html(htmlData);
												WaitProgressHide();
												$('#calendrier_formation_detail_modal').modal('show');
												return false;
				}
		});
	}
	else
	{
		alert("ajax_evenement_detail.php?"+param);
		$.ajax({ type: "GET", url: "ajax_evenement_detail.php", dataType: "html", data: param, cache: false, 
				success: function(htmlData) { }
		});
	}
}

function DetailCalendrier(codex, type)
{
	if (type == 'FORMATION')
	{
		document.location.href = './formation_detail.php?id='+codex;
	}
	else
	{
		document.location.href = './evenement_detail.php?codex='+codex;
	}
}

function OrderCalendrier(col)
{
	if (col == colOrder)
	{
		if (colAsc)
			colAsc = 0;
		else
			colAsc = 1;
	}
	else
	{
		colOrder = col;
		colAsc = 1;
	}
	
	WaitProgressShow();
	var param = 'order='+colOrder+"&asc="+colAsc;
//	alert("ajax_calendrier_order.php?"+param);
	$.ajax({ type: "GET", url: "ajax_calendrier_order.php", dataType: "html", data: param, cache: false, 
		 success: function(htmlData) { $('#container_calendrier').html(htmlData); InitContainerCalendrier(); WaitProgressHide(); }
	});
}

function ExportExcelCalendrier()
{
	document.location.href='./export_excel_calendrier.php';
}

function ExportPdfCalendrier()
{
	window.open('./export_pdf_calendrier.php', '_blank');
}

function InitContainerCalendrier()
{
	$("#activite").select2({ placeholder: 'Sélectionner une ou plusieurs activités ...' });
	$("#niveau").select2({ placeholder: 'Sélectionner un ou plusieurs niveaux ...' });
	$("#type_formation").select2({ placeholder: 'Sélectionner une ou plusieurs formations...' });

	$("#btn_filter_calendrier").click(function () {
		FilterCalendrier();
		return false;
	});

	$("#btn_export_excel").click(function () {
		ExportExcelCalendrier();
		return false;
	});

	$("#btn_export_pdf").click(function () {
		ExportPdfCalendrier();
		return false;
	});

	$('.codex').click(function () {
		DetailCalendrier($(this).attr('data-codex'), $(this).attr('data-type'));
		return false;
	});
	
	$('.col_order').click(function () {
		OrderCalendrier($(this).attr('data-col'));
		return false;
	});
}

function ChangeFamilleFormation(famille_formation)
{
	WaitProgressShow();
	var param = 'famille_formation='+famille_formation;
//	alert("ajax_change_famille_formation.php?"+param);
	$.ajax({ type: "GET", url: "ajax_change_famille_formation.php", dataType: "html", data: param, cache: false, 
		success: function(htmlData) {	$('#container_type_formation').html(htmlData); 
										$("#type_formation").select2({ placeholder: 'Sélectionner une ou plusieurs formations...' });
										WaitProgressHide(); }
	});
}

function ChangeTypeEvenement(type_evenement)
{
	WaitProgressShow();
	var param = 'type_evenement='+type_evenement;
//	alert("ajax_change_type_evenement.php?"+param);
	$.ajax({ type: "GET", url: "ajax_change_type_evenement.php", dataType: "html", data: param, cache: false, 
		success: function(htmlData) {	$('#container_type_evenement').html(htmlData); 
										$('#famille_formation').change(function() {
											ChangeFamilleFormation($(this).val());
											return false;
										});
										$("#niveau").select2({ placeholder: 'Sélectionner un ou plusieurs niveaux ...' });				
										$("#activite").select2({ placeholder: 'Sélectionner une ou plusieurs activités...' });				
										$("#type_formation").select2({ placeholder: 'Sélectionner une ou plusieurs formations...' });				
										WaitProgressHide(); }
	});
}

function Init()
{
	$("#recherche_calendrier").click(function () {
		FindCalendrier();
		return false;
	});

	$('.input-group.date').datepicker({
		format: "dd/mm/yyyy",
		language: "fr",
		todayBtn: "linked",
		autoclose: true,
		todayHighlight: true
	});

	$('#type_evenement').change(function() {
		ChangeTypeEvenement($(this).val());
		return false;
	});
	
	InitContainerCalendrier();
}

