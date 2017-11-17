<?php
include_once('page.php');

function cmpCalendrierDate($a, $b)
{
	$column = utyGetSession('calendrier_order_col');
	return strcmp(utyDateFrToUs($a[$column]), utyDateFrToUs($b[$column]));
}

function cmpCalendrierDateDesc($a, $b)
{
	return -cmpCalendrierDate($a, $b);
}

function cmpCalendrierString($a, $b)
{
	$column = utyGetSession('calendrier_order_col');
	return strcmp($a[$column], $b[$column]);
}

function cmpCalendrierStringDesc($a, $b)
{
	return -cmpCalendrierString($a, $b);
}

function cmpCalendrierTypeEvenement($a, $b)
{
	return strcmp($a['libelleTypeEvenement'].$a['libelleActivite'], $b['libelleTypeEvenement'].$b['libelleActivite']);
}

function cmpCalendrierTypeEvenementDesc($a, $b)
{
	return -cmpCalendrierTypeEvenement($a, $b);
}


class Calendrier extends MyPage
{
	function Footer()
	{
		//if ($this->GetParamInt('footer',1) == 1)
		//	parent::Footer();
	}

	function Menu()
	{
		//if ($this->GetParamInt('menu',1) == 1)
		//	parent::Menu();
	}

	function Header()
	{
	?>
		<h3 class="text-center">Calendrier F.F.C.K.</h3>
	<?php
	}

	function Content()
	{
		?>
		<div class='well'>
		<?php $this->Recherche(); ?>
		</div>

		<div id='container_calendrier' class='well'>
		<?php if (isset($_SESSION['calendrier_table'])) Calendrier::Filter(); ?>
		</div>

		<div id='container_calendrier_detail'>
		</div>

		<?php
	}

	function Recherche()
	{
		$db = new MyBase();

		$tTypeEvenement = null;
		$db->LoadTable('Select * From Type_Evenement Order By Ordre', $tTypeEvenement);
		$annee = date('Y');
		?>

		<form method='GET' action='#' name='calendrier_recherche_form' id='calendrier_recherche_form' class="form-horizontal" role="form" enctype='multipart/form-data'>

		<h3>Critères de Recherche</h3>

		<div class="form-group control-group">
			<label for="type_evenement" class="col-sm-2 control-label" >Type</label>
			<div class="col-sm-10">
				<select name="type_evenement" id="type_evenement" class="form-control">
					<option value="">Tous</option>
					<option value="COMPOFF,COMPOPEN" <?php utyEchoSelected($_SESSION, 'calendrier_type_evenement', 'COMPOFF,COMPOPEN');?>>Compétitions</option>
					<option value="LOISIRS" <?php utyEchoSelected($_SESSION, 'calendrier_type_evenement', 'LOISIRS');?>>Manifestations loisirs</option>
					<option value="FORMATION" <?php utyEchoSelected($_SESSION, 'calendrier_type_evenement', 'FORMATION');?>>Formations</option>
					<option value="ACTHN" <?php utyEchoSelected($_SESSION, 'calendrier_type_evenement', 'ACTHN');?>>Actions sport de haut niveau</option>
					<option value="REUNION" <?php utyEchoSelected($_SESSION, 'calendrier_type_evenement', 'REUNION');?>>Agenda FFCK</option>
				</select>
			</div>
		</div>

		<div class="form-group control-group">
			<label for="mois" class="col-sm-2 control-label" >Mois</label>
			<div class="col-sm-4">
				<select name="mois" id="mois" class="form-control">
					<option value="" <?php utyEchoSelected($_SESSION, 'calendrier_mois', '');?>>Tous</option>
					<option value="JAN" <?php utyEchoSelected($_SESSION, 'calendrier_mois', 'JAN');?>>Janvier</option>
					<option value="FEV" <?php utyEchoSelected($_SESSION, 'calendrier_mois', 'FEV');?>>Février</option>
					<option value="MAR" <?php utyEchoSelected($_SESSION, 'calendrier_mois', 'MAR');?>>Mars</option>
					<option value="AVR" <?php utyEchoSelected($_SESSION, 'calendrier_mois', 'AVR');?>>Avril</option>
					<option value="MAI" <?php utyEchoSelected($_SESSION, 'calendrier_mois', 'MAI');?>>Mai</option>
					<option value="JUIN" <?php utyEchoSelected($_SESSION, 'calendrier_mois', 'JUIN');?>>Juin</option>
					<option value="JUIL" <?php utyEchoSelected($_SESSION, 'calendrier_mois', 'JUIL');?>>Juillet</option>
					<option value="AOUT" <?php utyEchoSelected($_SESSION, 'calendrier_mois', 'AOUT');?>>Août</option>
					<option value="SEPT" <?php utyEchoSelected($_SESSION, 'calendrier_mois', 'SEPT');?>>Septembre</option>
					<option value="OCT" <?php utyEchoSelected($_SESSION, 'calendrier_mois', 'OCT');?>>Octobre</option>
					<option value="NOV" <?php utyEchoSelected($_SESSION, 'calendrier_mois', 'NOV');?>>Novembre</option>
					<option value="DEC" <?php utyEchoSelected($_SESSION, 'calendrier_mois', 'DEC');?>>Décembre</option>
				</select>
			</div>
		<!--</div>

		<div class="form-group control-group">-->
			<label for="saison" class="col-sm-2 control-label" >Saison</label>
			<div class="col-sm-4">
				<select name="saison" id="saison" class="form-control">
					<option value="<?php echo $annee - 1 ?>" <?php utyEchoSelected($_SESSION, 'calendrier_saison', $annee - 1);?>><?php echo $annee - 1 ?></option>
					<option selected="selected" value="<?php echo $annee ?>" <?php utyEchoSelected($_SESSION, 'calendrier_saison', $annee);?>><?php echo $annee ?></option>
					<option value="<?php echo $annee + 1 ?>" <?php utyEchoSelected($_SESSION, 'calendrier_saison', $annee + 1);?>><?php echo $annee + 1 ?></option>
				</select>
			</div>
		</div>

		<div id='container_type_evenement' class="form-group control-group">
			<!-- <div id='container_type_evenement' class="form-group control-group"> -->
			<?php Calendrier::ComboEvenement($db, utyGetSession('calendrier_type_evenement')); ?>
			<!-- </div> -->
		</div>

		<div class="form-group control-group">
			<div class="col-sm-offset-4 col-sm-4">
				<button id ='recherche_calendrier' class="col-sm-12 btn btn-large btn-primary btn-default"><img hspace='2' width='16' height='16' src='<?php echo $this->m_directory;?>/img/16x16_find.png'>&nbsp;Recherche</i></button>
			</div>
		</div>
		</form>
		<?php
	}

	public static function ComboEvenement(&$db, $type_evenement)
	{
		if ($type_evenement == 'FORMATION')
		{
			Calendrier::ComboEvenementFORMATION($db);
			return;
		}

		if ($type_evenement == 'COMPOFF,COMPOPEN')
		{
			Calendrier::ComboEvenementActiviteNiveau($db, $type_evenement);
			return;
		}

		if ($type_evenement == 'LOISIRS')
		{
			Calendrier::ComboEvenementActivite($db, $type_evenement);
			return;
		}
	}

	public static function AddFamilleFormation(&$tFamilleFormation, $code, $libelle)
	{
		for ($i=0;$i<count($tFamilleFormation);$i++)
		{
			if ($tFamilleFormation[$i]['code'] == $code)
				return;
		}

		$rFamilleFormation = array();
		$rFamilleFormation['code'] = $code;
		$rFamilleFormation['libelle'] = $libelle;
		array_push($tFamilleFormation, $rFamilleFormation);
	}

	public static function ComboEvenementFORMATION(&$db)
	{
    $wsEndpoint = "http://" . getenv("OBS_USER") . ":" . getenv("OBS_PASSWORD") . "@" . getenv("OBS_HOST") . "/wsprivate";
		$url = $wsEndpoint . '/formations/typesFormations';
		$xmlDoc = new DOMDocument();
		$xmlDoc->load($url);

		$tTypeFormation = array();
		$tFamilleFormation = array();

		$listeTypeFormations = $xmlDoc->getElementsByTagName("typeFormation");
		foreach($listeTypeFormations as $recordTypeFormations)
		{
			$rTypeFormation = array();
			$rTypeFormation['code'] = Calendrier::GetXMLValue($recordTypeFormations,'code');
			$rTypeFormation['libelle'] = Calendrier::GetXMLValue($recordTypeFormations,'libelle');
			$codeFamille = Calendrier::GetXMLValue($recordTypeFormations,'codeFamille');
			$libelleFamille = Calendrier::GetXMLValue($recordTypeFormations,'libelleFamille');
			$rTypeFormation['codeFamille'] = $codeFamille;
			Calendrier::AddFamilleFormation($tFamilleFormation, $codeFamille, $libelleFamille);
			array_push($tTypeFormation, $rTypeFormation);
		}
		$_SESSION['type_formation_table'] = $tTypeFormation;
		?>
		<label for="famille_formation" class="col-sm-2 control-label" >Type Formation</label>
		<div class="col-sm-4">
		<select name="famille_formation" id="famille_formation" class="form-control">
			<option value=""></option>
			<?php for ($i=0;$i<count($tFamilleFormation);$i++) { ?>
			<option value="<?php echo $tFamilleFormation[$i]['code'];?>" <?php utyEchoSelected($_SESSION, 'calendrier_famille_formation', $tFamilleFormation[$i]['code']);?>><?php echo $tFamilleFormation[$i]['libelle'];?></option>
			<?php } ?>
		</select>
		</div>

		<label for="type_formation" class="col-sm-2 control-label" >Formation</label>
		<div id='container_type_formation' class="col-sm-4">
		<?php Calendrier::ComboEvenementTypeFormation(); ?>
		</div>
		<?php
	}

	public static function ComboEvenementTypeFormation()
	{
		$famille_formation = utyGetSession('calendrier_famille_formation');
		$tTypeFormation = $_SESSION['type_formation_table'];
		?>
		<select multiple name="type_formation[]" id="type_formation" class="form-control">
			<option value=""></option>
			<?php if ($famille_formation != '') { for ($i=0;$i<count($tTypeFormation);$i++) {
					if ($tTypeFormation[$i]['codeFamille'] == $famille_formation) {?>
			<option value="<?php echo $tTypeFormation[$i]['code'];?>" <?php utyEchoMultiSelected($_SESSION, 'calendrier_type_formation', $tTypeFormation[$i]['code']);?>><?php echo $tTypeFormation[$i]['libelle'];?></option>
			<?php } } } ?>
		</select>
		<?php
	}

	public static function ComboEvenementActivite(&$db, $type_evenement)
	{
		$tActivite = null;
		$sql  = "Select a.* From Activite a, Type_Evenement_Activite b ";
		$sql .= "Where a.Code = b.Code_activite ";
		$sql .= "And b.Code_type_evenement = '$type_evenement'";
		$db->LoadTable($sql, $tActivite);

		?>
		<label for="activite" class="col-sm-2 control-label" >Activités</label>
		<div class="col-sm-10">
		<select multiple name="activite[]" id="activite" class="form-control">
			<option value=""></option>
			<?php for ($i=0;$i<count($tActivite);$i++) { ?>
			<option value="<?php echo $tActivite[$i]['Code'];?>" <?php utyEchoMultiSelected($_SESSION, 'calendrier_activite', $tActivite[$i]['Code']);?>><?php echo $tActivite[$i]['Libelle'];?></option>
			<?php } ?>
		</select>
		</div>
		<?php
	}

	public static function ComboEvenementActiviteNiveau(&$db, $type_evenement)
	{
		$tActivite = null;
		$sql  = "Select a.* From Activite a, Type_Evenement_Activite b ";
		$sql .= "Where a.Code = b.Code_activite ";
		$sql .= "And b.Code_type_evenement = 'COMPOFF'"; //pas terrible de remplacer la variable par le code type évènement en dur
		$db->LoadTable($sql, $tActivite);

		$tNiveau = null;
		$db->LoadTable('Select * from Niveau Order By Code', $tNiveau);

		?>

		<label for="activite" class="col-sm-2 control-label" >Activités</label>
		<div class="col-sm-4">
		<select multiple name="activite[]" id="activite" class="form-control">
			<option value=""></option>
			<?php for ($i=0;$i<count($tActivite);$i++) { ?>
			<option value="<?php echo $tActivite[$i]['Code'];?>" <?php utyEchoMultiSelected($_SESSION, 'calendrier_activite', $tActivite[$i]['Code']);?>><?php echo $tActivite[$i]['Libelle'];?></option>
			<?php } ?>
		</select>
		</div>

		<label for="niveau" class="col-sm-2 control-label">Niveaux</label>
		<div class="col-sm-4">
		<select multiple name="niveau[]" id="niveau" class="form-control">
			<option value=""></option>
			<?php for ($i=0;$i<count($tNiveau);$i++) { ?>
			<option value="<?php echo $tNiveau[$i]['Code'];?>" <?php utyEchoMultiSelected($_SESSION, 'calendrier_niveau', $tNiveau[$i]['Code']);?>><?php echo $tNiveau[$i]['Libelle'];?></option>
			<?php } ?>
		</select>
		</div>
		<?php
	}

	public static function GetXMLValue($record, $key)
	{
		$lst = $record->getElementsByTagName($key);
		$value = '';
		foreach($lst as $elem)
		{
			$value .= $elem->nodeValue;
		}
		return $value;
	}

	public static function Filter()
	{
		$tCalendrierSource = $_SESSION['calendrier_table'];

		$filter_lieu = utyGetSession('calendrier_filter_lieu');
		$tCalendrier = array();
		for ($i=0;$i<count($tCalendrierSource);$i++)
		{
			$row = $tCalendrierSource[$i];
			if ($filter_lieu != '')
			{
				$lieu = $row['lieu'];
				if (stristr($lieu, $filter_lieu) === false)
					continue;
			}

			array_push($tCalendrier, $row);
		}
		Calendrier::Order($tCalendrier);
		Calendrier::Affiche($tCalendrier);
	}

	public static function Order(&$tCalendrier)
	{
		$order = utyGetSession('calendrier_order_col');
		$asc = (int) utyGetSession('calendrier_order_asc');

		if (substr($order,0, 4) == 'date')
		{
			if ($asc)
				usort($tCalendrier, "cmpCalendrierDate");
			else
				usort($tCalendrier, "cmpCalendrierDateDesc");
		}
		elseif ($order == 'libelleTypeEvenement')
		{
			if ($asc)
				usort($tCalendrier, "cmpCalendrierTypeEvenement");
			else
				usort($tCalendrier, "cmpCalendrierTypeEvenementDesc");
		}
		else
		{
			if ($asc)
				usort($tCalendrier, "cmpCalendrierString");
			else
				usort($tCalendrier, "cmpCalendrierStringDesc");
		}
	}


	public static function Load()
	{
		$type_evenement = utyGetSession('calendrier_type_evenement');
		$famille_formation = utyGetSession('calendrier_famille_formation'); //modifier le WS pour utiliser cette variable pour filtrer
		$type_formation = utyGetSessionArray('calendrier_type_formation');
		$activite = utyGetSessionArray('calendrier_activite');
		$niveau = utyGetSessionArray('calendrier_niveau');

		$saison = utyGetSession('calendrier_saison');
		$mois = utyGetSession('calendrier_mois');

		// Détermine la date de début et de fin de recherche
		if ($mois == "JAN"){
			$debut = "01/01/".$saison ;
			$fin = "31/01/".$saison ;
		}

		elseif ($mois == "FEV"){
			$debut = "01/02/".$saison ;
			$fin = "28/02/".$saison ;
		}

		elseif ($mois == "MAR"){
			$debut = "01/03/".$saison ;
			$fin = "31/03/".$saison ;
		}

		elseif ($mois == "AVR"){
			$debut = "01/04/".$saison ;
			$fin = "30/04/".$saison ;
		}

		elseif ($mois == "MAI"){
			$debut = "01/05/".$saison ;
			$fin = "31/05/".$saison ;
		}

		elseif ($mois == "JUIN"){
			$debut = "01/06/".$saison ;
			$fin = "30/06/".$saison ;
		}

		elseif ($mois == "JUIL"){
			$debut = "01/07/".$saison ;
			$fin = "31/07/".$saison ;
		}

		elseif ($mois == "AOUT"){
			$debut = "01/08/".$saison ;
			$fin = "31/08/".$saison ;
		}

		elseif ($mois == "SEPT"){
			$debut = "01/09/".$saison ;
			$fin = "30/09/".$saison ;
		}

		elseif ($mois == "OCT"){
			$debut = "01/10/".$saison ;
			$fin = "31/10/".$saison ;
		}

		elseif ($mois == "NOV"){
			$debut = "01/11/".$saison ;
			$fin = "30/11/".$saison ;
		}

		elseif ($mois == "DEC"){
			$debut = "01/12/".$saison ;
			$fin = "31/12/".$saison ;
		}

		else {
			$debut = "01/01/".$saison ; //utyGetSession('calendrier_debut');
			$fin = "31/12/".$saison ; //utyGetSession('calendrier_fin');
		}

    $wsEndpoint = "http://" . getenv("OBS_USER") . ":" . getenv("OBS_PASSWORD") . "@" . getenv("OBS_HOST") . "/wsprivate";

		$url = $wsEndpoint . "/calendriers/get";

		$url .= "?dateDebut=";
		$url .= $debut;

		$url .= "&dateFin=";
		$url .= $fin;

		$url .= "&codeStructure=";
		if ($type_evenement == 'REUNION')
		{
			$url .= "0";
		}

		if ($type_evenement == 'FORMATION')
		{
			$url .= "&codeFamilleFormation=";
			$url .= $famille_formation;//$type_formation;

			if (count($type_formation) > 0)
			{
				$url .= "&codeTypeFormation=";
				for ($a=0;$a<count($type_formation);$a++)
				{
					if ($a > 0) $url .= ',';
					$url .= $type_formation[$a];
				}
			}
		}

		if ($type_evenement != 'FORMATION')
		{
			$url .= "&codeTypeEvt=";
			$url .= $type_evenement;

			if (count($activite) > 0)
			{
				$url .= "&codeTypeActivite=";
				for ($l=0;$l<count($activite);$l++)
				{
					if ($l > 0) $url .= ',';
					$url .= $activite[$l];
				}
			}

			if (count($niveau) > 0)
			{
				$url .= "&niveaux=";
				for ($k=0;$k<count($niveau);$k++)
				{
					if ($k > 0) $url .= ',';
					$url .= $niveau[$k];
				}
			}
		}

		$xmlDoc = new DOMDocument();
		$xmlDoc->load($url);
    $wsEndpoint = "http://" . getenv("OBS_USER") . ":" . getenv("OBS_PASSWORD") . "@" . getenv("OBS_HOST") . "/wsprivate";
		// $xmlDoc->load($wsEndpoint . '/calendriers/get?dateDebut=01/01/2014&dateFin=&codeStructure=&codeTypeFormation=&idSaisonEvt=2015&codeTypeEvt=&codeTypeActivite=');
//echo "URL=".$url.'<br>';

		$tCalendrier = array();
		// 1 - Parcours des Evénements
		if ($type_evenement != 'FORMATION')
		{
			$listeEvenements = $xmlDoc->getElementsByTagName("evenement");
			foreach($listeEvenements as $recordEvenement)
			{
				$type_evenement_actif = Calendrier::GetXMLValue($recordEvenement,'codeTypeEvenement');
				if (($type_evenement != '') && ($type_evenement_actif != $type_evenement_actif))
					continue;

				$rCalendrier = array();
				$rCalendrier['codex'] = Calendrier::GetXMLValue($recordEvenement,'codex');
				$rCalendrier['saison'] = Calendrier::GetXMLValue($recordEvenement,'saison');

				$rCalendrier['codeTypeEvenement'] = $type_evenement_actif;
				$rCalendrier['libelleTypeEvenement'] = Calendrier::GetXMLValue($recordEvenement,'libelleTypeEvenement');

				$rCalendrier['codeActivite'] = Calendrier::GetXMLValue($recordEvenement,'codeActivite');
				$rCalendrier['libelleActivite'] = Calendrier::GetXMLValue($recordEvenement,'libelleActivite');

				$rCalendrier['codeNiveau'] = Calendrier::GetXMLValue($recordEvenement,'codeNiveau');
				$rCalendrier['libelleNiveau'] = Calendrier::GetXMLValue($recordEvenement,'libelleNiveau');

				$rCalendrier['dateDebut'] = Calendrier::GetXMLValue($recordEvenement,'dateDebut');
				$rCalendrier['dateFin'] = Calendrier::GetXMLValue($recordEvenement,'dateFin');

				$rCalendrier['nomEvenement'] = Calendrier::GetXMLValue($recordEvenement,'nomEvenement');
				$rCalendrier['lieu'] = Calendrier::GetXMLValue($recordEvenement,'lieu');
				$rCalendrier['structureOrganisatrice'] = Calendrier::GetXMLValue($recordEvenement,'structureOrganisatrice');

				array_push($tCalendrier, $rCalendrier);
			}
		}

		// 2 - Parcours des Formations
		if (($type_evenement == '') || ($type_evenement == 'FORMATION'))
		{
			$listeFormations = $xmlDoc->getElementsByTagName("sessionFormation");
			foreach($listeFormations as $recordFormation)
			{
				if ($type_evenement != 'FORMATION')

				$rCalendrier = array();
				$rCalendrier['codex'] = Calendrier::GetXMLValue($recordFormation,'id');
				$rCalendrier['saison'] = '';

				$rCalendrier['codeTypeEvenement'] = 'FORMATION';
				$rCalendrier['libelleTypeEvenement'] = 'Formation';

				$rCalendrier['codeActivite'] = Calendrier::GetXMLValue($recordFormation,'ligueStructureOrganisatrice');
				$rCalendrier['libelleActivite'] = Calendrier::GetXMLValue($recordFormation,'familleFormation'); // si 'Pagaies couleurs' => disctinction Pagaie Couleur Detail ou Formation Detail : Exemple 12725*/

				$rCalendrier['codeNiveau'] = Calendrier::GetXMLValue($recordFormation,'typeFormation');
				$rCalendrier['libelleNiveau'] = Calendrier::GetXMLValue($recordFormation,'typeQualification');

				$rCalendrier['dateDebut'] = Calendrier::GetXMLValue($recordFormation,'dateDebut');
				$rCalendrier['dateFin'] = Calendrier::GetXMLValue($recordFormation,'dateFin');

				$rCalendrier['nomEvenement'] = Calendrier::GetXMLValue($recordFormation,'typeFormation');
				$rCalendrier['lieu'] = Calendrier::GetXMLValue($recordFormation,'lieuSession');
				$rCalendrier['structureOrganisatrice'] = Calendrier::GetXMLValue($recordFormation,'structureOrganisatrice');

				array_push($tCalendrier, $rCalendrier);
			}
		}

		// Tri
		Calendrier::Order($tCalendrier);
		$_SESSION['calendrier_table'] = $tCalendrier;

		Calendrier::Affiche($tCalendrier);
	}

	public static function Affiche(&$tCalendrier)
	{

		$total = count($tCalendrier);
		if ($total == 0)
		{
			?>
			<h2><span class="label label-warning">Liste des évènements - Liste Vide ...</span></h2>
			<h3><span class="label label-warning">Aucun évènement ne correspond aux critères ...</span></h3>
			<?php
		}
		else
		{
			?>
			<h3>Liste des évènements - <?php echo $total;?> trouvés </h3><br>
			<?php
		}

		?>
		<form method='POST' action='#' name='calendrier_filter_form' id='calendrier_filter_form' class="form-horizontal" role="form" enctype='multipart/form-data'>
			<div class="form-group control-group">
				<div class="col-sm-4">
					<button id ='btn_filter_calendrier' class="col-sm-12 btn btn-primary">
					<img hspace='2' width='16' height='16' src='<?php echo MyPage::GetDirectory();?>/img/16x16_filter.png' alt='' title=''>&nbsp;Filtrer</label>
					</button>
				</div>

				<div class="col-sm-4">
					<button id ='btn_export_excel' class="col-sm-12 btn btn-large btn-primary btn-default"><img hspace='2' width='16' height='16' src='<?php echo MyPage::GetDirectory();?>/img/16x16_excel.png'>&nbsp;Export Excel</i></button>
				</div>

				<div class="col-sm-4">
					<button id ='btn_export_pdf' class="col-sm-12 btn btn-large btn-primary btn-default"><img hspace='2' width='16' height='16' src='<?php echo MyPage::GetDirectory();?>/img/16x16_pdf.png'>&nbsp;Export PDF</i></button>
				</div>
			</div>

			<div class="form-group control-group">
			<!--<label for="filter_lieu" class="col-sm-1 control-label">Lieu</label>-->
				<div class="col-sm-4">
				<input type="text" name="filter_lieu" id="filter_lieu" class="form-control" placeholder="lieu comprenant les caractères ..." value="<?php echo utyGetSession('calendrier_filter_lieu');?>"/>
				</div>
			</div>
		</form>
		<?php if ($total == 0) return; ?>


		<div class="table-responsive">
		<table class="liste_competition table table-striped table-bordered table-hover table-condensed">
			<thead>
				<tr>
					<th></th>
					<th><a href="#" data-col="libelleTypeEvenement" class="col_order">Type</a></th>
					<th><a href="#" data-col="nomEvenement" class="col_order">Nom</a></th>
					<th><a href="#" data-col="dateDebut" class="col_order">Début</a></th>
					<th><a href="#" data-col="dateFin" class="col_order">Fin</a></th>
					<th><a href="#" data-col="lieu" class="col_order">Lieu</a></th>
				</tr>
			</thead>
			<tbody>
			<?php
			for ($i=0;$i<$total;$i++)
			{
				$rCalendrier = $tCalendrier[$i];
				$codex = utyGetString($rCalendrier,'codex');
				$type = utyGetString($rCalendrier,'codeTypeEvenement');
				?>
				<tr>
				<td><a href="#" class="codex" data-codex="<?php echo $codex;?>" data-type="<?php echo $type;?>"><button type="button" class="btn btn-primary"><span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span></button></a></td>
				<td><?php echo utyGetString($rCalendrier,'libelleTypeEvenement'); ?> - <?php echo utyGetString($rCalendrier,'libelleActivite'); ?></td>
				<td><?php echo utyGetString($rCalendrier,'nomEvenement'); ?></td>
				<td><?php echo utyGetString($rCalendrier,'dateDebut'); ?></td>
				<td><?php echo utyGetString($rCalendrier,'dateFin'); ?></td>
				<td><?php echo strtoupper(utyGetString($rCalendrier,'lieu')); ?></td>
				</tr>
				<?php
			}
			?>
			</tbody>
		</table>
		</div>



		<br>
		<br>
		<?php
	}

	function Script()
	{
		parent::Script();
		?>
		<script type="text/javascript" src="./js/calendrier.js?v3" ></script>
		<script type="text/javascript" src="https://addthisevent.com/libs/1.5.8/ate.min.js"></script>
		<script type="text/javascript"> $(document).ready(function(){ Init(); }); </script>
		<?php
	}
}
?>
