<?php
include_once('page.php');
include_once('../adv/advXml.php');

class FormationDetail extends MyPage
{
	function Footer()
	{

	}

	function Menu()
	{

	}

	function Header()
	{

	}

	function Head()
	{
		parent::Head();
	?>
		<style type="text/css">
		/* AddThisEvent */
		.addthisevent-drop 					{width:280px;display:inline-block;position:relative;z-index:999998;cursor:pointer;background:#f7f7f7;font-family:"Segoe UI",Frutiger,"Frutiger Linotype","Dejavu Sans","Helvetica Neue",Arial,sans-serif;color:#333!important;font-size:15px;border:1px solid #cfcfcf;-webkit-box-shadow:1px 1px 3px rgba(0,0,0,0.15);-moz-box-shadow:1px 1px 3px rgba(0,0,0,0.15);box-shadow:1px 1px 3px rgba(0,0,0,0.15);-webkit-border-radius:2px;border-radius:2px;}
		.addthisevent-drop:hover 				{background-color:#f4f4f4;}
		.addthisevent-drop:active 				{top:1px;}
		.addthisevent-drop .date 				{width:60px;height:60px;float:left;position:relative;}
		.addthisevent-drop .date .mon 			{display:block;text-align:center;padding:9px 0px 0px 0px;font-size:11px;color:#bf5549;font-weight:bold;line-height:110%;text-transform:uppercase;}
		.addthisevent-drop .date .day 			{display:block;text-align:center;padding:0px 0px 8px 0px;font-size:30px;font-weight:bold;color:#333;line-height:100%;}
		.addthisevent-drop .date .bdr1 			{width:1px;height:50px;background:#eaeaea;position:absolute;z-index:100;top:5px;right:-3px;}
		.addthisevent-drop .date .bdr2 			{width:1px;height:50px;background:#fff;position:absolute;z-index:100;top:5px;right:-4px;}
		.addthisevent-drop .desc 				{width:210px;height:60px;float:left;position:relative;}
		.addthisevent-drop .desc p 				{margin:0;display:block;text-align:left;padding:7px 0px 0px 18px;font-size:12px;color:#666;line-height:110%;}
		.addthisevent-drop .desc .hed 			{height:15px;display:block;overflow:hidden;margin-bottom:3px;font-size:14px;line-height:110%;color:#333;text-transform:uppercase;}
		.addthisevent-drop .desc .des 			{height:28px;display:block;overflow:hidden;}
		.addthisevent-selected 					{background-color:#f4f4f4;}
		.addthisevent_dropdown 					{width:280px;position:absolute;z-index:99999;padding:6px 0px 0px 0px;background:#fff;text-align:left;display:none;margin-top:-2px;margin-left:-1px;border:1px solid #cfcfcf;-webkit-box-shadow:1px 3px 6px rgba(0,0,0,0.15);-moz-box-shadow:1px 3px 6px rgba(0,0,0,0.15);box-shadow:1px 3px 6px rgba(0,0,0,0.15);}
		.addthisevent_dropdown span 			{display:block;line-height:110%;background:#fff;text-decoration:none;font-size:14px;color:#6d84b4;padding:8px 10px 9px 15px;}
		.addthisevent_dropdown span:hover 		{background:#f4f4f4;color:#6d84b4;text-decoration:none;font-size:14px;}
		.addthisevent span 						{display:none!important;}
		.addthisevent-drop ._url,.addthisevent-drop ._start,.addthisevent-drop ._end,.addthisevent-drop ._summary,.addthisevent-drop ._description,.addthisevent-drop ._location,.addthisevent-drop ._organizer,.addthisevent-drop ._organizer_email,.addthisevent-drop ._facebook_event,.addthisevent-drop ._all_day_event {display:none!important;}
		.addthisevent_dropdown .copyx 			{height:21px;display:block;position:relative;cursor:default;}
		.addthisevent_dropdown .brx 			{width:180px;height:1px;overflow:hidden;background:#e0e0e0;position:absolute;z-index:100;left:10px;top:9px;}
		.addthisevent_dropdown .frs 			{position:absolute;top:3px;cursor:pointer;right:10px;padding-left:10px;font-style:normal;font-weight:normal;text-align:right;z-index:101;line-height:110%;background:#fff;text-decoration:none;font-size:10px;color:#cacaca;}
		.addthisevent_dropdown .frs:hover 		{color:#6d84b4;}
		.addthisevent 							{visibility:hidden;}
		</style>
	<?php
	}

	function Content()
	{
		$id = $this->GetParam('id');

		?>
		<div id='container_formation_detail' class='well'>
		<?php $this->Affiche($id); ?>
		</div>
		<?php
	}

	public static function PJ(&$xmlDoc)
	{
		$fichiers = $xmlDoc->getElementsByTagName('piecejointe');
		$i = 0;
		?>
		<table>
		<?php
		$i=0;
		foreach($fichiers as $fichier)
		{
			$url = $fichier->nodeValue;

			$filename = basename($url);
			$pos = strrpos($filename,'=');
			if ($pos !== false)
				$filename = substr($filename, $pos+1);

			?>
			<tr><td><a href='<?php echo $url;?>' target='_blank'><img hspace='2' width='16' height='16' src='<?php echo MyPage::GetDirectory();?>/img/16x16_pdf.png'>&nbsp<?php echo $filename;?></a><td></tr>
			<?php
		}
		?>
		</table>
		<?php
	}




	public static function Affiche($id)
	{

    $wsEndpoint = "http://" . getenv("OBS_USER") . ":" . getenv("OBS_PASSWORD") . "@" . getenv("OBS_HOST") . "/wsprivate";

		$url = $wsEndpoint . "/sessionsformations/detailSession?idSession=";
		$url .= $id;

		$xmlDoc = new DOMDocument();
		$xmlDoc->load($url);

		$dateDebut = xmlGetValue($xmlDoc, 'dateDebut');
		$dateFin = xmlGetValue($xmlDoc, 'dateFin');

		?>
		<h2><?php echo xmlGetValue($xmlDoc, 'typeFormation');?></h2>
		<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover table-condensed">
		<tbody>
		<tr><td>Code Formation</td><td><?php echo xmlGetValue($xmlDoc, 'codeSession');?></td></tr>
		<tr><td>Organisateur</td><td><?php echo xmlGetValue($xmlDoc, 'structureOrganisatrice');?></td></tr>
		<tr><td>Responsable</td><td><?php echo xmlGetValue($xmlDoc, 'responsable');?></td></tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<?php
			if ($dateDebut == $dateFin) {echo "<tr><td>Date</td><td>".$dateDebut."</td></tr>";}
			else {echo "<tr><td>Date</td><td>du ".$dateDebut." au ".$dateFin."</td></tr>";}
		?>
		<tr><td>Lieu</td><td><?php echo xmlGetValue($xmlDoc, 'lieuSession');?></td></tr>
		<tr><td colspan="2">&nbsp;</td></tr>
		<tr><td>Document(s) Joint(s)</td><td><?php echo FormationDetail::PJ($xmlDoc);?></td></tr>
		</tbody>
		</table>
		</div>

		<div class="form-group control-group">

		<div class="col-lg-4">
		<button id ='btn_retour_calendrier' class="col-lg-12 btn btn-large btn-primary btn-default"><img hspace='2' width='16' height='16' src='<?php echo MyPage::GetDirectory();?>/img/16x16_back.png'>&nbsp;Retour au Calendrier</i></button>
		</div>

		<div class="addthisevent">
		<div class="date">
			<span class="mon"><?php echo utyDateMonth3C(substr($dateDebut,3,2));?></span>
			<span class="day"><?php echo substr($dateDebut,0,2);?></span>
			<div class="bdr1"></div>
			<div class="bdr2"></div>
		</div>
		<div class="desc">
			<p>
				<strong class="hed"><?php echo xmlGetValue($xmlDoc, 'typeFormation');?></strong>
				<span class="des"><?php echo xmlGetValue($xmlDoc, 'lieuSession');?></span>
			</p>
		</div>
		<span class="_start"><?php echo $dateDebut;?></span>
		<span class="_end"><?php echo $dateFin;?></span>
		<span class="_zonecode">40</span>
		<span class="_summary"><?php echo xmlGetValue($xmlDoc, 'typeFormation');?></span>
		<span class="_description"><?php echo "Code Formation N°".xmlGetValue($xmlDoc, 'codeSession');?></span>
		<span class="_location"><?php echo xmlGetValue($xmlDoc, 'lieuSession');?></span>
		<span class="_organizer"><?php echo xmlGetValue($xmlDoc, 'structureOrganisatrice');?></span>
		<span class="_organizer_email">Organizer e-mail</span>
		<span class="_all_day_event">true</span>
		<span class="_date_format">DD/MM/YYYY</span>
		</div>

		</div>

		<?php
	}

	function Script()
	{
		parent::Script();
		?>
		<script type="text/javascript" src="./js/formation_detail.js" ></script>
		<script type="text/javascript" src="https://addthisevent.com/libs/1.5.8/ate.min.js"></script>
		<script type="text/javascript"> $(document).ready(function(){ Init(); }); </script>
		<?php
	}
}
?>
