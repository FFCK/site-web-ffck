<?php 
require("http://localhost/wp-content/themes/ffck/inc/BaseOBS.php");
$dbOBS = new MyBaseOBS();

//on initialise les variables qui récupèrent les calendriers évènements et formations
$tCalendrier = null ;
$tCalendrierFormations = null ;

//on initialise les variables utilisées en paramètre des requêtes sql
$dateDebut = date("d/m/Y");
$dateFin = date('d/m/Y', strtotime('Dec 31'));
//$dateDebut = "01/01/2016";
//$dateFin = "31/12/2017";
$debutRecherche = utyDateFrToUs($dateDebut);
$finRecherche = utyDateFrToUs($dateFin);

// on récupére les paramètres dans le backoffice WP
$calType = 'comp';//get_field( "cal_type" );
$codeTypeActivite = 'SLA';//get_field ( "cal_activite" );


//on initialise les variables utilisées pour filtrer le calendrier
$codeTypeEvt = null;
$niveau = null;

//on initialise les variables utilisées pour filtrer les formations
$familleFormation = null;
$typeFormation = null;

// error_reporting(E_ALL); ini_set('display_errors', 1);
$regions = array();
$typeQualifications = array();
$familleFormations = array();


if ($calType == 'comp') { $codeTypeEvt = "'COMPOFF','COMPOPEN'"; }
else if ($calType == 'mani') { $codeTypeEvt = "LOISIRS"; }
else if ($calType == 'hani') { $codeTypeEvt = "ACTHN"; }
else if ($calType == 'reun') { $codeTypeEvt = "REUNION"; $codeStructure = "0"; }

if ( $calType == 'comp' || $calType == 'mani' || $calType == 'reun' || $calType == 'hani') 
{ 
  //on charge dans la variable tCalendrier le calendrier
  $dbOBS->LoadCalendrier($tCalendrier, $debutRecherche, $finRecherche, $codeTypeEvt, $codeTypeActivite, $niveau, $region);
  //print_r($tCalendrier);
  
  foreach($tCalendrier as $evenement) {
    $arr[] = $evenement;
    if ( !array_key_exists(explode(" - ", $evenement['comiteRegional'])[0], $regions) ) {
      $regions[explode(" - ", $evenement['comiteRegional'])[0]] = substr(explode(" - COMITE REGIONAL", $evenement['comiteRegional'])[1],0, -2);
    }
  }
  
}

else if ( $calType == 'form' ) 
{
  //on charge dans la variable tCalendrierFormations le calendrier des formation
  $dbOBS->LoadCalendrierFormations($tCalendrier, $debutRecherche, $finRecherche, $familleFormation, $typeFormation);
  //print_r($tCalendrier);
  // $regions[key] = value;

  foreach($tCalendrier as $formation) {
    $arr[] = $formation;
    if ( !array_key_exists(explode(" - ", $formation['ligueStructureOrganisatrice'])[0], $regions) ) {
      $regions[explode(" - ", $formation['ligueStructureOrganisatrice'])[0]] = substr(explode(" - COMITE REGIONAL", $formation['ligueStructureOrganisatrice'])[1], -2);
    }
    if ( !array_key_exists(wd_remove_accents(strtolower($formation['typeQualification'])), $typeQualifications) ) {
      $typeQualifications[wd_remove_accents(strtolower($formation['typeQualification']))] = $formation['typeQualification'];
    }
    if ( !array_key_exists(wd_remove_accents(strtolower($formation['familleFormation'])), $familleFormations) ) {
      $familleFormations[wd_remove_accents(strtolower($formation['familleFormation']))] = $formation['familleFormation'];
    }
  }
}
?>
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

  <?php $count=0; foreach($tCalendrier as $calendrier): ?>

  <?php

        // On met les dates dans un format lisible
  $dateDebut = DateTime::createFromFormat('Y-m-d', $calendrier['dateDebut']);
  $dateFin = DateTime::createFromFormat('Y-m-d', $calendrier['dateFin']);
  $dateDebut = new DateTimeFrench($dateDebut->format('d-m-Y'), $DTZ);
  $dateFin = new DateTimeFrench($dateFin->format('d-m-Y'), $DTZ);

        // On initialise les variables d'affichage de détails
  if( $calType == 'form' )
  {
        // A VOIR QUAND ON TRAITE LES FORMATIONS
    $idFormation = $calendrier['id'];
    $codeSession = $calendrier['codeSession'];
    $regionId = explode(" - ", $calendrier['ligueStructureOrganisatrice'])[0];

        $ligueStructureOrganisatrice = $calendrier['ligueStructureOrganisatrice']; //$xmldetail->sessionFormation->ligueStructureOrganisatrice;
        $codeSession = $calendrier['codeSession']; //$xmldetail->sessionFormation->codeSession;
        $libelleFormation = $calendrier['libelleFormation']; //$xmldetail->sessionFormation->libelleFormation;
        $typeFormation = $calendrier['typeFormation']; //$xmldetail->sessionFormation->typeFormation;
        $typeQualification = $calendrier['typeQualification']; //$xmldetail->sessionFormation->typeQualification;
        $familleFormation = $calendrier['familleFormation']; //$xmldetail->sessionFormation->familleFormation;
        $datesDiscontinues = "";//$xmldetail->sessionFormation->datesDiscontinues;
            $dateDebutExamen = $calendrier['dateDebutExamen'];//$xmldetail->sessionFormation->dateDebutExamen;
            $dateFinExamen = $calendrier['dateFinExamen'];//$xmldetail->sessionFormation->dateFinExamen;
            $lieuExamen = $calendrier['lieuExamen']; //$xmldetail->sessionFormation->lieuExamen;
            $responsable = $calendrier['responsable']; //$xmldetail->sessionFormation->responsable;
            $renseignementsInformations = "";//$xmldetail->sessionFormation->renseignementsInformations;
            $intervenants = "";//$xmldetail->sessionFormation->intervenants;
              // inscription
            $inscriptionsContact = "";//$xmldetail->sessionFormation->inscriptions->contact;
              //adresse
            $adresseApptEtageEsc = "";//$xmldetail->sessionFormation->inscriptions->adresse->apptEtageEsc;
            $adresseImmBatRes = "";//$xmldetail->sessionFormation->inscriptions->adresse->immBatRes;
            $adresseNumero = "";//$xmldetail->sessionFormation->inscriptions->adresse->numero;
            $adressetypeVoie = "";//$xmldetail->sessionFormation->inscriptions->adresse->typeVoie;
            $adressenomVoie = "";//$xmldetail->sessionFormation->inscriptions->adresse->nomVoie;
            $adresselieuDit = "";//$xmldetail->sessionFormation->inscriptions->adresse->lieuDit;
            $adressecodePostal = "";//$xmldetail->sessionFormation->inscriptions->adresse->codePostal;
            $adresseville = "";//$xmldetail->sessionFormation->inscriptions->adresse->ville;
            $adresseCodePays = "";//$xmldetail->sessionFormation->inscriptions->adresse->codePays;
            $adressePays = "";//$xmldetail->sessionFormation->inscriptions->adresse->pays;
            $adressetelephone1 = "";//$xmldetail->sessionFormation->inscriptions->adresse->telephone1;
            $adressetelephone2 = "";//$xmldetail->sessionFormation->inscriptions->adresse->telephone2;
            $adressefax1 = "";//$xmldetail->sessionFormation->inscriptions->adresse->fax1;
            $adressemobile1 = "";//$xmldetail->sessionFormation->inscriptions->adresse->mobile1;
            $adressemobile2 = "";//$xmldetail->sessionFormation->inscriptions->adresse->mobile2;
            $adresseemail = "";//$xmldetail->sessionFormation->inscriptions->adresse->email;
            $adresseemail2 = "";//$xmldetail->sessionFormation->inscriptions->adresse->email2;
            $adressecodeInsee =  "";//$xmldetail->sessionFormation->inscriptions->adresse->codeInsee;
            $adresselongitude =  "";//$xmldetail->sessionFormation->inscriptions->adresse->longitude;
            $adresselatitude =  "";//$xmldetail->sessionFormation->inscriptions->adresse->latitude;
              // end adresse
            $inscriptionsDateDebutInscription = ""; //$xmldetail->sessionFormation->inscriptions->dateDebutInscription;
            $inscriptionsDateFinInscription = ""; //$xmldetail->sessionFormation->inscriptions->dateFinInscription;
            $inscriptionsparticipantMinimum = ""; //$xmldetail->sessionFormation->inscriptions->participantMinimum;
            $inscriptionsparticipantMaximum = ""; //$xmldetail->sessionFormation->inscriptions->participantMaximum;
            $inscriptionsRenseignementsInscriptions = ""; //$xmldetail->sessionFormation->inscriptions->renseignementsInscriptions;
              // end inscription

            $coutHebergement = ""; //$xmldetail->sessionFormation->coutHebergement;
            $coutPedagogique = ""; //$xmldetail->sessionFormation->coutPedagogique;
            $montantParStagiaire = ""; //$xmldetail->sessionFormation->montantParStagiaire;
            $infosMontant = ""; //$xmldetail->sessionFormation->infosMontant;
            $aideCR = ""; //$xmldetail->sessionFormation->aideCR;
            $aideCD = ""; //$xmldetail->sessionFormation->aideCD;
            $aideAutre = ""; //$xmldetail->sessionFormation->aideAutre;
            $budgetGlobal = ""; //$xmldetail->sessionFormation->budgetGlobal;
            $typePublic = ""; //$xmldetail->sessionFormation->typePublic;
            $publicConcerne = ""; //$xmldetail->sessionFormation->publicConcerne;
            $autre = ""; //$xmldetail->sessionFormation->autre;
            $objectifs = ""; //$xmldetail->sessionFormation->objectifs;
            $contenu = ""; //$xmldetail->sessionFormation->contenu;
            $nbHeures = ""; //$xmldetail->sessionFormation->nbHeures;
            $tFichiers = array();
            $dbOBS->getFichiersJoints($tFichiers, $idFormation, 'form');
          }    

          else 
          {
            $regionId = explode(" - ", $calendrier['comiteRegional'])[0];
            $codeNiveau = $calendrier['codeNiveau'];
            $libelleNiveau = $calendrier['libelleNiveau'];
            $codeActivite = $calendrier['codeActivite'];
            $libelleActivite = $calendrier['libelleActivite'];
            
            $codex = $calendrier['codex'];
            $nomEvenement = $calendrier['nomEvenement'];
            $libelleEvenement = $calendrier['libelleEvenement']; //nom de l'évènement initialisé dans les paramètres du calendrier
            $siteWebEvt = $calendrier['siteWeb'];
            //$emailStructure = $calendrier['lieuEvenement_email'];
            $emailEvt = $calendrier['lieuEvenement_email'];
            $telStructure = $calendrier['lieuEvenement_telephone1'];
            $mobileStructure = $calendrier['lieuEvenement_mobile1'];
            $latStructure = $calendrier['lieuEvenement_latitude'];
            $lngStructure = $calendrier['lieuEvenement_longitude'];
            $adresseComplete = "";
            //if ($calendrier['lieu'] != '') $adresseComplete .= $calendrier['lieu'] . '<br>';
            if ($calendrier['lieuEvenement_numero'] != '') $adresseComplete .= $calendrier['lieuEvenement_numero'] . ' '; 
            if ($calendrier['lieuEvenement_typeVoie'] != '') $adresseComplete .= $calendrier['lieuEvenement_typeVoie'] . ' ';
            if ($calendrier['lieuEvenement_nomVoie'] != '') $adresseComplete .= $calendrier['lieuEvenement_nomVoie'] . '<br>';
            if ($calendrier['lieuEvenement_lieuDit'] != '') $adresseComplete .= $calendrier['lieuEvenement_lieuDit'] . '<br>';
            if ($calendrier['lieuEvenement_codePostal'] != '') $adresseComplete .= $calendrier['lieuEvenement_codePostal'] . ', ' . $calendrier['lieuEvenement_ville'] . '<br>';
            if ($calendrier['lieuEvenement_pays'] != '') $adresseComplete .= $calendrier['lieuEvenement_pays'];

            $libellePagaieMinimum = $calendrier['libellePagaieMinimum'];

            $afficheUrl = $calendrier['urlPhoto'];
            if ($afficheUrl != null) $afficheUrl = str_replace('https', 'http', $afficheUrl);

        // récupération des fichiers joints
            $tFichiers = array();
            $dbOBS->getFichiersJoints($tFichiers, $codex);
          }


        // On initialise les variables générales
          if ( $calType == 'form') 
          {
            $libelle = $calendrier['typeFormation'];
            $sousLibelle = $calendrier['lieuSession'] . ' - ' . explode(" - ", $calendrier['structureOrganisatrice'])[1];
            $labels = '<span class="label label-default label-' . wd_remove_accents(strtolower($familleFormation)) . '">' . $familleFormation . '</span>&nbsp;&nbsp;';
            $labels .= '<span class="label label-default label-' . wd_remove_accents(strtolower($calendrier['typeQualification'])) . '">' . $calendrier['typeQualification'] . '</span>&nbsp;&nbsp;';
            
          }
          else if ( $calType == 'comp' || $calType == 'mani' || $calType == 'reun' || $calType == 'hani' ) 
          {
        $libelle = $nomEvenement;//$event->nomEvenement;
        $sousLibelle = ucfirst(strtolower($calendrier['lieuEvenement_ville']));
        $sousLibelle .= ',&nbsp;' . strtoupper($calendrier['lieuEvenement_pays']);//$xmldetail->manifestation->lieuEvenement->pays);
        if($calendrier['codeTypeEvenement'] == 'COMPOFF') {
          $labels = '<span class="label label-warning"><i class="fa fa-trophy"></i>&nbsp;&nbsp;' . $calendrier['libelleTypeEvenement'] . '</span>&nbsp;&nbsp;';
          $labels .= '<span class="label label-default label-' . wd_remove_accents(strtolower($libelleNiveau)) . '">' . $libelleNiveau . '</span>&nbsp;&nbsp;';
          if ( strtolower($nomEvenement) != strtolower($libelleEvenement) ) {
            $labels .= '<span class="label label-default">' . $libelleEvenement . '</span>';
          }
        }
        if($calendrier['codeTypeEvenement'] == 'COMPOPEN') {
          $labels = '<span class="label label-success"><i class="fa fa-trophy"></i>&nbsp;&nbsp;' . $calendrier['libelleTypeEvenement'] . '</span>&nbsp;&nbsp;';
          $labels .= '<span class="label label-default label-' . wd_remove_accents(strtolower($calendrier['libelleNiveau'])) . '">' . $calendrier['libelleNiveau'] . '</span>&nbsp;&nbsp;';
          if ( strtolower($calendrier['nomEvenement']) != strtolower($calendrier['libelleEvenement']) ) {
            $labels .= '<span class="label label-default">' . $calendrier['libelleEvenement'] . '</span>';
          }
        }
        if ( $calendrier['codeTypeEvenement'] == 'LOISIRS' ) {
          $libelle = $calendrier['nomEvenement'];
          $labels = '<span class="label label-info">' . $calendrier['libelleActivite'] . '</span>&nbsp;&nbsp;';
          $labels .= '<span class="label label-default">' . explode(" - ", $calendrier['structureOrganisatrice'])[1] . '</span>';
        }
        if ( $calendrier['codeTypeEvenement'] == 'ACTHN' ) {
          $labels = '<span class="label label-info">' . $calendrier['libelleActivite'] . '</span>&nbsp;&nbsp;';
          $labels .= '<span class="label label-default">' . $calendrier['libelleTypeEvenement'] . '</span>';
        }
      }
      ?>
      <?php if($count == 0): ?> 
        <div class="month month-<?php echo $dateDebut->format('m'); ?> month-first">
          <div class="titre-mois"><?php echo $dateDebut->format('F'); ?> <small><?php echo $dateDebut->format('Y'); ?></small></div>
        <?php endif; ?>
        <?php if($oldMonth != $dateDebut->format('F') && $count != 0): ?>
        </div>
        <div class="month month-<?php echo $dateDebut->format('m') ?>">
          <div class="titre-mois"><?php echo $dateDebut->format('F'); ?> <small><?php echo $dateDebut->format('Y'); ?></small></div>
        <?php endif; ?>

        <!-- 1 évènement -->

        <div class="panel panel-default panel-event panel-region-<?php echo $regionId ?> panel-niveau-<?php echo $codeNiveau ?> panel-activite-<?php echo $codeActivite; ?> panel-<?php echo wd_remove_accents(strtolower($typeQualification)); ?> panel-<?php echo wd_remove_accents(strtolower($familleFormation)); ?>">

          <!-- Titre de l'évènement -->
          <div class="panel-heading" role="tab" id="<?php if( $calType=='form') { echo $idFormation; } else { echo $codex; } ?>">
            <h4 class="panel-title">
              <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?php if( $calType=='form') { echo $idFormation; } else { echo $codex; } ?>" aria-expanded="true" aria-controls="collapse-<?php if( $calType=='form') { echo $idFormation; } else { echo $codex; } ?>">
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
          <div id="collapse-<?php if( $calType=='form') { echo $idFormation; } else { echo $codex; } ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="<?php if( $calType=='form') { echo $idFormation; } else { echo $codex;; } ?>">

            <!-- Détail manifestation -->
            <?php if($calType != 'form'): ?>
              <div class="panel-body" style="position:relative;">
                <div class="row" style="margin-bottom:10px;">
                  <div class="col-xs-12 col-sm-6">
                    <div class="col-xs-4 text-right no-hpadding">Organisateur :</div>
                    <div class="col-xs-8"><?php echo $calendrier['structureOrganisatrice']; ?></div>
                    <div class="col-xs-4 text-right no-hpadding">Contact :</div>
                    <div class="col-xs-8"><?php echo $calendrier['responsable_personne_civilite'] . ' ' .$calendrier['responsable_personne_prenom'] . ' ' . $calendrier['responsable_personne_nom'] ?></div>
                    <div class="col-xs-4 text-right no-hpadding">Requis :</div>
                    <div class="col-xs-8" style="margin-top:8px;">
                      <?php if($libellePagaieMinimum != ''): ?>
                        <span class="label label-default label-<?php echo wd_remove_accents(strtolower($libellePagaieMinimum)); ?>"><?php echo $libellePagaieMinimum ?></span>
                      <?php endif; ?>
                    </div>
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
                    <!-- Affichage des fichiers joints -->
                    <!-- Mettre dans une boucle -->
                    <?php foreach ($tFichiers as $fichier): ?>
                      <?php     
                      $nomFichier = explode("&nomFichier=", $fichier['fichier'])[1];
                      $nomFichier = explode("_", $fichier['fichier'])[1];
                      ?>
                      <a href="<?php echo $fichier['fichier']; ?>" class="btn btn-link" target="_blank"><?php echo $nomFichier; ?></a>
                    <?php endforeach; ?>

                  </div>
                </div>
                <div class="row" style="margin-top:8px;">
                  <div class="col-xs-12">
                    <?php if($siteWebEvt != ""): ?>
                      <a href="<?php echo $siteWebEvt ?>" class="btn btn-default btn-sm" target="_blank"><i class="fa fa-globe"></i>&nbsp;&nbsp;Site web</a>&nbsp;&nbsp;
                    <?php endif; ?>
                    <?php if($emailStructure != ""): // cette condition peut être suppimée ?>
                      <a href="mailto:<?php echo $emailStructure ?>" class="btn btn-default btn-sm"><i class="fa fa-envelope"></i>&nbsp;&nbsp;Email structure</a>&nbsp;&nbsp;
                    <?php endif; ?>
                    <?php if($emailEvt != ""): ?>
                      <a href="mailto:<?php echo $emailEvt ?>" class="btn btn-default btn-sm"><i class="fa fa-envelope"></i>&nbsp;&nbsp;Email</a>&nbsp;&nbsp;
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
                  <div class="col-xs-12 col-sm-12">
                    <!-- <?php //if($ligueStructureOrganisatrice!=''): ?>
                      <div class='col-xs-12'><?php //echo explode(" - ", $ligueStructureOrganisatrice)[1] ?></div>
                    <?php //endif; ?>

                    <?php //if($typeFormation!=''): ?><div class='col-xs-5 text-right'>Formation :</div>
                      <div class='col-xs-7'><?php //echo $typeFormation ?></div>
                      <?php //endif; ?> -->

<!--                    <?php //if($dateDebutExamen!=''): ?><div class='col-xs-5 text-right'>Début examen :</div>
                      <div class='col-xs-7'><?php //echo $dateDebutExamen ?></div>
                    <?php //endif; ?>

                    <?php //if($dateFinExamen!=''): ?><div class='col-xs-5 text-right'>Fin examen :</div>
                      <div class='col-xs-7'><?php //echo $dateFinExamen ?></div>
                      <?php //endif; ?> -->

                      <!-- <?php //if($lieuExamen!=''): ?><div class='col-xs-5 text-right'>Lieu examen :</div>
                        <div class='col-xs-7'><?php//echo $lieuExamen ?></div>
                        <?php //endif; ?> -->

                        <?php if($responsable!=''): ?><div class='col-xs-3 text-right'>Responsable :</div>
                          <div class='col-xs-9'><?php echo explode(" - ", $responsable)[1] ?></div>
                        <?php endif; ?>

                        <div class='col-xs-3 text-right'>Documents joints :</div>

                        

                        <div class="col-xs-9">
                          <?php if($tFichiers==null): ?>Aucun

                          <?php else: ?>                      
                            <!-- Affichage des fichiers joints -->
                            <!-- Mettre dans une boucle -->
                            <?php foreach ($tFichiers as $fichier): ?>
                              <?php     
                              $nomFichier = explode("&nomFichier=", $fichier['fichier'])[1];
                              $nomFichier = explode("_", $fichier['fichier'])[1];
                              ?>
                              <a href="<?php echo $fichier['fichier']; ?>" class="btn btn-link" target="_blank"><?php echo $nomFichier; ?></a><br/>
                            <?php endforeach; ?>
                            
                          <?php endif; ?>
                        </div>

                      <!-- <?php //if($inscriptionsDateDebutInscription!=''): ?><div class='col-xs-5 text-right'>Début inscription :</div>
                        <div class='col-xs-7'><?php// echo $inscriptionsDateDebutInscription ?></div>
                      <?php// endif; ?>

                      <?php// if($inscriptionsDateFinInscription!=''): ?><div class='col-xs-5 text-right'>Fin inscription :</div>
                        <div class='col-xs-7'><?php// echo $inscriptionsDateFinInscription ?></div>
                      <?php// endif; ?>

                      <?php //if($typePublic!=''): ?><div class='col-xs-5 text-right'>Type public :</div>
                        <div class='col-xs-7'><?php //echo $typePublic ?></div><?php //endif; ?>

                        <?php //if($nbHeures!=''): ?><div class='col-xs-5 text-right'>Nb heures :</div>
                          <div class='col-xs-7'><?php //echo $nbHeures ?></div><?php //endif; ?>
                        </div> -->
                        <!-- <div class="col-xs-12 col-sm-6">
                          <div class='col-xs-5 text-right'>Inscription :</div>
                          <div class='col-xs-7'>
                            <?php //if($inscriptionsContact!=''): ?><?php //echo explode(" - ", $inscriptionsContact)[1] ?><br><?php //endif; ?>
                            <?php //if($adresseApptEtageEsc!=''): ?><?php //echo $adresseApptEtageEsc ?><br><?php //endif; ?>
                            <?php //if($adresseImmBatRes!=''): ?><?php //echo $adresseImmBatRes ?><br><?php //endif; ?>
                            <?php //if($adresseNumero!=''): ?><?php //echo $adresseNumero ?><br><?php //endif; ?>
                            <?php //if($adressetypeVoie!=''): ?><?php //echo $adressetypeVoie ?><br><?php //endif; ?>
                            <?php //if($adressenomVoie!=''): ?><?php //echo $adressenomVoie ?><br><?php //endif; ?>
                            <?php //if($adresselieuDit!=''): ?><?php //echo $adresselieuDit ?><br><?php //endif; ?>
                            <?php //if($adressecodePostal!=''): ?><?php //echo $adressecodePostal ?><br><?php //endif; ?>
                            <?php //if($adresseville!=''): ?><?php //echo $adresseville ?><br><?php //endif; ?>
                            <?php //if($adressePays!=''): ?><?php //echo $adressePays ?><br><?php //endif; ?>
                          </div>-->
                        </div> 
                      </div>
                      <div class="row">
                        <?php if($inscriptionsRenseignementsInscriptions!=''): ?>
                          <div class='col-xs-5 text-right'>Renseignements inscriptions :</div>
                          <div class='col-xs-7'><?php echo $inscriptionsRenseignementsInscriptions ?></div>
                        <?php endif; ?>
                      </div>

                      <div class="row">
                        <?php if($renseignementsInformations!=''): ?>
                          <div class='col-xs-12'>Informations complémentaires :</div>
                          <div class='col-xs-12'><?php echo $renseignementsInformations ?></div>
                        <?php endif; ?>
                      </div>

                      <div class="row">


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

              <?php $oldMonth = $dateDebut->format('F'); $count++; ?> <!-- A quoi cela sert ? -->
            <?php endforeach; ?>

          </div> <!-- /.month -->
        </div> <!-- /.panel-group -->