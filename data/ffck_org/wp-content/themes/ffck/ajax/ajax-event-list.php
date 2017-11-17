<?php
	// header("Access-Control-Allow-Origin: *");

	// error_reporting(E_ALL); ini_set('display_errors', 1);

$folder = substr(substr($_SERVER["REQUEST_URI"],1), 0, strpos(substr($_SERVER["REQUEST_URI"],1), "/"));
if ( strpos($_SERVER["DOCUMENT_ROOT"], "wamp") != false ) {
  $ajax_url = realpath($_SERVER["DOCUMENT_ROOT"]).'/wp-load.php';
}
else {
  $ajax_url = realpath($_SERVER["DOCUMENT_ROOT"]).'/'.'/wp-load.php';
}

require($ajax_url);

if ( isset($_GET["scActivite"]) ) {
  $scActivite = $_GET["scActivite"];
}

$dateDebut = date("d/m/Y");
$dateFin = "";
$codeStructure = "";
$codeTypeFormation = "";
$codeTypeActiviteFormation = "";
$codeTypeEvt = "";

$niveaux = "";
$codeStructureMere = "";
$optional = "&visibleInternetOnly=true";

$xml = getCalendrier($dateDebut, $dateFin, $codeStructure, $codeTypeFormation, $codeTypeActiviteFormation, $codeTypeEvt, $scActivite, $niveaux, $codeStructureMere, $optional);

foreach($xml->calendrier->evenements->evenement as $evenement) {
  $arr[] = $evenement;
}
usort($arr,function($a,$b){
  return strtotime(str_replace('/', '-', $a->dateDebut))-strtotime(str_replace('/', '-', $b->dateDebut));
});

?>

<div class="desktop_slider">
  <div class="event_slider">

    <?php foreach($arr as $event){ ?>

    <?php
          // On met les dates dans un format lisible
    $dateDebut = DateTime::createFromFormat('d/m/Y', $event->dateDebut);
    $dateFin = DateTime::createFromFormat('d/m/Y', $event->dateFin);
    $dateDebut = new DateTimeFrench($dateDebut->format('d-m-Y'), $DTZ);
    $dateFin = new DateTimeFrench($dateFin->format('d-m-Y'), $DTZ);

          // on charge le détail de l'évènement
    $xmldetail = getDetailEvenement($event->codex);

          // On initialise les variables d'affichage générales
    $regionId = explode(" - ", $event->structureOrganisatrice)[0];
    $codeNiveau = $event->codeNiveau;
    $codeActivite = $event->codeActivite;

          // On initialise les variables d'affichage de détails
    $siteWebEvt = $xmldetail->manifestation->siteWeb;
    $emailStructure = $xmldetail->manifestation->structure->adresse->email;
    $emailEvt = $xmldetail->manifestation->lieuEvenement->email;
    $telStructure = $xmldetail->manifestation->structure->adresse->telephone1;
    $mobileStructure = $xmldetail->manifestation->structure->adresse->mobile1;
    $latStructure = $xmldetail->manifestation->structure->adresse->latitude;
    $lngStructure = $xmldetail->manifestation->structure->adresse->longitude;
    $adresseComplete = "";
    if ($event->lieu != '') $adresseComplete .= $event->lieu . '<br>';
    if ($xmldetail->manifestation->lieuEvenement->numero != '') $adresseComplete .= $xmldetail->manifestation->lieuEvenement->numero . ' ';
    if ($xmldetail->manifestation->lieuEvenement->typeVoie != '') $adresseComplete .= $xmldetail->manifestation->lieuEvenement->typeVoie . ' ';
    if ($xmldetail->manifestation->lieuEvenement->nomVoie != '') $adresseComplete .= $xmldetail->manifestation->lieuEvenement->nomVoie . '<br>';
    if ($xmldetail->manifestation->lieuEvenement->lieuDit != '') $adresseComplete .= $xmldetail->manifestation->lieuEvenement->lieuDit . '<br>';
    if ($xmldetail->manifestation->lieuEvenement->codePostal != '') $adresseComplete .= $xmldetail->manifestation->lieuEvenement->codePostal . ', ' . $xmldetail->manifestation->lieuEvenement->ville . '<br>';
    if ($xmldetail->manifestation->lieuEvenement->pays != '') $adresseComplete .= $xmldetail->manifestation->lieuEvenement->pays;
    $libelle = $event->nomEvenement;
    $sousLibelle = ucfirst(strtolower($xmldetail->manifestation->lieuEvenement->ville));
    if ( $xmldetail->manifestation->lieuEvenement->ville != "" && $xmldetail->manifestation->lieuEvenement->pays != "" ) {
      $sousLibelle .= ',&nbsp;';
    }
    $sousLibelle .= strtoupper($xmldetail->manifestation->lieuEvenement->pays);
    foreach($event->photos->photo as $photo) {
      if ($photo->typePhoto == "AFFICHE") {
        $afficheUrl = $photo->urlPhoto;
        $afficheUrl = str_replace('https', 'http', $afficheUrl);
      }
      if ($photo->typePhoto == "ALAUNE") {
        $aLaUneUrl = $photo->urlPhoto;
        $aLaUneUrl = str_replace('https', 'http', $aLaUneUrl);
      }
    }
          // Cas compoff
    if($event->codeTypeEvenement == 'COMPOFF') {
      $labels = '<span class="label label-warning"><i class="fa fa-trophy"></i>&nbsp;&nbsp;' . $event->libelleTypeEvenement . '</span>&nbsp;&nbsp;';
      $labels .= '<span class="label label-default label-' . wd_remove_accents(strtolower($event->libelleNiveau)) . '">' . $event->libelleNiveau . '</span>&nbsp;&nbsp;';
            // $labels .= '<span class="label label-default">' . explode(" - ", $event->structureOrganisatrice)[1] . '</span>';
      if ( strtolower($event->nomEvenement) != strtolower($event->libelleEvenement) ) {
        $labels .= '<span class="label label-default">' . $event->libelleEvenement . '</span>';
      }
    }
          // Cas compopen
    if($event->codeTypeEvenement == 'COMPOPEN') {
      $labels = '<span class="label label-success"><i class="fa fa-trophy"></i>&nbsp;&nbsp;' . $event->libelleTypeEvenement . '</span>&nbsp;&nbsp;';
      $labels .= '<span class="label label-default label-' . wd_remove_accents(strtolower($event->libelleNiveau)) . '">' . $event->libelleNiveau . '</span>&nbsp;&nbsp;';
            // $labels .= '<span class="label label-default">' . explode(" - ", $event->structureOrganisatrice)[1] . '</span>';
      if ( strtolower($event->nomEvenement) != strtolower($event->libelleEvenement) ) {
        $labels .= '<span class="label label-default">' . $event->libelleEvenement . '</span>';
      }
    }

    ?>

    <div class="item">
      <div class="evene_box">
        <div class="evene_box_image">
          <img src="<?php echo $aLaUneUrl; ?>"  alt="">
        </div>
        <div class="evene_box_sub">
          <div class="date"><span><?php echo $dateDebut->format('d'); ?></span><?php echo substr($dateDebut->format('F'), 0, 4); ?></div>
          <div class="icon_row">
            <?php
            if (str_replace(' ','-',strtolower($event->libelleActivite) == 'course-en-ligne')) {
              $src = get_site_url () . "/wp-content/uploads/2016/02/cat-icon-courseenligne.png";
            }
            if (str_replace(' ','-',strtolower($event->libelleActivite) == 'descente')) {
              $src = get_site_url () . "/wp-content/uploads/2016/02/cat-icon-descente.png";
            }
            if (str_replace(' ','-',strtolower($event->libelleActivite) == 'dragon-boat')) {
              $src = get_site_url () . "/wp-content/uploads/2016/02/cat-icon-dragonboat.png";
            }
            if (str_replace(' ','-',strtolower($event->libelleActivite) == 'freestyle')) {
              $src = get_site_url () . "/wp-content/uploads/2016/02/cat-icon-freestyle.png";
            }
            if (str_replace(' ','-',strtolower($event->libelleActivite) == 'kayak-polo')) {
              $src = get_site_url () . "/wp-content/uploads/2016/02/cat-icon-kayakpolo.png";
            }
            if (str_replace(' ','-',strtolower($event->libelleActivite) == 'marathon')) {
              $src = get_site_url () . "/wp-content/uploads/2016/02/cat-icon-marathon.png";
            }
            if (str_replace(' ','-',strtolower($event->libelleActivite) == 'ocean-racing')) {
              $src = get_site_url () . "/wp-content/uploads/2016/02/cat-icon-oceanracing.png";
            }
            if (str_replace(' ','-',strtolower($event->libelleActivite) == 'paracanoe')) {
              $src = get_site_url () . "/wp-content/uploads/2016/02/cat-icon-paracanoe.png";
            }
            if (str_replace(' ','-',strtolower($event->libelleActivite) == 'slalom')) {
              $src = get_site_url () . "/wp-content/uploads/2016/02/cat-icon-slalom.png";
            }
            if (str_replace(' ','-',strtolower($event->libelleActivite) == 'vaa-vitesse')) {
              $src = get_site_url () . "/wp-content/uploads/2016/02/cat-icon-vaavitesse.png";
            }
            if (str_replace(' ','-',strtolower($event->libelleActivite) == 'vaa-vitesse')) {
              $src = get_site_url () . "/wp-content/uploads/2016/02/cat-icon-vaavitesse.png";
            }
            if (str_replace(' ','-',strtolower($event->libelleActivite) == 'waveski-surfing')) {
              $src = get_site_url () . "/wp-content/uploads/2016/02/cat-icon-waveskisurfing.png";
            }
            ?>
            <img src="<?php echo $src; ?>" alt="">
            <?php echo $event->libelleActivite; ?>
          </div>
          <h3><?php echo $libelle ?></h3>
          <div class="address">
            <span><img src="<?php echo get_template_directory_uri(); ?>/images/address.png"  alt=""></span>
            <p><?php echo $sousLibelle ?></p>
            <!-- <p><?php echo $adresseComplete ?></p> -->
          </div>
          <div class="address">
            <span><img src="<?php echo get_template_directory_uri(); ?>/images/date.png"  alt=""></span>
            <p>
              <?php if($dateDebut != $dateFin): ?>du <?php endif; ?>
              <?php echo $dateDebut->format('d') . ' ' . $dateDebut->format('F'); ?>
              <?php if($dateDebut != $dateFin): ?>
                <?php echo ' au ' . $dateFin->format('d') . ' ' . $dateFin->format('F'); ?>
              <?php endif; ?>
            </p>
          </div>
          <div class="read_more">
            <a href="<?php echo get_the_permalink(); ?>" data-featherlight="#opencard-<?php echo $event->codex; ?>" data-featherlight-variant="fixwidth"><span>En savoir plus</span></a>
          </div>
        </div>
      </div>
      <div id="opencard-<?php echo $event->codex; ?>" class="openedcard">
        <h2><?php echo $libelle ?></h2>
        <div class="opencard-wrapper">
          <div class="row">
            <div class="col-xs-12">
              <div class="event-dates">
                <div style="margin-top:5px;">
                  <i class="fa fa-calendar"></i>&nbsp;
                  <?php if($dateDebut != $dateFin): ?>du <?php endif; ?>
                  <?php echo $dateDebut->format('d') . ' ' . $dateDebut->format('F'); ?>
                  <?php if($dateDebut != $dateFin): ?>
                    <?php echo ' au ' . $dateFin->format('d') . ' ' . $dateFin->format('F'); ?>
                  <?php endif; ?>&nbsp;&nbsp;&nbsp;
                  <?php // echo $labels ?>
                </div>
              </div>
            </div>
          </div>
          <div class="row" style="margin:28px 0 10px 0;">
            <div class="col-xs-12 col-sm-6">
                  <!-- <div class="col-xs-4 text-right">Organisateur :</div>
                  <div class="col-xs-8"><?php echo $xmldetail->manifestation->structure->nom; ?></div> -->
                  <!-- <div class="col-xs-4 text-right">Contact :</div>
                  <div class="col-xs-8"><?php echo $xmldetail->manifestation->responsable->personne->civilite . ' ' .$xmldetail->manifestation->responsable->personne->prenom . ' ' . $xmldetail->manifestation->responsable->personne->nom ?></div> -->
                  <!-- <div class="col-xs-4 text-right">Pagaie :</div>
                  <div class="col-xs-8" style="margin-top:8px;">
                    <?php if($xmldetail->manifestation->libellePagaieMinimum != ''): ?><span class="label label-default label-<?php echo wd_remove_accents(strtolower($xmldetail->manifestation->libellePagaieMinimum)); ?>"><?php echo $xmldetail->manifestation->libellePagaieMinimum ?></span><?php endif; ?>
                  </div> -->
                  <div class="col-xs-3 text-right">Lieu :</div>
                  <div class="col-xs-9">
                    <?php echo $adresseComplete ?>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                  <?php if($afficheUrl != ''): ?>
                    <img src="<?php echo $afficheUrl ?>" alt="Affiche promotionnelle" style="width:100%; height:auto;">
                  <?php endif; ?>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12">
                  <?php foreach($xmldetail->manifestation->fichiers->fichier as $fichier) { ?>
                  <?php $count++; if($fichier != "" && $count == 1) { echo 'Documents:<br>'; } ?>
                  <a href="<?php echo $fichier; ?>" class="btn btn-link" target="_blank" style="color:#fff; text-decoration:underline;"><?php echo explode("&nomFichier=", $fichier)[1]; ?></a>
                  <?php } ?>
                </div>
              </div>
              <div class="row" style="margin-top:20px;">
                <div class="col-xs-12">
                  <?php if($siteWebEvt != ""): ?>
                    <a href="<?php echo $siteWebEvt ?>" class="btn btn-default btn-sm" target="_blank"><i class="fa fa-globe"></i>&nbsp;&nbsp;Site web</a>&nbsp;&nbsp;
                  <?php endif; ?>
                  <?php if($emailStructure != ""): ?>
                    <!-- <a href="mailto:<?php echo $emailStructure ?>" class="btn btn-default btn-sm"><i class="fa fa-envelope"></i>&nbsp;&nbsp;Email structure</a>&nbsp;&nbsp; -->
                  <?php endif; ?>
                  <?php if($emailEvt != ""): ?>
                    <!-- <a href="mailto:<?php echo $emailEvt ?>" class="btn btn-default btn-sm"><i class="fa fa-envelope"></i>&nbsp;&nbsp;Email organisateur</a>&nbsp;&nbsp; -->
                  <?php endif; ?>
                  <?php if($telStructure != ''): ?>
                    <!-- <a href="#" class="btn btn-default btn-sm"><i class="fa fa-phone"></i>&nbsp;&nbsp;<?php echo $telStructure ?></a>&nbsp;&nbsp; -->
                  <?php endif; ?>
                  <?php if($mobileStructure != ''): ?>
                    <!-- <a href="#" class="btn btn-default btn-sm"><i class="fa fa-mobile"></i>&nbsp;&nbsp;<?php echo $mobileStructure ?></a> -->
                  <?php endif; ?>&nbsp;&nbsp;
                  <!-- <a href="https://maps.google.com?daddr=<?php echo $latStructure ?>,<?php echo $lngStructure ?>" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-compass"></i>&nbsp;&nbsp;Itinéraire</a> -->
                </div>
              </div>

            </div>
          </div>
        </div> <!-- /item -->
        <?php } ?>
      </div>
    </div>
