<?php
/* TODO: trouver une solution pour appeler le fichier ws-config.php */
header('Access-Control-Allow-Origin: http://ffck-goal.multimediabs.com/');
header('Access-Control-Allow-Origin: http://ffck-goal-prp.multimediabs.com/');
function simplexml_load_file_from_url($url, $timeout = 10){
  $opts = array(
    'http' => array(
      'timeout' => (int)$timeout
      )
    );
  $context = stream_context_create($opts);
  $data = file_get_contents($url, false, $context);
  // print_r($data);
  if(!$data){
    echo 'Délai d\'attente dépassé : les données n\'ont pas pu être chargées.';
    trigger_error('Cannot load data from url: ' . $url, E_USER_NOTICE);
    return false;
  }
  return simplexml_load_string($data);
}

// remplacer par la fonction getstructure


function getStructures($codeStructureMere, $details = 'false')
{
  global $wsUrl;

  $wsEndpoint = "http://" . getenv("OBS_USER") . ":" . getenv("OBS_PASSWORD") . "@" . getenv("OBS_HOST") . "/wsprivate";

  $url = $wsEndpoint . "/structures/annuaire?codeStructureMere=" . $codeStructureMere .
  "&moreDetails=" . $details;

  $xml = simplexml_load_file_from_url($url);

  //echo '<p>' . $url . '</p>';

  return $xml;
}


?>
<!-- fin partie en provenance de ws-config -->




<!-- affichage des Comités -->
<?php $comitesRegionaux =  getStructures(0); ?>



<div class="vc_row wpb_row vc_row-fluid">
  <div class="wpb_column vc_column_container vc_col-sm-12">
    <div class="vc_column-inner ">
      <div class="wpb_wrapper">
        <div class="wpb_text_column wpb_content_element ">
          <div class="wpb_wrapper">
            <h4>Comités régionaux et départementaux</h4>
          </div>
        </div>
        <div class="vc_tta-container" data-vc-action="collapseAll">
          <div class="vc_general vc_tta vc_tta-accordion vc_tta-color-grey vc_tta-style-modern vc_tta-shape-rounded vc_tta-o-shape-group vc_tta-controls-align-left vc_tta-o-all-clickable">
            <div class="vc_tta-panels-container">
              <div class="vc_tta-panels">
                <?php foreach ($comitesRegionaux->structures->structure as $crck):  ?>


                  <?php if($crck->etat == 'Actif' && $crck->code != 99) : ?>

                   <?php
                   $etat = $crck->etat;
                   $code = $crck->code;
                   $nom = $crck->nom;
                   $urlSiteWeb = $crck->siteWeb;
           $siteWeb = substr($urlSiteWeb,7); //explode(" / ", )[1];
           $adresseComplete = "";
           if ($crck->adresseCorrespondance->numero != '') $adresseComplete .= $crck->adresseCorrespondance->numero . ' ';
           if ($crck->adresseCorrespondance->typeVoie != '') $adresseComplete .= $crck->adresseCorrespondance->typeVoie . ' ';
           if ($crck->adresseCorrespondance->nomVoie != '') $adresseComplete .= $crck->adresseCorrespondance->nomVoie . '<br>';
           if ($crck->adresseCorrespondance->lieuDit != '') $adresseComplete .= $crck->adresseCorrespondance->lieuDit . '<br>';
           if ($crck->adresseCorrespondance->codePostal != '') $adresseComplete .= $crck->adresseCorrespondance->codePostal . ', ' . $crck->adresseCorrespondance->ville . '<br>';
           $telephone1 = $crck->adresseCorrespondance->telephone1;
           $mobile1 = $crck->adresseCorrespondance->mobile1;
           $email = $crck->adresseCorrespondance->email;
           $longitude = $crck->adresseCorrespondance->longitude;
           $latitude = $crck->adresseCorrespondance->latitude;
           $comitesDepartementaux = getStructures($code);
           ?>

           <div class="vc_tta-panel" id="<?php echo $code; ?>" data-vc-content=".vc_tta-panel-body">
            <div class="vc_tta-panel-heading">
              <h4 class="vc_tta-panel-title vc_tta-controls-icon-position-left">
                <a href="#<?php echo $code; ?>" data-vc-accordion="" data-vc-container=".vc_tta-container">
                  <span class="vc_tta-title-text"><?php echo $nom; ?></span>
                  <i class="vc_tta-controls-icon vc_tta-controls-icon-chevron">
                  </i>
                </a>
              </h4>
            </div>
            <div class="vc_tta-panel-body">

              <div class="wpb_text_column wpb_content_element ">
                <div class="wpb_wrapper">
                  <div class="row">
                    <div class="col-md-6">
                      <h5>Contact</h5>
                      <?php if($telephone1 != ''): ?><p><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $telephone1; ?></p> <?php endif; ?>
                      <?php if($mobile1 != ''): ?><p><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $mobile1; ?></p> <?php endif; ?>
                      <?php if($email != ''): ?><p><i class="fa fa-envelope-o" aria-hidden="true"></i></i><a href="mailto:<?php  echo $email ?>"> <?php echo $email; ?></a></p> <?php endif; ?>
                      <?php if($urlSiteWeb != ''): ?><p><a href="<?php echo $urlSiteWeb; ?>"><?php echo $siteWeb; ?></a></p><?php endif; ?>

                    </div>
                    <div class="col-md-6">
                      <h5>Adresse</h5>
                      <p><?php echo $adresseComplete; ?></p>
                    </div>
                  </div>



                </div>
              </div>
              <h5>Comités départementaux</h5>
              <?php foreach ($comitesDepartementaux->structures->structure as $cdck):  ?>
                <?php if($cdck->etat == 'Actif') : ?>
                  <?php
                  $etatCdck = $cdck->etat;
                  $codeCdck = $cdck->code;
                  $nomCdck = $cdck->nom;
                  $urlSiteWebCdck = $cdck->siteWeb;
                  $siteWebCdck = substr($urlSiteWebCdck,7);
                  $adresseCompleteCdck = "";
                  if ($cdck->adresseCorrespondance->numero != '') $adresseCompleteCdck .= $cdck->adresseCorrespondance->numero . ' ';
                  if ($cdck->adresseCorrespondance->typeVoie != '') $adresseCompleteCdck .= $cdck->adresseCorrespondance->typeVoie . ' ';
                  if ($cdck->adresseCorrespondance->nomVoie != '') $adresseCompleteCdck .= $cdck->adresseCorrespondance->nomVoie . '<br>';
                  if ($cdck->adresseCorrespondance->lieuDit != '') $adresseCompleteCdck .= $cdck->adresseCorrespondance->lieuDit . '<br>';
                  if ($cdck->adresseCorrespondance->codePostal != '') $adresseCompleteCdck .= $cdck->adresseCorrespondance->codePostal . ', ' . $cdck->adresseCorrespondance->ville . '<br>';
                  $telephone1Cdck = $cdck->adresseCorrespondance->telephone1;
                  $mobile1Cdck = $cdck->adresseCorrespondance->mobile1;
                  $emailCdck = $cdck->adresseCorrespondance->email;
                  $longitudeCdck = $cdck->adresseCorrespondance->longitude;
                  $latitudeCdck = $cdck->adresseCorrespondance->latitude;
                  ?>

                  <div id="<?php echo $codeCdck; ?>" class="vc_toggle vc_toggle_default vc_toggle_color_default  vc_toggle_size_md">
                    <div class="vc_toggle_title">
                      <h4><?php echo $nomCdck; ?></h4>
                      <i class="vc_toggle_icon">
                      </i>
                    </div>
                    <div class="vc_toggle_content">
                      <div class="row">
                        <div class="col-md-6">
                          <h5>Contact</h5>
                          <?php if($telephone1Cdck != ''): ?><p><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $telephone1Cdck; ?></p> <?php endif; ?>
                          <?php if($mobile1Cdck != ''): ?><p><i class="fa fa-phone" aria-hidden="true"></i> <?php echo $mobile1Cdck; ?></p> <?php endif; ?>
                          <?php if($emailCdck != ''): ?><p><i class="fa fa-envelope-o" aria-hidden="true"></i><a href="mailto:<?php  echo $emailCdck ?>"> <?php echo $emailCdck; ?></a></p> <?php endif; ?>
                          <?php if($urlSiteWebCdck != ''): ?><p><a href="<?php echo $urlSiteWebCdck; ?>"><?php echo $siteWebCdck; ?></a></p><?php endif; ?>

                        </div>
                        <div class="col-md-6">
                          <h5>Adresse</h5>
                          <p><?php echo $adresseCompleteCdck; ?></p>
                        </div>
                      </div>
                    </div>
                  </div>

                <?php endif ?>
              <?php endforeach; ?>
            </div>
          </div>


        <?php endif ?>

      <?php endforeach; ?>
    </div>
  </div>
</div>
</div>
</div>
</div>
</div>
</div>

<!-- fin affichage des comités -->
