<?php
/**
* Template Name: calendrier
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/

// error_reporting(E_ALL); ini_set('display_errors', 1);

$calType = get_field( "cal_type" );

$dateDebut = date("d/m/Y");
// $dateFin = date('d/m/Y', strtotime('Dec 31'));
$dateFin = "";
$codeStructure = "";
$codeTypeFormation = "";
$codeTypeActiviteFormation = "";
$codeTypeEvt = "";
$codeTypeActivite = get_field( "cal_activite" );
$niveaux = "";
$codeStructureMere = "";

$arr = array();
$typeQualifications;
$familleFormations;
$regions;
$oldMonth = "";

if ($calType == 'comp') { $codeTypeEvt = "COMPOFF,COMPOPEN"; }
else if ($calType == 'mani') { $codeTypeEvt = "LOISIRS"; }
else if ($calType == 'hani') { $codeTypeEvt = "ACTHN"; }
else if ($calType == 'reun') { $codeTypeEvt = "REUNION"; $codeStructure = "0"; }

$xml = getCalendrier($dateDebut, $dateFin, $codeStructure, $codeTypeFormation, $codeTypeActiviteFormation, $codeTypeEvt, $codeTypeActivite, $niveaux, $codeStructureMere);

if ( $calType == 'comp' || $calType == 'mani' || $calType == 'reun' || $calType == 'hani') {
  foreach($xml->calendrier->evenements->evenement as $evenement) {
    $arr[] = $evenement;
    if ( !array_key_exists(explode(" - ", $evenement->comiteRegional)[0], $regions) ) {
      $regions[explode(" - ", $evenement->comiteRegional)[0]] = explode(" - ", $evenement->comiteRegional)[1];
    }
  }
}
else if ( $calType == 'form' ) {
  foreach($xml->calendrier->sessionsFormations->sessionFormation as $sessionFormation) {
    $arr[] = $sessionFormation;
    if ( !array_key_exists(wd_remove_accents(strtolower($sessionFormation->typeQualification)), $typeQualifications) ) {
      $typeQualifications[wd_remove_accents(strtolower($sessionFormation->typeQualification))] = $sessionFormation->typeQualification;
    }
    if ( !array_key_exists(wd_remove_accents(strtolower($sessionFormation->familleFormation)), $familleFormations) ) {
      $familleFormations[wd_remove_accents(strtolower($sessionFormation->familleFormation))] = $sessionFormation->familleFormation;
    }
  }
  ksort($typeQualifications);
  ksort($familleFormations);
}

usort($arr,function($a,$b){
  return strtotime(str_replace('/', '-', $a->dateDebut))-strtotime(str_replace('/', '-', $b->dateDebut));
});

?>
<?php get_header(); ?>

<!--Main Banner-->
<div class="banner_wapper master-slider">
  <div class="slider_image">
    <?php
    $slidershortcode=get_field('shortcode');
    echo do_shortcode($slidershortcode); ?>
  </div>
</div>
<!--End Main Banner-->

<?php get_sidebar(); ?>

<div class="col-md-8 col-lg-9" >

  <div class="category_right masterpage">

    <div class="inner_image">
      <?php while ( have_posts() ) : the_post();
      $image_url = wp_get_attachment_url( get_post_thumbnail_id(get_the_id()) );
      ?>
    </div>

    <div class="vc_row wpb_row vc_row-fluid vc_custom_1455897898249">
      <div class="wpb_column vc_column_container vc_col-sm-12">
        <div class="vc_column-inner vc_custom_1455897905691">
          <div class="wpb_wrapper">
            <div class="wpb_text_column wpb_content_element  vc_custom_1455897913967">
              <div class="wpb_wrapper">
                <h2><?php the_title(); ?>
                  <div class="pull-right more_button">
                    <a class="" href="http://www.ffck.org/module/calendrier/" title="Accéder au calendirer général" target="_blank"><span><i class="fa fa-calendar"></i>&nbsp;&nbsp;Calendrier général</span></a>
                  </div>
                </h2>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php the_content(); ?>

    <div class="cal-filters">
      <select id="month">
        <option value="hide">Mois</option>
        <option value="00">Tous</option>
        <option value="01">Janvier</option>
        <option value="02">Février</option>
        <option value="03">Mars</option>
        <option value="04">Avril</option>
        <option value="05">Mai</option>
        <option value="06">Juin</option>
        <option value="07">Juillet</option>
        <option value="08">Août</option>
        <option value="09">Septembre</option>
        <option value="10">Octobre</option>
        <option value="11">Novembre</option>
        <option value="12">Décembre</option>
      </select>
      <?php if ( $calType != 'reun' && $calType != 'hani' ): ?>
      &nbsp;&nbsp;&nbsp;
      <select id="region">
        <option value="hide">Région</option>
        <option value="00">Tous</option>
        <?php
          foreach ($regions as $key => $val) {
            echo '<option value="' . $key . '">' . $val . '</option>';
          }
        ?>
      </select>
      <?php endif; ?>
      <?php if($calType == 'comp'): ?>
      &nbsp;&nbsp;&nbsp;
      <select id="niveau">
        <option value="hide">Niveau</option>
        <option value="00">Tous</option>
        <option value="REG">Régional</option>
        <option value="INR">Interrégional</option>
        <option value="NAT">National</option>
        <option value="INT">International</option>
      </select>
      <?php endif;?>
      <?php if($calType == 'mani'): ?>
      &nbsp;&nbsp;&nbsp;
      <select id="activite">
        <option value="hide">Activité</option>
        <option value="00">Tous</option>
        <option value="REC">Randonnée en eau calme</option>
        <option value="REM">Randonnée en mer</option>
        <option value="REV">Randonnée en eau vive</option>
        <option value="PRO">Action de promotion</option>
        <option value="ENV">Protection de l'environnement</option>
      </select>
      <?php endif; ?>
      <?php if($calType == 'form'): ?>
      &nbsp;&nbsp;&nbsp;
      <select id="familleformation">
        <option value="hide">Formation</option>
        <option value="00">Tous</option>
        <?php
          foreach ($familleFormations as $key => $val) {
            echo '<option value="' . $key . '">' . $val . '</option>';
          }
        ?>
      </select>
      &nbsp;&nbsp;&nbsp;
      <select id="typequalification">
        <option value="hide">Qualification</option>
        <option value="00">Tous</option>
        <?php
          foreach ($typeQualifications as $keyy => $vall) {
            echo '<option value="' . $keyy . '">' . $vall . '</option>';
          }
        ?>
      </select>
      <?php endif; ?>
    </div>

    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

      <?php $count=0; foreach($arr as $event): ?>
      <?php
        $afficheUrl = "";
        // On met les dates dans un format lisible
        $dateDebut = DateTime::createFromFormat('d/m/Y', $event->dateDebut);
        $dateFin = DateTime::createFromFormat('d/m/Y', $event->dateFin);
        $dateDebut = new DateTimeFrench($dateDebut->format('d-m-Y'), $DTZ);
        $dateFin = new DateTimeFrench($dateFin->format('d-m-Y'), $DTZ);

        // on charge le détail de l'évènement
        if( $calType == 'form' ) { $xmldetail = getDetailFormation($event->id); }
        else { $xmldetail = getDetailEvenement($event->codex); }

        // On initialise les variables d'affichage générales
        $regionId = explode(" - ", $event->structureOrganisatrice)[0];
        $codeNiveau = $event->codeNiveau;
        $codeActivite = $event->codeActivite;

        // On initialise les variables d'affichage de détails
        if( $calType == 'form' ) {
          $ligueStructureOrganisatrice = $xmldetail->sessionFormation->ligueStructureOrganisatrice;
          $codeSession = $xmldetail->sessionFormation->codeSession;
          $libelleFormation = $xmldetail->sessionFormation->libelleFormation;
          $typeFormation = $xmldetail->sessionFormation->typeFormation;
          $typeQualification = $xmldetail->sessionFormation->typeQualification;
          $familleFormation = $xmldetail->sessionFormation->familleFormation;
          $codeSession = $xmldetail->sessionFormation->codeSession;
          $datesDiscontinues = $xmldetail->sessionFormation->datesDiscontinues;
          $dateDebutExamen = $xmldetail->sessionFormation->dateDebutExamen;
          $dateFinExamen = $xmldetail->sessionFormation->dateFinExamen;
          $lieuExamen = $xmldetail->sessionFormation->lieuExamen;
          $responsable = $xmldetail->sessionFormation->responsable;
          $renseignementsInformations = $xmldetail->sessionFormation->renseignementsInformations;
          $intervenants = $xmldetail->sessionFormation->intervenants;
          // inscription
          $inscriptionsContact = $xmldetail->sessionFormation->inscriptions->contact;
          //adresse
          $adresseApptEtageEsc = $xmldetail->sessionFormation->inscriptions->adresse->apptEtageEsc;
          $adresseImmBatRes = $xmldetail->sessionFormation->inscriptions->adresse->immBatRes;
          $adresseNumero = $xmldetail->sessionFormation->inscriptions->adresse->numero;
          $adressetypeVoie = $xmldetail->sessionFormation->inscriptions->adresse->typeVoie;
          $adressenomVoie = $xmldetail->sessionFormation->inscriptions->adresse->nomVoie;
          $adresselieuDit = $xmldetail->sessionFormation->inscriptions->adresse->lieuDit;
          $adressecodePostal = $xmldetail->sessionFormation->inscriptions->adresse->codePostal;
          $adresseville = $xmldetail->sessionFormation->inscriptions->adresse->ville;
          $adresseCodePays = $xmldetail->sessionFormation->inscriptions->adresse->codePays;
          $adressePays = $xmldetail->sessionFormation->inscriptions->adresse->pays;
          $adressetelephone1 = $xmldetail->sessionFormation->inscriptions->adresse->telephone1;
          $adressetelephone2 = $xmldetail->sessionFormation->inscriptions->adresse->telephone2;
          $adressefax1 = $xmldetail->sessionFormation->inscriptions->adresse->fax1;
          $adressemobile1 = $xmldetail->sessionFormation->inscriptions->adresse->mobile1;
          $adressemobile2 = $xmldetail->sessionFormation->inscriptions->adresse->mobile2;
          $adresseemail = $xmldetail->sessionFormation->inscriptions->adresse->email;
          $adresseemail2 = $xmldetail->sessionFormation->inscriptions->adresse->email2;
          $adressecodeInsee = $xmldetail->sessionFormation->inscriptions->adresse->codeInsee;
          $adresselongitude = $xmldetail->sessionFormation->inscriptions->adresse->longitude;
          $adresselatitude = $xmldetail->sessionFormation->inscriptions->adresse->latitude;
          // end adresse
          $inscriptionsDateDebutInscription = $xmldetail->sessionFormation->inscriptions->dateDebutInscription;
          $inscriptionsDateFinInscription = $xmldetail->sessionFormation->inscriptions->dateFinInscription;
          $inscriptionsparticipantMinimum = $xmldetail->sessionFormation->inscriptions->participantMinimum;
          $inscriptionsparticipantMaximum = $xmldetail->sessionFormation->inscriptions->participantMaximum;
          $inscriptionsRenseignementsInscriptions = $xmldetail->sessionFormation->inscriptions->renseignementsInscriptions;
          // end inscription

          $coutHebergement = $xmldetail->sessionFormation->coutHebergement;
          $coutPedagogique = $xmldetail->sessionFormation->coutPedagogique;
          $montantParStagiaire = $xmldetail->sessionFormation->montantParStagiaire;
          $infosMontant = $xmldetail->sessionFormation->infosMontant;
          $aideCR = $xmldetail->sessionFormation->aideCR;
          $aideCD = $xmldetail->sessionFormation->aideCD;
          $aideAutre = $xmldetail->sessionFormation->aideAutre;
          $budgetGlobal = $xmldetail->sessionFormation->budgetGlobal;
          $typePublic = $xmldetail->sessionFormation->typePublic;
          $publicConcerne = $xmldetail->sessionFormation->publicConcerne;
          $autre = $xmldetail->sessionFormation->autre;
          $objectifs = $xmldetail->sessionFormation->objectifs;
          $contenu = $xmldetail->sessionFormation->contenu;
          $nbHeures = $xmldetail->sessionFormation->nbHeures;
        }
        else {
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
          foreach($event->photos->photo as $photo) {
            if ($photo->typePhoto == "AFFICHE") {
              $afficheUrl = $photo->urlPhoto;
              $afficheUrl = str_replace('https', 'http', $afficheUrl);
            }
            if ($photo->typePhoto == "ALAUNE") { $aLaUneUrl = $photo->urlPhoto; }
          }
        }


        // On initialise les variables générales
        if ( $calType == 'form') {
          $libelle = $event->typeFormation;
          $sousLibelle = $event->lieuSession . ' - ' . explode(" - ", $event->structureOrganisatrice)[1];
          $labels = '<span class="label label-default label-' . wd_remove_accents(strtolower($event->typeQualification)) . '">' . $event->typeQualification . '</span>&nbsp;&nbsp;';
          $labels .= '<span class="label label-default label-' . wd_remove_accents(strtolower($event->familleFormation)) . '">' . $event->familleFormation . '</span>&nbsp;&nbsp;';
        }
        else if ( $calType == 'comp' || $calType == 'mani' || $calType == 'reun' || $calType == 'hani' ) {
          $libelle = $event->nomEvenement;
          $sousLibelle = ucfirst(strtolower($xmldetail->manifestation->lieuEvenement->ville));
          $sousLibelle .= ',&nbsp;' . strtoupper($xmldetail->manifestation->lieuEvenement->pays);
          if($event->codeTypeEvenement == 'COMPOFF') {
            $labels = '<span class="label label-warning"><i class="fa fa-trophy"></i>&nbsp;&nbsp;' . $event->libelleTypeEvenement . '</span>&nbsp;&nbsp;';
            $labels .= '<span class="label label-default label-' . wd_remove_accents(strtolower($event->libelleNiveau)) . '">' . $event->libelleNiveau . '</span>&nbsp;&nbsp;';
            if ( strtolower($event->nomEvenement) != strtolower($event->libelleEvenement) ) {
              $labels .= '<span class="label label-default">' . $event->libelleEvenement . '</span>';
            }
          }
          if($event->codeTypeEvenement == 'COMPOPEN') {
            $labels = '<span class="label label-success"><i class="fa fa-trophy"></i>&nbsp;&nbsp;' . $event->libelleTypeEvenement . '</span>&nbsp;&nbsp;';
            $labels .= '<span class="label label-default label-' . wd_remove_accents(strtolower($event->libelleNiveau)) . '">' . $event->libelleNiveau . '</span>&nbsp;&nbsp;';
            if ( strtolower($event->nomEvenement) != strtolower($event->libelleEvenement) ) {
              $labels .= '<span class="label label-default">' . $event->libelleEvenement . '</span>';
            }
          }
          if ( $event->codeTypeEvenement == 'LOISIRS' ) {
            $libelle = $event->nomEvenement;
            $labels = '<span class="label label-info">' . $event->libelleActivite . '</span>&nbsp;&nbsp;';
            $labels .= '<span class="label label-default">' . explode(" - ", $event->structureOrganisatrice)[1] . '</span>';
          }
          if ( $event->codeTypeEvenement == 'ACTHN' ) {
            $labels = '<span class="label label-info">' . $event->libelleActivite . '</span>&nbsp;&nbsp;';
            $labels .= '<span class="label label-default">' . $event->libelleTypeEvenement . '</span>';
          }
        }
      ?>

      <?php if($count == 0): ?>
      <div class="month month-<?php echo $dateDebut->format('m') ?> month-first">
        <div class="titre-mois"><?php echo $dateDebut->format('F'); ?> <small><?php echo $dateDebut->format('Y'); ?></small></div>
      <?php endif; ?>
      <?php if($oldMonth != $dateDebut->format('F') && $count != 0): ?>
      </div>
      <div class="month month-<?php echo $dateDebut->format('m') ?>">
        <div class="titre-mois"><?php echo $dateDebut->format('F'); ?> <small><?php echo $dateDebut->format('Y'); ?></small></div>
      <?php endif; ?>

        <!-- 1 évènement -->
        <div class="panel panel-default panel-event panel-region-<?php echo $regionId ?> panel-niveau-<?php echo $codeNiveau ?> panel-activite-<?php echo $codeActivite; ?> panel-<?php echo wd_remove_accents(strtolower($event->typeQualification)); ?> panel-<?php echo wd_remove_accents(strtolower($event->familleFormation)); ?>">

          <!-- Titre de l'évènement -->
          <div class="panel-heading" role="tab" id="<?php if( $calType=='form') { echo $event->id; } else { echo $event->codex; } ?>">
            <h4 class="panel-title">
              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?php if( $calType=='form') { echo $event->id; } else { echo $event->codex; } ?>" aria-expanded="true" aria-controls="collapse-<?php if( $calType=='form') { echo $event->id; } else { echo $event->codex; } ?>">
                <div class="event-dates">
                  <div>
                    <i class="fa fa-calendar"></i><br>
                    <span class="jour"><?php echo $dateDebut->format('d'); ?></span>
                    <?php if($dateDebut != $dateFin): ?>
                      &nbsp;-&nbsp;<span class="jour"><?php echo $dateFin->format('d'); ?></span>
                    <?php endif; ?>
                  </div>
                  <div>
                    <span class="mois"><?php if (strlen($dateDebut->format('F')) > 5) { echo substr($dateDebut->format('F'), 0, 3) . '.'; } else { echo $dateDebut->format('F'); }  ?></span>
                    <?php if($dateDebut->format('F') != $dateFin->format('F')): ?>.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="mois"><?php echo substr($dateFin->format('F'), 0, 4); ?></span><?php endif; ?>
                  </div>
                </div>
                <div class="event-libelle">
                  <?php echo $libelle ?>
                </div>
                <div class="event-souslibelle">
                  <i class="fa fa-map-marker"></i>&nbsp;&nbsp;<?php echo $sousLibelle; ?>
                </div>
                <div><?php echo $labels ?></div>
              </a>
            </h4>
          </div>

          <!-- Détails de l'évènement -->
          <div id="collapse-<?php if( $calType=='form') { echo $event->id; } else { echo $event->codex; } ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="<?php if( $calType=='form') { echo $event->id; } else { echo $event->codex; } ?>">

            <!-- Détail manifestation -->
            <?php if($calType != 'form'): ?>
            <div class="panel-body" style="position:relative;">
              <div class="row" style="margin-bottom:10px;">
                <div class="col-xs-12 col-sm-6">
                  <div class="col-xs-4 text-right no-hpadding">Organisateur :</div>
                  <div class="col-xs-8"><?php echo $xmldetail->manifestation->structure->nom; ?></div>
                  <div class="col-xs-4 text-right no-hpadding">Contact :</div>
                  <div class="col-xs-8"><?php echo $xmldetail->manifestation->responsable->personne->civilite . ' ' .$xmldetail->manifestation->responsable->personne->prenom . ' ' . $xmldetail->manifestation->responsable->personne->nom ?></div>
                  <!-- <div class="col-xs-4 text-right no-hpadding">Pagaie :</div>
                  <div class="col-xs-8" style="margin-top:8px;">
                    <?php if($xmldetail->manifestation->libellePagaieMinimum != ''): ?><span class="label label-default label-<?php echo wd_remove_accents(strtolower($xmldetail->manifestation->libellePagaieMinimum)); ?>"><?php echo $xmldetail->manifestation->libellePagaieMinimum ?></span><?php endif; ?>
                  </div> -->
                </div>
                <div class="col-xs-12 col-sm-6">
                  <div class="col-xs-3 text-right no-hpadding">Lieu :</div>
                  <div class="col-xs-9">
                    <?php echo $adresseComplete ?>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12">
                  <?php $count = 0; foreach($xmldetail->manifestation->fichiers->fichier as $fichier) { ?>
                    <?php $count++; if($fichier != "" && $count == 1) { echo 'Documents:<br>'; } ?>
                    <a href="<?php echo $fichier; ?>" class="btn btn-link" target="_blank"><?php echo explode("&nomFichier=", $fichier)[1]; ?></a>
                  <?php } ?>
                </div>
              </div>
              <div class="row" style="margin-top:8px;">
                <div class="col-xs-12">
                  <?php if($siteWebEvt != ""): ?>
                    <a href="<?php echo $siteWebEvt ?>" class="btn btn-default btn-sm" target="_blank"><i class="fa fa-globe"></i>&nbsp;&nbsp;Site web</a>&nbsp;&nbsp;
                  <?php endif; ?>
                  <?php if($emailStructure != ""): ?>
                    <a href="mailto:<?php echo $emailStructure ?>" class="btn btn-default btn-sm"><i class="fa fa-envelope"></i>&nbsp;&nbsp;Email structure</a>&nbsp;&nbsp;
                  <?php endif; ?>
                  <?php if($emailEvt != ""): ?>
                    <a href="mailto:<?php echo $emailEvt ?>" class="btn btn-default btn-sm"><i class="fa fa-envelope"></i>&nbsp;&nbsp;Email organisateur</a>&nbsp;&nbsp;
                  <?php endif; ?>
                  <?php if($telStructure != ''): ?>
                    <a href="#" class="btn btn-default btn-sm"><i class="fa fa-phone"></i>&nbsp;&nbsp;<?php echo $telStructure ?></a>&nbsp;&nbsp;
                  <?php endif; ?>
                  <?php if($mobileStructure != ''): ?>
                    <a href="#" class="btn btn-default btn-sm"><i class="fa fa-mobile"></i>&nbsp;&nbsp;<?php echo $mobileStructure ?></a>
                  <?php endif; ?>&nbsp;&nbsp;
                  <?php if($afficheUrl != ''): ?>
                    <a href="<?php echo $afficheUrl ?>" class="btn btn-warning btn-sm" target="_blank"><i class="fa fa-cloud-download"></i>&nbsp;&nbsp;Affiche</a>
                  <?php endif; ?>&nbsp;&nbsp;
                  <?php if($latStructure != '' && $lngStructure != ''): ?>
                  <a href="http://maps.google.com/maps?f=d&daddr=<?php echo $latStructure ?>,<?php echo $lngStructure ?>&hl=fr" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-compass"></i>&nbsp;&nbsp;Itinéraire</a>
                  <?php endif; ?>
                </div>
              </div>
            </div>
            <!-- Détail formation -->
            <?php else: ?>
              <div class="panel-body" style="position:relative;">
                <div class="row" style="margin-bottom:10px;">
                  <div class="col-xs-12 col-sm-6">
                    <?php if($ligueStructureOrganisatrice!=''): ?>
                    <div class='col-xs-12'><?php echo explode(" - ", $ligueStructureOrganisatrice)[1] ?></div><?php endif; ?>

                    <?php if($typeFormation!=''): ?><div class='col-xs-5 text-right'>Formation :</div>
                    <div class='col-xs-7'><?php echo $typeFormation ?></div><?php endif; ?>

                    <?php if($dateDebutExamen!=''): ?><div class='col-xs-5 text-right'>Début examen :</div>
                    <div class='col-xs-7'><?php echo $dateDebutExamen ?></div><?php endif; ?>

                    <?php if($dateFinExamen!=''): ?><div class='col-xs-5 text-right'>Fin examen :</div>
                    <div class='col-xs-7'><?php echo $dateFinExamen ?></div><?php endif; ?>

                    <?php if($lieuExamen!=''): ?><div class='col-xs-5 text-right'>Lieu examen :</div>
                    <div class='col-xs-7'><?php echo $lieuExamen ?></div><?php endif; ?>

                    <?php if($responsable!=''): ?><div class='col-xs-5 text-right'>Responsable :</div>
                    <div class='col-xs-7'><?php echo explode(" - ", $responsable)[1] ?></div><?php endif; ?>

                    <?php if($inscriptionsDateDebutInscription!=''): ?><div class='col-xs-5 text-right'>Début inscription :</div>
                    <div class='col-xs-7'><?php echo $inscriptionsDateDebutInscription ?></div><?php endif; ?>

                    <?php if($inscriptionsDateFinInscription!=''): ?><div class='col-xs-5 text-right'>Fin inscription :</div>
                    <div class='col-xs-7'><?php echo $inscriptionsDateFinInscription ?></div><?php endif; ?>

                    <!-- <?php if($coutHebergement!=''): ?><div class='col-xs-5 text-right'>Coût hébergement :</div>
                    <div class='col-xs-7'><?php echo $coutHebergement ?></div><?php endif; ?>

                    <?php if($coutPedagogique!=''): ?><div class='col-xs-5 text-right'>Coût pedagogique :</div>
                    <div class='col-xs-7'><?php echo $coutPedagogique ?></div><?php endif; ?>

                    <?php if($montantParStagiaire!=''): ?><div class='col-xs-5 text-right'>Montant :</div>
                    <div class='col-xs-7'><?php echo $montantParStagiaire ?></div><?php endif; ?>

                    <?php if($infosMontant!=''): ?><div class='col-xs-5 text-right'>Infos montant :</div>
                    <div class='col-xs-7'><?php echo $infosMontant ?></div><?php endif; ?>
 -->
                    <?php if($typePublic!=''): ?><div class='col-xs-5 text-right'>Type public :</div>
                    <div class='col-xs-7'><?php echo $typePublic ?></div><?php endif; ?>

                    <?php if($nbHeures!=''): ?><div class='col-xs-5 text-right'>Nb heures :</div>
                    <div class='col-xs-7'><?php echo $nbHeures ?></div><?php endif; ?>
                  </div>
                  <div class="col-xs-12 col-sm-6">
                    <div class='col-xs-5 text-right'>Inscription :</div>
                    <div class='col-xs-7'>
                      <?php if($inscriptionsContact!=''): ?><?php echo explode(" - ", $inscriptionsContact)[1] ?><br><?php endif; ?>
                      <?php if($adresseApptEtageEsc!=''): ?><?php echo $adresseApptEtageEsc ?><br><?php endif; ?>
                      <?php if($adresseImmBatRes!=''): ?><?php echo $adresseImmBatRes ?><br><?php endif; ?>
                      <?php if($adresseNumero!=''): ?><?php echo $adresseNumero ?><br><?php endif; ?>
                      <?php if($adressetypeVoie!=''): ?><?php echo $adressetypeVoie ?><br><?php endif; ?>
                      <?php if($adressenomVoie!=''): ?><?php echo $adressenomVoie ?><br><?php endif; ?>
                      <?php if($adresselieuDit!=''): ?><?php echo $adresselieuDit ?><br><?php endif; ?>
                      <?php if($adressecodePostal!=''): ?><?php echo $adressecodePostal ?><br><?php endif; ?>
                      <?php if($adresseville!=''): ?><?php echo $adresseville ?><br><?php endif; ?>
                      <?php if($adressePays!=''): ?><?php echo $adressePays ?><br><?php endif; ?>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <?php if($inscriptionsRenseignementsInscriptions!=''): ?><div class='col-xs-5 text-right'>Renseignements inscriptions :</div>
                  <div class='col-xs-7'><?php echo $inscriptionsRenseignementsInscriptions ?></div><?php endif; ?>
                </div>
                <div class="row">
                  <?php if($renseignementsInformations!=''): ?><div class='col-xs-12'>Informations complémentaires :</div>
                  <div class='col-xs-12'><?php echo $renseignementsInformations ?></div><?php endif; ?>
                </div>
                <div class="row" style="margin-top:8px;">
                  <div class="col-xs-12">
                    <?php if($adresseemail != ""): ?>
                      <a href="mailto:<?php echo $adresseemail ?>" class="btn btn-default btn-sm"><i class="fa fa-envelope"></i>&nbsp;&nbsp;Email organisateur</a>&nbsp;&nbsp;
                    <?php endif; ?>
                    <?php if($adressetelephone1 != ''): ?>
                      <a href="#" class="btn btn-default btn-sm"><i class="fa fa-phone"></i>&nbsp;&nbsp;<?php echo $adressetelephone1 ?></a>&nbsp;&nbsp;
                    <?php endif; ?>
                    <?php if($adressemobile1 != ''): ?>
                      <a href="#" class="btn btn-default btn-sm"><i class="fa fa-mobile"></i>&nbsp;&nbsp;<?php echo $adressemobile1 ?></a>
                    <?php endif; ?>&nbsp;&nbsp;
                    <?php if ($adresselatitude != ""): ?>
                    <a href="https://maps.google.com?daddr=<?php echo $adresselatitude ?>,<?php echo $adresselongitude ?>" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-compass"></i>&nbsp;&nbsp;Itinéraire</a>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            <?php endif; ?>
          </div> <!--/.collapse -->
        </div> <!-- /.panel -->

        <?php $oldMonth = $dateDebut->format('F'); $count++; ?>
        <?php endforeach; ?>

      </div> <!-- /.month -->
    </div> <!-- /.panel-group -->
    <?php endwhile; ?>
  </div> <!-- /.category_right -->
</div> <!-- /.col-md -->

</div>
</div>
</div>
</div>
</div>
</section>

<?php get_footer();
